<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invoice extends CI_Controller { 

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

	public function add_invoice()
	{
		$data['title']='Add Invoice';
		$data['items']=GetItem();
		$data['customers']= $this->db->get_where('customer',array('status'=>1))->result_array();
		$data['packings']= $this->db->get_where('packing_list')->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('invoice/add_invoice',$data);
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

}
