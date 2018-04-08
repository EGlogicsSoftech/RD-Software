<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warehouse extends CI_Controller {

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

	public function add_activity()
	{
		if( !is_UserAllowed('add_wa')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Add Warehouse Activity';
		//$data['items']=GetItem();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('warehouse/add_activity',$data);
	}

	public function edit_activity($id)
	{
		if( !is_UserAllowed('update_wa')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Edit Warehouse Activity';
		$data['items']= GetItem();
		$data['activity']=$this->db->get_where('warehouse_activity', array('id'=>$id, 'status'=> 1))->row();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('warehouse/edit_activity',$data);
	}

	function save_activity()
	{
		$loggedin = $this->db->get_where('login',array('id'=>$this->session->userdata('id')))->row('id');
		$timestamp = $this->input->post('date');
		//$we_date = date('Y-m-d', strtotime($timestamp));
		$date1 = strtr($timestamp, '/', '-');
		$we_date = date('Y-m-d', strtotime($date1));
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('item','Item',  'required');
		$this->form_validation->set_rules('finsh_qty','Finished Quantity',  'required');
		$this->form_validation->set_rules('altd_worker','Alloted Worker',  'required');
		$this->form_validation->set_rules('shift','Shift',  'required');
		$this->form_validation->set_rules('date','Date',  'required');
		$this->form_validation->set_rules('stus_remark','Status Remark',  'required');
	    $this->form_validation->set_rules('invoice','Invoice',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');


	if($this->form_validation->run() == FALSE) // validation hasn't been passed
		{
		$this->add_activity();
		}
		else // passed validation proceed to post success logic
		{
		// build array for the model
		$ActivityData = array(
						'activity_id' => time(),
						'user_id' => $loggedin,
						'item_id' => @$this->input->post('item'),
						'qty' => @$this->input->post('finsh_qty'),
						'altd_wrkr' => @$this->input->post('altd_worker'),
						'shift' => @$this->input->post('shift'),
						'date' => @$we_date,
						'remarks' => @$this->input->post('stus_remark'),
						'invoice_num' => @$this->input->post('invoice'),
						'status' => '1'
					);

		// run insert model to write data to db
		$result=$this->Admin_model->SaveWarehouseActivty($ActivityData);
		if ($result == false) // the information has therefore been successfully saved in the db
			{
			$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
			redirect(base_url().'warehouse/add_activity');   // or whatever logic needs to occur
			}
			else
			{
			$this->session->set_flashdata('msg','<span class="text-green">New record added successfully.</span>');
			redirect(base_url().'warehouse/add_activity');   // or whatever logic needs to occur
			}
		}
	}

	function update_activity($id)
	{
		$loggedin = $this->db->get_where('login',array('id'=>$this->session->userdata('id')))->row('id');
		$timestamp = $this->input->post('date');
		//$we_date = date('Y-m-d', strtotime($timestamp));
		$date1 = strtr($timestamp, '/', '-');
		$we_date = date('Y-m-d', strtotime($date1));

		$data = GetWarehouseActivity($id);

		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('item','Item',  'required');
		$this->form_validation->set_rules('finsh_qty','Finished Quantity',  'required');
		$this->form_validation->set_rules('altd_worker','Alloted Worker',  'required');
		$this->form_validation->set_rules('date','Date',  'required');
		$this->form_validation->set_rules('stus_remark','Status Remark',  'required');
	    $this->form_validation->set_rules('invoice','Invoice',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');


		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->edit_activity($id);
			}
		else // passed validation proceed to post success logic
			{
				$ActivityData = array(
					'activity_id' => $data->activity_id,
					'user_id' => $loggedin,
					'item_id' => @$this->input->post('item'),
					'qty' => @$this->input->post('finsh_qty'),
					'altd_wrkr' => @$this->input->post('altd_worker'),
					'date' => @$we_date,
					'remarks' => @$this->input->post('stus_remark'),
					'invoice_num' => @$this->input->post('invoice'),
					'updated_at' => $data->updated_at
				);

				$result=$this->Admin_model->UpdateWarehouseActivty($id, $ActivityData);

				if ($result == false) // the information has therefore been successfully saved in the db
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'warehouse/edit_activity/'.$result);   // or whatever logic needs to occur
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-green">New record added successfully.</span>');
						redirect(base_url().'warehouse/edit_activity/'.$result);   // or whatever logic needs to occur
					}
			}
	}

	public function all_activity_list()
	{
		if( !is_UserAllowed('all_wa')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='All Activity List';
		$data['activities']=$this->db->get_where('warehouse_activity', array('status'=> 1))->result_array();
		$this->RedirectToPageWithData('warehouse/all_activity',$data);
	}

	public function add_rejection()
	{
		if( !is_UserAllowed('add_wr')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Add Warehouse Rejection';
		$data['suppliers']=GetAllSupplier();
		$data['invoices']=$this->db->get_where('stock_issue', array('status'=> 1))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('warehouse/add_rejection',$data);
	}

	public function edit_rejection($id)
	{
		if( !is_UserAllowed('update_wr')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='Edit Warehouse Rejection';
		$data['suppliers']=GetAllSupplier();
		$data['rejection']=$this->db->get_where('warehouse_rejection', array('id'=>$id, 'status'=> 1))->row();
		$data['invoices']=$this->db->get_where('stock_issue', array('status'=> 1))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('warehouse/edit_rejection',$data);
	}

	function save_rejection()
	{
		$timestamp = $this->input->post('date');
		$date1 = strtr($timestamp, '/', '-');
		$rej_date = date('Y-m-d', strtotime($date1));

		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('invoice_no','Ref/Invoice No',  'required');
		$this->form_validation->set_rules('supplier','Supplier',  'required');
		$this->form_validation->set_rules('spo','Supplier PO',  'required');
		$this->form_validation->set_rules('item','Item',  'required');
		$this->form_validation->set_rules('rejected_qty','Rejected Quantity',  'required');
		$this->form_validation->set_rules('date','Date',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

	if($this->form_validation->run() == FALSE) // validation hasn't been passed
		{
		$this->add_rejection();
		}
		else // passed validation proceed to post success logic
		{
		// build array for the model
		$RejectionData = array(
						'rejection_id' => time(),
						'user_id' => @$this->session->userdata('id'),
						'invoice_no' => @$this->input->post('invoice_no'),
						'sup_id' => @$this->input->post('supplier'),
						'spo_id' => @$this->input->post('spo'),
						'item_id' => @$this->input->post('item'),
						'qty' => @$this->input->post('rejected_qty'),
						'created_at' => @$rej_date,
					);

		// run insert model to write data to db
		$result=$this->Admin_model->SaveWarehouseRejection($RejectionData);

		if ($result == false) // the information has therefore been successfully saved in the db
			{
			$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
			redirect(base_url().'warehouse/add_rejection');   // or whatever logic needs to occur
			}
			else
			{
			$this->session->set_flashdata('msg','<span class="text-green">Rejection added successfully.</span>');
			redirect(base_url().'warehouse/add_rejection');   // or whatever logic needs to occur
			}
		}
	}

	function update_rejection($id)
	{
		$timestamp = $this->input->post('date');
		$date1 = strtr($timestamp, '/', '-');
		$rej_date = date('Y-m-d', strtotime($date1));

		$data = GetWarehouseRejection($id);

		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('invoice_no','Ref/Invoice No',  'required');
		$this->form_validation->set_rules('supplier','Supplier',  'required');
		$this->form_validation->set_rules('spo','Supplier PO',  'required');
		$this->form_validation->set_rules('item','Item',  'required');
		$this->form_validation->set_rules('rejected_qty','Rejected Quantity',  'required');
		$this->form_validation->set_rules('date','Date',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

	if($this->form_validation->run() == FALSE) // validation hasn't been passed
		{
			$this->edit_rejection($id);
		}
		else // passed validation proceed to post success logic
		{
		// build array for the model
		$RejectionData = array(
						'rejection_id' => $data->rejection_id,
						'user_id' => @$this->session->userdata('id'),
						'invoice_no' => @$this->input->post('invoice_no'),
						'sup_id' => @$this->input->post('supplier'),
						'spo_id' => @$this->input->post('spo'),
						'item_id' => @$this->input->post('item'),
						'qty' => @$this->input->post('rejected_qty'),
						'created_at' => @$rej_date,
						'updated_date' => $data->date,
					);

		// run insert model to write data to db
		$result = $this->Admin_model->UpdateWarehouseRejection($id, $RejectionData);

		if ($result == false) // the information has therefore been successfully saved in the db
			{
			$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
			redirect(base_url().'warehouse/edit_rejection/'.$result);   // or whatever logic needs to occur
			}
			else
			{
			$this->session->set_flashdata('msg','<span class="text-green">Rejection added successfully.</span>');
			redirect(base_url().'warehouse/edit_rejection/'.$result);   // or whatever logic needs to occur
			}
		}
	}


	public function all_rejection_list()
	{
		if( !is_UserAllowed('view_wr')){ header('Location: '.base_url().'admin/dashboard'); }

		$data['title']='All Rejected List';
		$data['rejects']=$this->db->get_where('warehouse_rejection', array('status'=>1))->result_array();
		$this->RedirectToPageWithData('warehouse/all_rejection',$data);
	}

	public function getSPObySupplier()
		{
			$sup_id= $_POST['sup_id'];

			$spos = $this->db->get_where('supplier_po', array('sup_id'=>$sup_id))->result_array();

			$html ="<option value=''>Select Supplier PO</option>";

			foreach($spos as $spo)
				{
					$html .='<option value="'.$spo['sup_po_id'].'">'.$spo['po_num'].'</option>';
				}

			echo $html;
		}

	public function GetItembySupplier()
		{
			$spo_id= $_POST['spo_id'];

			$items = $this->db->get_where('supplier_po_item',array('sup_po_id'=>$spo_id))->result_array();

			$html ="<option value=''>Select Item</option>";

			foreach($items as $item)
				{
					$html .='<option value="'.$item['item_id'].'">'.GetItemData( $item['item_id'] )->ITEM_CODE.'</option>';
				}

			echo $html;
		}

}
