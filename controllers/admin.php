<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

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


	public function index($sv_error)
	{
		if( $sv_error == 1 )
			{
				$data['error'] = '<span style="color:red;">your account has been deactivated, please contact your webadmin</span>';
			}
		$data['title']='Login';
		$this->load->view('login',$data);
	}

	//Function for validate login		
	public function validate()
		{
		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
	    $this->form_validation->set_rules('email','E-Mail',  'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');
		if($this->form_validation->run() == FALSE)
			{
			$this->index();
			}
			else
			{
			echo $pass = md5($this->input->post('password'));
			echo $email = $this->input->post('email');
			$user_id = $this->db->get_where('login',array('email'=>$email,'password'=>$pass,'status'=>1) )->row('id');
			
			if(is_numeric($user_id))
				{
					$sess_array = array('id' => $user_id,'user' => $email,'pass'=>$pass);
					$this->session->set_userdata($sess_array);
				
					header('Location: '.base_url().'admin/dashboard');
				}
			else
				{
					$this->index(1);
				}
			}
		}
		
	//Function to check email exist in database 	
	function check_database()
		{
	    $email = $this->input->post('username');
	    $pass= $this->input->post('pass');
	    if($email!='' and $pass!='')
			{
			$password=md5($pass);
			$result = $this->Admin_model->login($email, $password);
			if($result)
				{
				return true;
				}
				else
				{
				$this->form_validation->set_message('check_database', 'Invalid email or password');
				return false;
				}
			}	
		}	
		
	// function to logout or unset session	 
	function logout()
	    {
	    session_start();
		session_destroy();
	    redirect(base_url(), 'refresh');
	    }	

	public function dashboard()
	{
		$data['title']='Dashboard';
		$data['items']= GetItem();
		$data['custpos']= GetAllCustomer();
		$data['suppos']= GetAllSupplier();
		$data['grns']= GetGRNs();
		$data['spos']= GetAllSupplierPO();
		$data['cpis']= GetAllCustomerPO();
		$this->RedirectToPageWithData('dashboard',$data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */