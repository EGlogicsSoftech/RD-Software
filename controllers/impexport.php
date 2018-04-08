<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Impexport extends CI_Controller {

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

	public function import()
	{
		if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
		
		$data['title']='Import';
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('impexport/import',$data);
	}
	
	public function export()
	{
		if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
		
		$data['title']='Export';
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('impexport/export',$data);
	}
	
	public function exports_item()
		{
			if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
			
			date_default_timezone_set("Asia/Calcutta");
			
			$data = GetItem();
			
			header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"Export_Item".date('d-m-Y_H:i:s').".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");

            $handle = fopen('php://output', 'w');
            
            fputcsv($handle, array_keys($data[0]));

            foreach ($data as $row) {
                fputcsv($handle, $row);
            }
                fclose($handle);
                
            $data1 = array(
				'object' => 'Item',
				'type' => 'Export'
			);

			$result = $this->Admin_model->SaveLog($data1);
            
            exit;
        }
        
    function import_item()
		{
			if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
			
			date_default_timezone_set("Asia/Calcutta");
			
			$csv_mimetypes = array(
				'text/csv',
				'application/csv',
				'text/comma-separated-values',
			);

			if (in_array($_FILES['imp_item']['type'], $csv_mimetypes)) 
				{
			
					$this->load->dbutil();
			
					$prefs = array(
						'tables'	=> array('item'),
						'format'	=> 'zip',
						'filename' 	=> 'item-'.date("Y-m-d-H-i-s").'.sql',
						'add_drop'  => TRUE
					);
			
					$backup =& $this->dbutil->backup($prefs);
			
					$db_name = 'item-'. date("Y-m-d-H-i-s") .'.zip';
					$save = './uploads/db_backup/'.$db_name;
			
					$this->load->helper('file');
					write_file($save, $backup);
		
					$result = $this->Admin_model->importITEM();
		
					if ($result == false) // the information has therefore been successfully saved in the db
						{
							$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
							redirect(base_url().'impexport/import/');   // or whatever logic needs to occur
						}
					else
						{
							$this->session->set_flashdata('msg','<span class="text-green">Outer box size has been updated successfully.</span>');
							redirect(base_url().'impexport/import/');   // or whatever logic needs to occur	
						}
						
				}
			else
				{
					$this->session->set_flashdata('msg','<span class="text-red">You can use only CSV format.</span>');
					redirect(base_url().'impexport/import/');   // or whatever logic needs to occur	
				}	
		}
        
    public function exports_supplier()
		{
			if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
			
			date_default_timezone_set("Asia/Calcutta");
			
            $data = $this->db->get_where('supplier',array('status'=>1))->result_array();
            
            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"Export_supplier".date('d-m-Y_H:i:s').".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");

            $handle = fopen('php://output', 'w');
            
            fputcsv($handle, array_keys($data[0]));

            foreach ($data as $row) {
                fputcsv($handle, $row);
            }
                fclose($handle);
                
                $data1 = array(
					'object' => 'Supplier',
					'type' => 'Export'
				);

				$result = $this->Admin_model->SaveLog($data1);
                
            exit;
        }
        
    function import_supplier()
		{
			if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
			
			date_default_timezone_set("Asia/Calcutta");
			
			$csv_mimetypes = array(
				'text/csv',
				'application/csv',
				'text/comma-separated-values',
			);

			if (in_array($_FILES['imp_supplier']['type'], $csv_mimetypes)) 
				{
			
					$this->load->dbutil();
			
					$prefs = array(
						'tables'	=> array('supplier'),
						'format'	=> 'zip',
						'filename' 	=> 'supplier-'.date("Y-m-d-H-i-s").'.sql',
						'add_drop'  => TRUE
					);
			
					$backup =& $this->dbutil->backup($prefs);
			
					$db_name = 'supplier-'. date("Y-m-d-H-i-s") .'.zip';
					$save = './uploads/db_backup/'.$db_name;
			
					$this->load->helper('file');
					write_file($save, $backup);
			
					// $this->load->helper('download');
		// 			force_download($db_name, $backup);
			
					$result = $this->Admin_model->importSUPPLIER();
		
					if ($result == false) // the information has therefore been successfully saved in the db
						{
							$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
							redirect(base_url().'impexport/import/');   // or whatever logic needs to occur
						}
					else
						{
							$this->session->set_flashdata('msg','<span class="text-green">Outer box size has been updated successfully.</span>');
							redirect(base_url().'impexport/import/');   // or whatever logic needs to occur	
						}
						
				}
			else
				{
					$this->session->set_flashdata('msg','<span class="text-red">You can use only CSV format.</span>');
					redirect(base_url().'impexport/import/');   // or whatever logic needs to occur	
				}	
		}
        
    public function exports_customer()
		{
			if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
			
			date_default_timezone_set("Asia/Calcutta");
			
            $data = $this->db->get_where('customer',array('status'=>1))->result_array();
            
            header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"Export_customer".date('d-m-Y_H:i:s').".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");

            $handle = fopen('php://output', 'w');
            
             fputcsv($handle, array_keys($data[0]));

            foreach ($data as $row) {
                fputcsv($handle, $row);
            }
                fclose($handle);
                
            $data1 = array(
				'object' => 'Customer',
				'type' => 'Export'
			);

			$result = $this->Admin_model->SaveLog($data1);
            
            exit;
        }

	function import_customer()
		{ 
			if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
			
			$csv_mimetypes = array(
				'text/csv',
				'application/csv',
				'text/comma-separated-values',
			);

			if (in_array($_FILES['imp_customer']['type'], $csv_mimetypes)) 
				{
				
					date_default_timezone_set("Asia/Calcutta");
			
					$this->load->dbutil();
			
					$prefs = array(
						'tables'	=> array('customer'),
						'format'	=> 'zip',
						'filename' 	=> 'customer-'.date("Y-m-d-H-i-s").'.sql',
						'add_drop'  => TRUE
					);
			
					$backup =& $this->dbutil->backup($prefs);
			
					$db_name = 'customer-'. date("Y-m-d-H-i-s") .'.zip';
					$save = './uploads/db_backup/'.$db_name;
			
					$this->load->helper('file');
					write_file($save, $backup);

					$result = $this->Admin_model->importCUSTOMER();
		
					if ($result == false) // the information has therefore been successfully saved in the db
						{
							$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
							redirect(base_url().'impexport/import/');   // or whatever logic needs to occur
						}
					else
						{
							$this->session->set_flashdata('msg','<span class="text-green">Data has been uploaded successfully.</span>');
							redirect(base_url().'impexport/import/');   // or whatever logic needs to occur	
						}
				
				}
			else
				{
					$this->session->set_flashdata('msg','<span class="text-red">You can use only CSV format.</span>');
					redirect(base_url().'impexport/import/');   // or whatever logic needs to occur	
				}	
			
			//var_dump($info);
			die();
		}
	
}
