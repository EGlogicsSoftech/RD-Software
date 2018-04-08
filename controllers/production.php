<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Production extends CI_Controller {

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
	 	
	public function issue_list()
	{
		if( !is_UserAllowed('production')){ header('Location: '.base_url().'admin/dashboard'); } 
		
		$data['title']='Issue List';
		$data['customers']= $this->db->get_where('customer',array('status'=>1))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('production/issue_list',$data);
	}
	
	public function update_issue_list()
	{
		if( !is_UserAllowed('production')){ header('Location: '.base_url().'admin/dashboard'); } 
		
		$data['title']='Update Issue List';
		$data['customers']= $this->db->get_where('customer',array('status'=>1))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('production/update_issue_list',$data);
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
	
	public function customer_pi_items()
	{
		$cpi_id = $this->input->post('customer_pi');
		
		$data['title']='Customer P.I List';
		$data['items']= $this->db->get_where('customer_pi_item',array('cust_pi_id'=>$cpi_id))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('production/customer_pi_item',$data);
	}
	
	public function update_cpi_item()
	{
		$cpi_id = $this->input->post('customer_pi');
		
		$data['title']='Customer P.I List';
		$data['items']= $this->db->get_where('customer_pi_item',array('cust_pi_id'=>$cpi_id))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('production/update_cpi_item',$data);
	}
	
	public function save_production()
	{
	
		$qty = $_POST['qty'];
		$item_id = $_POST['item_id'];
		$cpi_id = $_POST['cpi_id'];
		
		$data = array(
			'cpi_id' => $cpi_id,
			'item_id' => $item_id,
			'produced_qty' => $qty
		);
						
		$result = $this->Admin_model->SaveProduction($data);
		
		if($result)
			{
				echo "Data has been saved.";
			}
		
	}
	
	public function cpi_sub_item()
	{
		$data['title']='PI Sub Items';
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('production/pi_sub_item',$data);
	}
	
	public function item_issue_list()
	{
		$data['title']='Items Issue List';
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('production/item_issue_list',$data);
	}
	
	public function Export_PDF()
		{
			$this->load->library('pdf');
			$this->data['title']="Shivam";
			$this->data['post_data']= $_POST['data'];
		
			$html=$this->load->view('production/Export_PDF',$this->data, true); //load the pdf_output.php by passing our data and get all data in $html varriable.
	 
			$pdfFilePath ="CPI-12.pdf";

			$pdf = $this->pdf->load();
			
			$pdf->WriteHTML($html,2);
			
			$pdf->Output($pdfFilePath, "D");
		}
		
	public function production_history()
		{
			if( !is_UserAllowed('production')){ header('Location: '.base_url().'admin/dashboard'); } 
			
			$data['title']='Production History';
			$data['msg']=$this->session->flashdata('msg');
			$this->RedirectToPageWithData('production/production_history',$data);
		}
	
}
