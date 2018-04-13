<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {

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

	public function product()
		{
			$data['title']='Products';
			$data['items']=$this->db->get_where('item',array('status'=>'1'))->result_array();
			$this->RedirectToPageWithData('report/product',$data);
		}

	public function supplier()
		{
			if( !is_UserAllowed('rep_supplier')){ header('Location: '.base_url().'admin/dashboard'); }
			
			$data['title']='SUPPLIER PENDING ORDER REPORTS';
			$data['suppliers']=$this->db->get_where('supplier',array('status'=>'1'))->result_array();
			$this->RedirectToPageWithData('report/supplier',$data);
		}
		
	public function statistical_raw()
		{
			if( !is_UserAllowed('rep_statistical_raw')){ header('Location: '.base_url().'admin/dashboard'); }
			
			$data['title']='STATISTICAL DATA ANALYSIS REPORT FOR RAW MATERIAL';
			$data['countries']= $this->db->get_where('item_country')->result_array();
			$this->RedirectToPageWithData('report/statistical_raw',$data);
		}
		
	public function statistical_finished()
		{
			if( !is_UserAllowed('rep_statistical_finished')){ header('Location: '.base_url().'admin/dashboard'); }
			
			$data['title']='STATISTICAL DATA ANALYSIS REPORT FOR FINISHED GOODS';
			$data['customers'] = $this->db->get_where('customer',array('status'=>'1'))->result_array();
			$this->RedirectToPageWithData('report/statistical_finished',$data);
		}
		
	public function item_pending()
		{
			if( !is_UserAllowed('rep_item_pending')){ header('Location: '.base_url().'admin/dashboard'); }
			
			$data['title']='PENDING ITEMS';
			$this->RedirectToPageWithData('report/item_pending',$data);
		}
		
	public function gst()
		{
			if( !is_UserAllowed('rep_gst')){ header('Location: '.base_url().'admin/dashboard'); }
			
			$data['title']='GST';
			$data['suppliers']=$this->db->get_where('supplier',array('status'=>'1'))->result_array();
			$this->RedirectToPageWithData('report/gst',$data);
		}

	public function customer()
		{
			if( !is_UserAllowed('rep_customer')){ header('Location: '.base_url().'admin/dashboard'); }
			
			$data['title']='CUSTOMER ORDER REPORTS';
			
			// $customers = $_POST['customer'];
// 			//var_dump($customers);
// 			//die();
// 			$this->db->where('status','1');
// 			if(!empty($customers))
// 			{
// 				$this->db->where_in('customer_id',$customers);
// 			}
			//$data['customer_list'] = $this->db->query("select * FROM customer WHERE status = 1")->result_array();
			$data['customers'] = $this->db->get_where('customer',array('status'=>'1'))->result_array();
			$this->RedirectToPageWithData('report/customer',$data);
		}

	public function grn()
		{
			$data['title']='GRNs';
			$data['suppliers']=$this->db->get_where('supplier',array('status'=>'1'))->result_array();
			$this->RedirectToPageWithData('report/grn',$data);
		}
		
	public function invantory()
		{
			if( !is_UserAllowed('rep_inventory')){ header('Location: '.base_url().'admin/dashboard'); }
			
			$data['title']='INVENTORY REPORTS (STOCK ACCOUNTING REPORTS)';
			//$data['suppliers']=$this->db->get_where('supplier',array('status'=>'1'))->result_array();
			$this->RedirectToPageWithData('report/invantory',$data);
		}
		
	public function view_invantory($id)
		{
			$data['title']='View Invantory';
			$data['item_id'] = $id;
			$data['msg']=$this->session->flashdata('msg');
			$this->RedirectToPageWithData('stock/view_invantory',$data);
		}

	public function GetSupplierGRN()
		{
			$sup_id = $_POST['sup_id'];

			$grns = $this->db->get_where('grn',array('sup_id'=> $sup_id, 'status'=> 1))->result_array();

			$html ='<option>Select Item</option>';

			foreach($grns as $grn)
				{
					$html .='<option value="'.$grn['grn_id'].'">'.$grn['grn_number'].'</option>';
				}

			echo $html;
		}

	public function invoice()
		{
			$data['title']='Invoice';
			$data['customers']=$this->db->get_where('customer',array('status'=>'1'))->result_array();
			$this->RedirectToPageWithData('report/invoice',$data);
		}

	public function master()
		{
			$data['title']='Master';
			$data['items']=$this->db->get_where('item',array('status'=>'1'))->result_array();
			$this->RedirectToPageWithData('report/master',$data);
		}

	public function purchase_order()
		{
			$data['title']='Purchse Order';
			$data['supplier_pos'] = $this->db->get_where('supplier_po')->result_array();
			$data['customer_pis'] = $this->db->get_where('customer_pi', array('status'=>1))->result_array();
			$this->RedirectToPageWithData('report/purchase_order',$data);
		}

	Public function ItembySupplier()
		{
			$sid = $_POST['sup_id'];

			$rows = GetItemofSupplier($sid);
			$html = array();
			$i =1;
			foreach($rows as $row)
				{
					$html[]= $row['ITEM_ID'];

				$i++; }

			return $html;
		}
		
	Public function get_supplier_po_ajax()
		{
			$sid = $_POST['sup_id'];

			$rows = $this->db->get_where('supplier_po',array('sup_id'=>$sid, 'status' => 1))->result_array();
			
			$html ='<option>Select Supplier PO</option>';

			foreach($rows as $row)
				{
					$html .='<option value="'.$row['sup_po_id'].'">'.$row['po_num'].'</option>';
				}
				
			echo $html;
		}

	public function view($id)
	{
		$data['title']='View Invoice';
		$data['invoice'] = $this->db->get_where('invoice',array('id'=>$id))->row();
		$data['customerpos']= $this->db->get_where('customer',array('status'=>1))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('invoice/view',$data);
	}

	public function Export_PDF($id)
		{
			$this->load->library('pdf');
			$this->data['title']="Shivam";
			$this->data['invoice']=$this->db->get_where('invoice',array('invoice_id'=>$id))->row();

			$html=$this->load->view('invoice/export_pdf',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.

			$pdfFilePath ="INVOICE-".GetInvoiceData( $this->data['invoice']->invoice_id )->invoice_num.".pdf";

			$pdf = $this->pdf->load();

			$pdf->WriteHTML($html,2);

			$pdf->Output($pdfFilePath, "D");
		}

	public function ExportEXL($id)
		{
			$data['invoice'] = $this->db->get_where('invoice',array('invoice_id'=>$id))->row();

			$this->RedirectToPageWithData('invoice/export_excel', $data);
	  	}

	public function GetItembyCPI()
	{
		$items = $this->db->get_where('customer_pi_item',array('cust_pi_id'=>$_POST['pi_id']))->result_array();

		$html ='<option>Select Item</option>';

		foreach($items as $item)
		{
			$html .='<option value="'.$item['item_id'].'">'.GetItemData( $item['item_id'])->ITEM_CODE .'</option>';
		}

		echo $html;
	}

	public function GetqtyPriceofPIItem()
	{
		$invoiced_qty = invoiced_quantity($_POST['CPI'], $_POST['ItemID']);

		$items = $this->db->get_where('customer_pi_item',array('item_id'=>$_POST['ItemID']))->row();

		$qty = $items->qty - $invoiced_qty;

		$data = array( 'qty'=>$qty, 'price'=>$items->price );

		$html = json_encode($data);

		echo $html;
	}

	function SaveInvoice()
	{
		$timestamp = $this->input->post('date');
		$date1 = strtr($timestamp, '/', '-');
		$inv_date = date('Y-m-d', strtotime($date1));

		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('invoice_custpo','Customer PO',  'required');
	    $this->form_validation->set_rules('date','Date',  'required');
	    $this->form_validation->set_rules('invoice_no','Invoice No',  'required');
	 	$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
		{
		$this->add_invoice();
		}
		else // passed validation proceed to post success logic
		{

			$invoiceData = array(
						'invoice_id' => time(),
						'cust_id' => @$this->input->post('invoice_custpo'),
						'date' => @$inv_date,
						'invoice_num' => @$this->input->post('invoice_no')
						);

		$result = $this->Admin_model->SaveInvoice($invoiceData);

		if ($result == false) // the information has therefore been successfully saved in the db
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'invoice/add_invoice');   // or whatever logic needs to occur
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-green">New Invoice added successfully.</span>');
				redirect(base_url().'invoice/view/'.$result);   // or whatever logic needs to occur
			}

		}
	}

	function SaveInvoiceItem($id)
	{
		$max_qty = @$this->input->post('max_qty');

		if($max_qty != 0)
			{
				$max_qty = $max_qty+1;
			}

		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
		$this->form_validation->set_rules('cust_pi','Customer PI',  'required');
	    $this->form_validation->set_rules('item','Item',  'required');
	    $this->form_validation->set_rules('qty','Quantity', 'required|less_than['.$max_qty.']');
	    $this->form_validation->set_rules('pprunit','Price',  'required');
	 	$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
		{
		$this->view($id);
		}
		else // passed validation proceed to post success logic
		{

			$invoiceData = array(
						'invoice_id' => @$this->input->post('invoice_id'),
						'cust_pi' => @$this->input->post('cust_pi'),
						'item_id' => @$this->input->post('item'),
						'qty' => @$this->input->post('qty'),
						'price' => @$this->input->post('pprunit'),
						'd_box_num' => @$this->input->post('d_box_num'),
						'box_num' => @$this->input->post('box_num'),
						);

		$result = $this->Admin_model->SaveInvoiceItem($invoiceData);

		if ($result == false) // the information has therefore been successfully saved in the db
			{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'invoice/view');   // or whatever logic needs to occur
			}
		else
			{
				$this->session->set_flashdata('msg','<span class="text-green">New Invoice added successfully.</span>');
				redirect(base_url().'invoice/view/'.$id);   // or whatever logic needs to occur
			}

		}
	}

	public function invoice_list()
	{
		$data['title']='Invoice List';
		$data['invoices']=$this->db->get_where('invoice')->result_array();
		$this->RedirectToPageWithData('invoice/all_invoice',$data);
	}

	public function get_item_by_customerPI()
	{
		$pi_id= $_POST['pi_id'];
		$items = $this->Admin_model->GetItemByCustomerPi($pi_id);

		$html ="<option value=''>Select Item</option>";

		foreach($items as $item)
			{
				$html .='<option value="'.$item['item_id'].'">'.GetITEMname( $item['item_id'] ).'</option>';
			}

		echo $html;
	}

	public function update_box_no()
	{
		$value = $_POST['value'];
		$iid = $_POST['iid'];

		$result = $this->Admin_model->update_box_no($iid,$value);

		$data = json_encode($result);

		echo $data;
	}
	
	public function CustomerCPI()
	{
		$customer_id= $_POST['customer_id'];
		
		$rows = $this->Admin_model->CustomerCPI($customer_id);
		
		$html ="<option value=''>Select Customer P.I</option>";

		foreach($rows as $row)
			{
				$html .='<option value="'.$row['cust_pi_id'].'">'.$row['pi_num'].'</option>';
			}

		echo $html;	
	}
	
	function fetch_items()
		{
			$fetch_data = $this->Admin_model->rep_make_datatables();

           	$data = array();
           	$no = $_POST['start'];

           	foreach($fetch_data as $row)
           	{
           		$no++;
           		
           		$item = $row->ITEM_ID;
           		
           		$sup_id = GetItemData($item)->SUPPLIER_ID;
				$sup_data = Get_Supplier_Data_by_Array_ID($sup_id);
				$sup_code = array();

				foreach($sup_data as $sup_dat)
					{
						$sup_code[] = $sup_dat['supplier_code'];
					}

				$stock = CheckStockbyItem($item);
				$stock_entry = (isset($stock->SUMA) ? $stock->SUMA : 0);
				$stock_issue = (isset($stock->SUMB) ? $stock->SUMB : 0);
				$spo_qty = Get_Total_SPO_QTY($item);
				$order_balance = GetOrderInHand($item);
				$total_order = Get_Total_Order($item);

                $sub_array = array();
                $sub_array[] = $no;
                $sub_array[] = GetItemData($item)->ITEM_CODE;
                $sub_array[] = GetItemData($item)->ITEM_DESC;
                $sub_array[] = GetItemData($item)->MANUFACTURING_TIMEFRAME;
                $sub_array[] = implode(", ",$sup_code);
				$sub_array[] = $stock_entry - $stock_issue;
				$sub_array[] = $spo_qty;
				$sub_array[] = $total_order;
				$sub_array[] = $order_balance;
                $sub_array[] = '';
                $sub_array[] = '';
                
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


}
