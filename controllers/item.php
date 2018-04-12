<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	//function use to redirect on the page with data when check login status//

	public function __construct()
        {
                parent::__construct();

                $this->load->helper('item');
                $this->load->helper('dompdf');
        }

	public function RedirectToPageWithData($view,$data)
	{
	if($this->session->userdata('id')!="" and $this->session->userdata('user')!="" and $this->session->userdata('pass')!="")
		{
		$this->load->view($view,$data);
		}
		else
		{
		session_destroy();
		redirect(base_url(), 'refresh');
		}
	}

	public function mypdf()
		{
	  		$this->load->library('pdf');
	  		$this->pdf->load_view('item/excel');
	  		$this->pdf->render();
	  		$this->pdf->stream("welcome.pdf");
	 	}

	 public function toExcel()
		{
			$html = $this->load->view('item/excel');
	  	}

	public function add()
	{
		if( !is_UserAllowed('add_item')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Add Item';
		$data['suppliers'] = GetAllSupplier();
		$data['units']=$this->db->get_where('item_unit',array('status'=>'1'))->result_array();
		$data['categories']=$this->db->get_where('item_category',array('status'=>'1'))->result_array();
		$data['countries']=$this->db->get_where('item_country')->result_array();
		$data['innerboxes']=$this->db->get_where('item_innerbox',array('status'=>'1'))->result_array();
		$data['outerboxes']=$this->db->get_where('item_outerbox',array('status'=>'1'))->result_array();
		$data['weights']=$this->db->get_where('item_weight_unit',array('status'=>'1'))->result_array();
		$data['items']= GetItem();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('item/add_item',$data);
	}

	public function view($id)
	{
		if( !is_UserAllowed('view_item')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='View Item';
		$data['items']= $this->db->get_where('item',array('status'=>'1', 'ITEM_ASSEMBLED'=>'0', 'CATEGORY_NAME'=>'8'))->result_array();
		$data['item']=$this->db->get_where('item',array('ID'=>$id))->row();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('item/view_item',$data);
	}

	public function edit($id)
	{
		if( !is_UserAllowed('update_item')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Edit Item';
		$data['suppliers']= GetAllSupplier();
		$data['units']=$this->db->get_where('item_unit',array('status'=>'1'))->result_array();
		$data['categories']=$this->db->get_where('item_category',array('status'=>'1'))->result_array();
		$data['countries']=$this->db->get_where('item_country')->result_array();
		$data['innerboxes']=$this->db->get_where('item_innerbox',array('status'=>'1'))->result_array();
		$data['outerboxes']=$this->db->get_where('item_outerbox',array('status'=>'1'))->result_array();
		$data['item']=$this->db->get_where('item',array('ID'=>$id))->row();
		$data['allitems']= GetItem();
		$this->RedirectToPageWithData('item/update_item',$data);
	}

	public function edit_subitem($id)
	{
		$data['title']='Edit Sub Item';
		$data['items']= $this->db->get_where('item',array('status'=>'1', 'ITEM_ASSEMBLED'=>'0'))->result_array();
		$data['subitems']= GetSubItemData($id);
		$this->RedirectToPageWithData('item/update_sub-item',$data);
	}

	public function DeleteItem($id)
	{
		$result = $this->Admin_model->DeleteItem($id);

		if ($result == false) // the information has therefore been successfully saved in the db
			{
			$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
			redirect(base_url().'item/listitems');   // or whatever logic needs to occur
			}
			else
			{
			$this->session->set_flashdata('msg','<span class="text-green">New user added successfully.</span>');
			redirect(base_url().'item/listitems');   // or whatever logic needs to occur
			}
	}

	public function listitems()
	{
		if( !is_UserAllowed('all_item')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='All Item';
		$data['categories']=$this->db->get_where('item_category',array('status'=>'1'))->result_array();
		//$data['items']=$this->db->get_where('item',array('status'=>'1'))->result_array();
		$this->RedirectToPageWithData('item/list_item',$data);
	}

	function fetch_items()
		{
						$fetch_data = $this->Admin_model->make_datatables();
           	$data = array();
           	$no = $_POST['start'];

           	foreach($fetch_data as $row)
           	{
           		$no++;
           		if( $row->ITEM_IMAGE ):
					$image = "<a href=".base_url('item/view').'/'.$row->ID."><img style='width:100px' src=".base_url().'uploads/item_images/'.$row->ITEM_IMAGE." /></a>";
				else :
					$image = "<a href=".base_url('item/view').'/'.$row->ID."><img style='width:100px' src='".base_url()."uploads/no-image-available.jpg' /></a>";
				endif;

				if( is_UserAllowed('view_item'))
					{
						$view = "<a style='color:green;' href='".base_url('item/view')."/".$row->ID."'>View</a>";
					}

				if( is_UserAllowed('update_item'))
					{
						$update = "<a style='color:orange;' href='".base_url('item/edit')."/".$row->ID."'>Update</a>";
					}

                $sub_array = array();
                $sub_array[] = $no;
                $sub_array[] = $image;
                $sub_array[] = "<a href='".base_url('item/view')."/".$row->ID."'>".$row->ITEM_CODE."</a>";
                $sub_array[] = $row->HSN_CODE;
                $sub_array[] = $row->ITEM_DESC;
                $sub_array[] = Get_Item_Category_Name( $row->CATEGORY_NAME );
                $sub_array[] = GetSupplierData( $row->SUPPLIER_ID )->supplier_name;
                $sub_array[] = GetItemUnit( $row->ITEM_UNIT );
                $sub_array[] = '';
                $sub_array[] = $view .' '.$update;
                $data[] = $sub_array;

                //$i++;
           	}

          	$output = array(
                "draw"					=>     intval($_POST["draw"]),
                "recordsTotal"          =>     $this->Admin_model->get_all_data(),
                "recordsFiltered"     	=>     $this->Admin_model->get_filtered_data(),
                "data"                  =>     $data
           );

           	echo json_encode($output);

		}

	function saveItem()
	{
		$assemble = @$this->input->post('item_assembled');

		if( empty($assemble))
			{
				$assemble_val = '0';
			}
		else
			{
				$assemble_val = '1';
			}

		// $inner_qty = @$this->input->post('inner_qty');
//
// 		if( empty($inner_qty))
// 			{
// 				$inner_qty = '0';
// 			}
// 		else
// 			{
// 				$inner_qty = $inner_qty;
// 			}
//
// 		$outer_qty = @$this->input->post('outer_qty');
//
// 		if( empty($outer_qty))
// 			{
// 				$outer_qty = '0';
// 			}
// 		else
// 			{
// 				$outer_qty = $outer_qty;
// 			}

		$this->form_validation->set_message('is_unique', 'This %s is already exist');
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('item_code','Item Code',  'required|is_unique[item.ITEM_CODE]');
	    $this->form_validation->set_rules('item_category','Category Name',  'required');
	    $this->form_validation->set_rules('item_country','Country ID',  'required');
	    $this->form_validation->set_rules('item_desc','Item Description',  'required');
	    $this->form_validation->set_rules('supplier','Supplier',  'required');
	    $this->form_validation->set_rules('item_unit','Item Unit',  'required');
		$this->form_validation->set_rules('purchase_price','Purchase Price',  'required');
		$this->form_validation->set_rules('purchase_price_code','Purchase Price Code',  'required');
		$this->form_validation->set_rules('hsn_code','HSN Code',  'required');
	    $this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->add();
			}
		else // passed validation proceed to post success logic
			{

				if($_FILES['item_image']['name']!='')
					{
						$config['image_library'] = 'ImageMagick';
						$config['upload_path'] = './uploads/item_images/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['quality']	= '80';

						$this->load->library('upload');

						$this->upload->initialize($config);
						$UploadLogo=$this->upload->do_upload('item_image');
						$Logoinfo=$this->upload->data();
						$uploadedImageName=$Logoinfo['file_name'];

					}
				else
					{
						$uploadedImageName='';
					}

				$sup_id = @$this->input->post('supplier');
				$INNER_BOX_QTY = $this->input->post('outer_qty');

				$ItemData = array(
					'ITEM_ID' => time(),
					'ITEM_CODE' => @$this->input->post('item_code'),
					'CATEGORY_NAME' => @$this->input->post('item_category'),
					'COUNTRY_ID' => @$this->input->post('item_country'),
					'ITEM_DESC' => @$this->input->post('item_desc'),
					'ITEM_CUSTOM_DESC' => @$this->input->post('item_custom_desc'),
					'SUPPLIER_ID' => implode(',', $sup_id),
					'MANUFACTURING_TIMEFRAME' => @$this->input->post('man_timeframe'),
					'ITEM_UNIT' => @$this->input->post('item_unit'),
					'INNER_BOX' => @$this->input->post('inner_box'),
					'INNER_BOX_QTY' => $INNER_BOX_QTY,
					'OUTER_BOX' => @$this->input->post('outer_box'),
					'OUTER_BOX_QTY' => @$this->input->post('outer_qty'),
					'PURCHASE_PRICE' => @$this->input->post('purchase_price'),
					'PURCHASE_PRICE_CODE' => @$this->input->post('purchase_price_code'),
					'HSN_CODE' => @$this->input->post('hsn_code'),
					'NET_WEIGHT' => @$this->input->post('net_weight'),
					'rd_catelog_page' => @$this->input->post('rd_catelog_page'),
					'oceanic_catelog_page' => @$this->input->post('oceanic_catelog_page'),
					'rep_binder_page' => @$this->input->post('rep_binder_page'),
					'ITEM_IMAGE' => $uploadedImageName,
					'ITEM_ASSEMBLED' => $assemble_val,
					'STATUS' => '1'
				);

				// run insert model to write data to db
				$result = $this->Admin_model->SaveItem($ItemData);

				if($result)
					{
						if( $assemble )
							{
								$this->session->set_flashdata('msg','<span class="text-green">New Item added successfully. Please add Sub Item.</span>');
								redirect(base_url().'item/view/'.$result);   // or whatever logic needs to occur
							}
						else
							{
								$this->session->set_flashdata('msg','<span class="text-green">New Item added successfully.</span>');
								redirect(base_url().'item/add');   // or whatever logic needs to occur
							}
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'item/add');   // or whatever logic needs to occur
					}
			}
	}

	function saveSubItem($id)
	{
		$item_sub_id = @$this->input->post('sv_item_id');

		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('sub_item','Item',  'required');
	    $this->form_validation->set_rules('sub_item_qty','Item Quantity',  'required|numeric');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->view($id);
			}
		else // passed validation proceed to post success logic
			{
				$SubItem = array(
						'PARENT_ITEM_ID' => @$this->input->post('sv_item_id'),
						'ITEM_ID' => @$this->input->post('sub_item'),
						'QUANTITY' => @$this->input->post('sub_item_qty'),
						);

				$result = $this->Admin_model->SaveSubItem($SubItem);
				$parent_item_id = $this->db->get_where('sub_item',array('ID'=> $result))->row('PARENT_ITEM_ID');
				$item_id = $this->db->get_where('item',array('ITEM_ID'=> $parent_item_id))->row('ID');

				if($result)
					{
						$this->session->set_flashdata('msg','<span class="text-green">New Sub Item added successfully.</span>');
						redirect( base_url().'item/view/'.$item_id );   // or whatever logic needs to occur
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect( base_url().'item/view/');   // or whatever logic needs to occur

					}
			}
	}

	function remove_sub_item($id)
	{

		$parent_item_id = $this->db->get_where('sub_item',array('ID'=> $id))->row('PARENT_ITEM_ID');
		$item_id = $this->db->get_where('item',array('ITEM_ID'=> $parent_item_id))->row('ID');

		$result = $this->Admin_model->RemoveSubItem($id);

		if($result)
			{
				$this->session->set_flashdata('msg','<span class="text-green">New Sub Item added successfully.</span>');
				redirect( base_url().'item/view/'.$item_id );   // or whatever logic needs to occur
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect( base_url().'item/view/');   // or whatever logic needs to occur

			}
	}

	function update_sub_item($id)
	{
		$item_sub_id = @$this->input->post('sv_item_id');

		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('sub_item','Item',  'required');
	    $this->form_validation->set_rules('sub_item_qty','Item Quantity',  'required');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->edit_subitem($id);
			}
		else // passed validation proceed to post success logic
			{
				$SubItem = array(
						'PARENT_ITEM_ID' => @$this->input->post('sv_item_id'),
						'ITEM_ID' => @$this->input->post('sub_item'),
						'QUANTITY' => @$this->input->post('sub_item_qty'),
					);

				$result = $this->Admin_model->UpdateSubItem($id, $SubItem);

				$parent_item_id = $this->db->get_where('sub_item',array('ID'=> $result))->row('PARENT_ITEM_ID');
				$item_id = $this->db->get_where('item',array('ITEM_ID'=> $parent_item_id))->row('ID');

				if($result)
					{
						$this->session->set_flashdata('msg','<span class="text-green">New Sub Item added successfully.</span>');
						redirect( base_url().'item/edit_subitem/'.$result );   // or whatever logic needs to occur
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect( base_url().'item/edit_subitem/');   // or whatever logic needs to occur

					}
			}
	}

	function hasSameItemCodee($code, $id)
		{
			$data = $this->Admin_model->hasSameItemCode($code, $id);

			if(empty($data))
				{
					return true;
				}
			else
				{
					$this->form_validation->set_message('hasSameItemCodee', '%s already exist');

					return false;

				}

		}

	function updateItem($id)
	{

		$assemble = @$this->input->post('item_assembled');

		if( empty($assemble))
			{
				$assemble_val = '0';
			}
		else
			{
				$assemble_val = '1';
			}

		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('item_code','Item code',  'required|callback_hasSameItemCodee['.$id.']');
	    $this->form_validation->set_rules('item_category','Category Name',  'required');
	    $this->form_validation->set_rules('item_country','Country Name',  'required');
	    $this->form_validation->set_rules('item_desc','Item Description',  'required');
	    $this->form_validation->set_rules('supplier','Supplier',  'required');
	    $this->form_validation->set_rules('item_unit','Item Unit',  'required');
	    //$this->form_validation->set_rules('inner_box','Inner Box',  'required');
	    //$this->form_validation->set_rules('inner_qty','Quantity in Inner Box',  'required');
	    //$this->form_validation->set_rules('outer_box','Outer Box',  'required');
		//$this->form_validation->set_rules('outer_qty','Inner Box Quantity',  'required');
		$this->form_validation->set_rules('purchase_price','Purchase Price',  'required');
		$this->form_validation->set_rules('purchase_price_code','Purchase Price Code',  'required');
		$this->form_validation->set_rules('hsn_code','HSN Code',  'required');
		//$this->form_validation->set_rules('net_weight','Net Weight',  'required');
		//$this->form_validation->set_rules('rd_catelog_page','RD Catelog Page',  'required');
		//$this->form_validation->set_rules('oceanic_catelog_page','Oceanic Catelog Page',  'required');
		//$this->form_validation->set_rules('rep_binder_page','Rep Binder Page',  'required');
	    $this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->edit($id);
			}
		else // passed validation proceed to post success logic
			{

				if($_FILES['item_image']['name']!='')
					{
						$config['image_library'] = 'ImageMagick';
						$config['upload_path'] = './uploads/item_images/';
						$config['allowed_types'] = 'gif|jpg|png|jpeg';
						$config['quality']	= '80';

						$this->load->library('upload');

						$this->upload->initialize($config);
						$UploadLogo=$this->upload->do_upload('item_image');
						$Logoinfo=$this->upload->data();
						$uploadedImageName=$Logoinfo['file_name'];

						$ItemData['ITEM_IMAGE'] = $uploadedImageName;
					}
				else
					{
						$uploadedImageName='';
					}

				$sup_id = @$this->input->post('supplier');

				$ItemData = array(
					'ITEM_ID' => @$this->input->post('item_id'),
					'ITEM_CODE' => @$this->input->post('item_code'),
					'CATEGORY_NAME' => @$this->input->post('item_category'),
					'COUNTRY_ID' => @$this->input->post('item_country'),
					'ITEM_DESC' => @$this->input->post('item_desc'),
					'ITEM_CUSTOM_DESC' => @$this->input->post('item_custom_desc'),
					'SUPPLIER_ID' => implode(',', $sup_id),
					'MANUFACTURING_TIMEFRAME' => @$this->input->post('man_timeframe'),
					'ITEM_UNIT' => @$this->input->post('item_unit'),
					'INNER_BOX' => @$this->input->post('inner_box'),
					//'INNER_BOX_QTY' => (empty(@$this->input->post('inner_qty')) ? null : "@$this->input->post('inner_qty')"),
					'INNER_BOX_QTY' => @$this->input->post('inner_qty'),
					'OUTER_BOX' => @$this->input->post('outer_box'),
					//'OUTER_BOX_QTY' => (empty(@$this->input->post('outer_qty')) ? null : "@$this->input->post('outer_qty')"),
					'OUTER_BOX_QTY' => @$this->input->post('outer_qty'),
					'PURCHASE_PRICE' => @$this->input->post('purchase_price'),
					'PURCHASE_PRICE_CODE' => @$this->input->post('purchase_price_code'),
					'HSN_CODE' => @$this->input->post('hsn_code'),
					'NET_WEIGHT' => @$this->input->post('net_weight'),
					'rd_catelog_page' => @$this->input->post('rd_catelog_page'),
					'oceanic_catelog_page' => @$this->input->post('oceanic_catelog_page'),
					'rep_binder_page' => @$this->input->post('rep_binder_page'),
					'ITEM_IMAGE' => $uploadedImageName,
					'ITEM_ASSEMBLED' => $assemble_val,
					'STATUS' => '1'
				);

				// var_dump($ItemData);
// 				die();

				$result = $this->Admin_model->UpdateItem($id, $ItemData);

				if($result)
					{
						if( $assemble )
							{
								$this->session->set_flashdata('msg','<span class="text-green">Item has been Updated successfully. Please add Sub Item.</span>');
								redirect(base_url().'item/view/'.$result);   // or whatever logic needs to occur
							}
						else
							{
								$this->session->set_flashdata('msg','<span class="text-green">Item has been Updated successfully.</span>');
								redirect(base_url().'item/view/'.$result);   // or whatever logic needs to occur
							}
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'item/edit/'.$result);   // or whatever logic needs to occur
					}
			}
	}

	public function listitemcategory()
	{
		if( !is_UserAllowed('add_category')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Item Categories';
		$data['form_title']='Add Category';
		$data['table_title']='Manage Categories';
		$data['CatArray']=$this->db->get_where('item_category',array('status'=>'1'))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('item/item_category',$data);
	}

	function add_category()
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('cat_name','Category Name',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->listitemcategory();
			}
				else // passed validation proceed to post success logic
			{

		$CatData = array(
					'CATEGORY_NAME' => @$this->input->post('cat_name'),
					'STATUS' => '1'
		);

		$result = $this->Admin_model->SaveItemCat($CatData);

		if ($result == false) // the information has therefore been successfully saved in the db
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'item/listitemcategory');   // or whatever logic needs to occur
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-green">New category added successfully.</span>');
				redirect(base_url().'item/listitemcategory');   // or whatever logic needs to occur
			}
		}
	}

	public function listitemcountry()
	{
		//if( !is_UserAllowed('add_category')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Item Country';
		$data['form_title']='Add Country';
		$data['table_title']='Manage Countries';
		$data['country_array']=$this->db->get_where('item_country')->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('item/item_country',$data);
	}

	function add_country()
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('country_name','Country Name',  'required');
		$this->form_validation->set_rules('country_code','Country Code',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->listitemcountry();
			}
				else // passed validation proceed to post success logic
			{

		$data = array(
					'country_name' => @$this->input->post('country_name'),
					'country_code' => @$this->input->post('country_code'),
			);

		$result = $this->Admin_model->SaveItemCountry($data);

		if ($result == false) // the information has therefore been successfully saved in the db
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'item/listitemcountry');   // or whatever logic needs to occur
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-green">New Country added successfully.</span>');
				redirect(base_url().'item/listitemcountry');   // or whatever logic needs to occur
			}
		}
	}

	public function UpdateCountry($id)
	{
		//if( !is_UserAllowed('update_category')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Countries';
		$data['form_title']='Update Countries';
		$data['table_title']='Manage Countries';
		$data['country_array']=$this->db->get_where('item_country')->result_array();
		$data['country']=$this->db->get_where('item_country',array('id'=>$id))->row();
		$this->RedirectToPageWithData('item/update_country',$data);
	}

	function update_country($id)
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('country_name','Country Name',  'required');
		$this->form_validation->set_rules('country_code','Country Code',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
		{
			$this->UpdateCountry($id);
		}
		else // passed validation proceed to post success logic
		{

		// build array for the model
		$data = array(
			'country_name' => @$this->input->post('country_name'),
			'country_code' => @$this->input->post('country_code')
		);

		// run insert model to write data to db
		$result = $this->Admin_model->UpdateCountry($id, $data);

		if ($result == false) // the information has therefore been successfully saved in the db
			{
			$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
			redirect(base_url().'item/listitemcountry/');   // or whatever logic needs to occur
			}
			else
			{
			$this->session->set_flashdata('msg','<span class="text-green">Country has been updated successfully.</span>');
			redirect(base_url().'item/listitemcountry/');   // or whatever logic needs to occur
			}
		}
	}

	public function listinnerbox()
	{
		if( !is_UserAllowed('add_inner_box')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Inner Boxes';
		$data['form_title']='Add Inner Box';
		$data['table_title']='Manage Inner Boxes';
		$data['InnerArray']=$this->db->get_where('item_innerbox',array('status'=>'1'))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('item/inner_box',$data);
	}

	function add_inner_box()
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('ib_size','Inner Box Size',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->listinnerbox();
			}
				else // passed validation proceed to post success logic
			{

		$IBData = array(
					'INNER_BOX_SIZE' => @$this->input->post('ib_size'),
					'STATUS' => '1'
		);

		$result = $this->Admin_model->SaveItemInnerBox($IBData);

		if ($result == false) // the information has therefore been successfully saved in the db
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'item/listinnerbox');   // or whatever logic needs to occur
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-green">New size added successfully.</span>');
				redirect(base_url().'item/listinnerbox');   // or whatever logic needs to occur
			}
		}
	}

	public function listouterbox()
	{
		if( !is_UserAllowed('add_outer_box')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Outer Boxes';
		$data['form_title']='Add Outer Boxes';
		$data['table_title']='Manage Outer Boxes';
		$data['OuterArray']=$this->db->get_where('item_outerbox',array('status'=>'1'))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('item/outer_box',$data);
	}

	function add_outer_box()
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('ob_size','Outer Box Size',  'required');
		$this->form_validation->set_rules('ob_cbm','CBM',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->listouterbox();
			}
				else // passed validation proceed to post success logic
			{

		$OBData = array(
					'OUTER_BOX_SIZE' => @$this->input->post('ob_size'),
					'CBM' => @$this->input->post('ob_cbm'),
					'STATUS' => '1'
		);

		$result = $this->Admin_model->SaveItemOuterBox($OBData);

		if ($result == false) // the information has therefore been successfully saved in the db
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'item/listouterbox');   // or whatever logic needs to occur
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-green">New size added successfully.</span>');
				redirect(base_url().'item/listouterbox');   // or whatever logic needs to occur
			}
		}
	}

	public function listweight()
	{
		$data['title']='Weight Unit';
		$data['form_title']='Add Weight Units';
		$data['table_title']='Manage Weight Units';
		$data['weights']=$this->db->get_where('item_weight_unit',array('status'=>'1'))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('item/weight_units',$data);
	}

	function add_weight_unit()
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('weight_unit','Weight Unit',  'required');
		$this->form_validation->set_rules('description','Description',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->listweight();
			}
				else // passed validation proceed to post success logic
			{

		$data = array(
					'weight_unit' => @$this->input->post('weight_unit'),
					'description' => @$this->input->post('description'),
		);

		$result = $this->Admin_model->SaveWeightUnit($data);

		if ($result == false) // the information has therefore been successfully saved in the db
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'item/listweight');   // or whatever logic needs to occur
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-green">New size added successfully.</span>');
				redirect(base_url().'item/listweight');   // or whatever logic needs to occur
			}
		}
	}

	public function listunits()
	{
		if( !is_UserAllowed('add_unit')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Units';
		$data['form_title']='Add Units';
		$data['table_title']='Manage Units';
		$data['UnitArray']=$this->db->get_where('item_unit',array('status'=>'1'))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('item/item_units',$data);
	}

	public function updateunit($id)
	{
		if( !is_UserAllowed('update_unit')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Units';
		$data['form_title']='Update Units';
		$data['table_title']='Manage Units';
		$data['UnitArray']=$this->db->get_where('item_unit',array('status'=>'1'))->result_array();
		$data['unit']=$this->db->get_where('item_unit',array('ID'=>$id))->row();
		$this->RedirectToPageWithData('item/update_item_unit',$data);
	}

	function add_unit()
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('unit_name','Unit Name',  'required');
	    $this->form_validation->set_rules('unit_description','Unit Description',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
		{
		$this->listunits();
		}
		else // passed validation proceed to post success logic
		{

		// build array for the model
		$UnitData = array(
						'UNIT_NAME' => @$this->input->post('unit_name'),
						'UNIT_DESCRIPTION' => @$this->input->post('unit_description'),
						'STATUS' => '1');

		// run insert model to write data to db
		$result=$this->Admin_model->SaveUnit($UnitData);
		if ($result == false) // the information has therefore been successfully saved in the db
			{
			$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
			redirect(base_url().'item/listunits');   // or whatever logic needs to occur
			}
			else
			{
			$this->session->set_flashdata('msg','<span class="text-green">New unit added successfully.</span>');
			redirect(base_url().'item/listunits');   // or whatever logic needs to occur
			}
		}
	}

	function update_unit($id)
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('unit_name','Unit Name',  'required');
	    $this->form_validation->set_rules('unit_description','Unit Description',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
		{
		$this->UpdateUnit($id);
		}
		else // passed validation proceed to post success logic
		{

		// build array for the model
		$UnitData = array(
						'UNIT_NAME' => @$this->input->post('unit_name'),
						'UNIT_DESCRIPTION' => @$this->input->post('unit_description'),
						'STATUS' => '1');

		// run insert model to write data to db
		$result=$this->Admin_model->UpdateUnit($id, $UnitData);
		if ($result == false) // the information has therefore been successfully saved in the db
			{
			$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
			redirect(base_url().'item/listunits/');   // or whatever logic needs to occur
			}
			else
			{
			$this->session->set_flashdata('msg','<span class="text-green">Unit has been updated successfully.</span>');
			redirect(base_url().'item/listunits/');   // or whatever logic needs to occur
			}
		}
	}

	public function getStock()
	{
		$item_id= $_POST['item_id'];
		$stocks = $this->Admin_model->GetItemByStockEntry($item_id);
		echo $stocks;
	}

	public function updatecategory($id)
	{
		if( !is_UserAllowed('update_category')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Categories';
		$data['form_title']='Update Categories';
		$data['table_title']='Manage Categories';
		$data['CatArray']=$this->db->get_where('item_category',array('status'=>'1'))->result_array();
		$data['category']=$this->db->get_where('item_category',array('ID'=>$id))->row();
		$this->RedirectToPageWithData('item/update_category',$data);
	}

	function update_category($id)
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('cat_name','Category Name',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
		{
		$this->updatecategory($id);
		}
		else // passed validation proceed to post success logic
		{

		// build array for the model
		$Data = array(
						'CATEGORY_NAME' => @$this->input->post('cat_name'),
						'STATUS' => '1');

		// run insert model to write data to db
		$result=$this->Admin_model->UpdateCategory($id, $Data);

		if ($result == false) // the information has therefore been successfully saved in the db
			{
			$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
			redirect(base_url().'item/listitemcategory/');   // or whatever logic needs to occur
			}
			else
			{
			$this->session->set_flashdata('msg','<span class="text-green">Category has been updated successfully.</span>');
			redirect(base_url().'item/listitemcategory/');   // or whatever logic needs to occur
			}
		}
	}

	public function updateinner($id)
	{
		if( !is_UserAllowed('update_inner_box')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Inner Box Size';
		$data['form_title']='Update Inner Box Sizes';
		$data['table_title']='Manage Inner Box Sizes';
		$data['InnerArray']=$this->db->get_where('item_innerbox',array('status'=>'1'))->result_array();
		$data['innnerbox']=$this->db->get_where('item_innerbox',array('ID'=>$id))->row();
		$this->RedirectToPageWithData('item/update_inner',$data);
	}

	function update_inner($id)
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('ib_size','Inner Box Size',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
		{
		$this->updateinner($id);
		}
		else // passed validation proceed to post success logic
		{

		// build array for the model
		$Data = array(
						'INNER_BOX_SIZE' => @$this->input->post('ib_size'),
						'STATUS' => '1');

		// run insert model to write data to db
		$result=$this->Admin_model->UpdateInner($id, $Data);

		if ($result == false) // the information has therefore been successfully saved in the db
			{
			$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
			redirect(base_url().'item/listinnerbox/');   // or whatever logic needs to occur
			}
			else
			{
			$this->session->set_flashdata('msg','<span class="text-green">Inner box size has been updated successfully.</span>');
			redirect(base_url().'item/listinnerbox/');   // or whatever logic needs to occur
			}
		}
	}

	public function updateouter($id)
	{
		if( !is_UserAllowed('update_outer_box')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Outer Box Size';
		$data['form_title']='Update Outer Box Sizes';
		$data['table_title']='Manage Outer Box Sizes';
		$data['OuterArray']=$this->db->get_where('item_outerbox',array('status'=>'1'))->result_array();
		$data['outerbox']=$this->db->get_where('item_outerbox',array('ID'=>$id))->row();
		$this->RedirectToPageWithData('item/update_outer',$data);
	}

	function update_outer($id)
	{
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('ob_size','Outer Box Size',  'required');
		$this->form_validation->set_rules('ob_cbm','CBM',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
		{
		$this->updateouter($id);
		}
		else // passed validation proceed to post success logic
		{

		// build array for the model
		$Data = array(
						'OUTER_BOX_SIZE' => @$this->input->post('ob_size'),
						'CBM' => @$this->input->post('ob_cbm'),
						'STATUS' => '1');

		// run insert model to write data to db
		$result=$this->Admin_model->UpdateOuter($id, $Data);

		if ($result == false) // the information has therefore been successfully saved in the db
			{
			$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
			redirect(base_url().'item/listouterbox/');   // or whatever logic needs to occur
			}
			else
			{
			$this->session->set_flashdata('msg','<span class="text-green">Outer box size has been updated successfully.</span>');
			redirect(base_url().'item/listouterbox/');   // or whatever logic needs to occur
			}
		}
	}

	public function uploadcsv()
	{
		$data['title']='Upload CSV';
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('item/upload_csv',$data);
	}

	function uploadData()
    {
        $result = $this->Admin_model->uploadData();

        if ($result == false) // the information has therefore been successfully saved in the db
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'item/uploadcsv/');   // or whatever logic needs to occur
			}
			else
			{
				$this->session->set_flashdata('msg','<span class="text-green">Outer box size has been updated successfully.</span>');
				redirect(base_url().'item/uploadcsv/');   // or whatever logic needs to occur
			}
    }

	function uploadSubData()
    {
        $result = $this->Admin_model->uploadsubData();

        if ($result == false) // the information has therefore been successfully saved in the db
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'item/uploadcsv/');   // or whatever logic needs to occur
			}
			else
			{
				$this->session->set_flashdata('msg','<span class="text-green">Outer box size has been updated successfully.</span>');
				redirect(base_url().'item/uploadcsv/');   // or whatever logic needs to occur
			}
    }

	function itemJson()
	{

		$keyword = $_GET['q'];
		$this->db->select('ITEM_ID as id,ITEM_CODE as text');
		$this->db->from('item');
		$this->db->like('ITEM_CODE', $keyword);
		$this->db->or_like('ITEM_DESC', $keyword);
		$this->db->where('STATUS', 1);
		$data['result'] = $this->db->get()->result_array();

		echo json_encode($data);
		//die();
		//echo $a;

	}

}
