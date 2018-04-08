<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

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

	public function index()
	{
	
		if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
		
		$data['title']='Add User';
		$data['designations']=$this->db->get_where('designation')->result_array();
		$data['roles']=$this->db->get_where('user_role', array('status'=> 1))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('user/add_user',$data);
	}
	
	public function edit_user($uid)
	{
		if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
		
		$data['title']='Edit User';
		$data['designations']=$this->db->get_where('designation')->result_array();
		$data['roles']=$this->db->get_where('user_role', array('status'=> 1))->result_array();
		$data['userData'] = GetUserData($uid);
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('user/update_user',$data);
	}
	
	public function all_users()
	{
		if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
		
		$data['title']='All Users';
		$data['users']=$this->db->get_where('login',array('role !='=> '1'))->result_array();
		$this->RedirectToPageWithData('user/all_users',$data);
	}

	function adduser() 
	{
		if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
		
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
	    $this->form_validation->set_rules('email','E-Mail',  'required|valid_email|is_unique[login.email]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('name','name',  'required');
		$this->form_validation->set_rules('mobile','Mobile',  'required');
		$this->form_validation->set_rules('designation','designation',  'required');
		$this->form_validation->set_rules('role','role',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->index();
			}
		else // passed validation proceed to post success logic
			{
				$date=date('Y-m-d H:i:s');	
		
				$UserData = array(
					'email' => @$this->input->post('email'),
					'password' => md5(@$this->input->post('password')),
					'name' => @$this->input->post('name'),
					'mobile' => @$this->input->post('mobile'),
					'designation' => @$this->input->post('designation'),
					'role' => @$this->input->post('role'),
					'status' => '1',
					'date' => $date
				);
						
				$result=$this->Admin_model->SaveUser($UserData);
				
				if ($result == false) // the information has therefore been successfully saved in the db
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'user');   // or whatever logic needs to occur
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-green">New user added successfully.</span>');
						redirect(base_url().'user');   // or whatever logic needs to occur	
					}
				}
	}
	
	function update_user($id) 
	{
		if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
		
		$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
	    $this->form_validation->set_rules('email','E-Mail',  'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('name','name',  'required');
		$this->form_validation->set_rules('mobile','Mobile',  'required');
		$this->form_validation->set_rules('designation','designation',  'required');
		$this->form_validation->set_rules('role','role',  'required');
		$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');

		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
				$this->edit_user($id);
			}
		else // passed validation proceed to post success logic
			{
				$date=date('Y-m-d H:i:s');	
		
				$UserData = array(
					'email' => @$this->input->post('email'),
					'password' => md5(@$this->input->post('password')),
					'name' => @$this->input->post('name'),
					'mobile' => @$this->input->post('mobile'),
					'designation' => @$this->input->post('designation'),
					'role' => @$this->input->post('role'),
					'status' => '1',
					'date' => $date
				);
						
				$result=$this->Admin_model->UpdateUser($id, $UserData);
				
				if ($result == false) // the information has therefore been successfully saved in the db
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'user/all_users');   // or whatever logic needs to occur
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-green">User has been updated successfully.</span>');
						redirect(base_url().'user/all_users');   // or whatever logic needs to occur	
					}
				}
	}
	

	public function designation()
	{
		if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
		
		$data['title']='Designation';	
		$data['form_title']='Add Designation';
		$data['table_title']='Manage Designation';
		$data['DesignationArray']=$this->db->get_where('designation',array('status'=>'1'))->result_array();
		$data['msg']=$this->session->flashdata('msg');
		$this->RedirectToPageWithData('user/designation',$data);
	}

	function add_designation()
		{
			if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
			
			$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
			$this->form_validation->set_rules('name','name',  'required');
			$this->form_validation->set_rules('description','description',  'required');
			$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');


		if($this->form_validation->run() == FALSE) // validation hasn't been passed
			{
			$this->designation();
			}
			else // passed validation proceed to post success logic
			{
			$date=date('Y-m-d H:i:s');

			// build array for the model
			$DesignationData = array(
							'designation_name' => @$this->input->post('name'),
							'designation_description' => @$this->input->post('description'),
							'status' => '1',
							'date' => $date);
						
			// run insert model to write data to db
			$result=$this->Admin_model->SaveDesignation($DesignationData);
			if ($result == false) // the information has therefore been successfully saved in the db
				{
				$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
				redirect(base_url().'user/designation');   // or whatever logic needs to occur
				}
				else
				{
				$this->session->set_flashdata('msg','<span class="text-green">Designation added successfully.</span>');
				redirect(base_url().'user/designation');   // or whatever logic needs to occur	
				}
			}
		}
		
	function manage_user_designation($id)
		{
			//if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
			
			$data['title']='Update Designation';
			$data['DesignationArray']=$this->db->get_where('designation',array('status'=>'1'))->result_array();
			$data['designationdata']=$this->db->get_where('designation',array('id'=>$id, 'status'=>'1'))->row();
			$data['msg']=$this->session->flashdata('msg');
			$this->RedirectToPageWithData('user/update_designation',$data);
		}
		
	function Update_designation($id)
		{
			//if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
			
			$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
			$this->form_validation->set_rules('name','Designation',  'required');
			$this->form_validation->set_rules('description','Description',  'required');
			$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');
			
			$permission = serialize( @$this->input->post('permission') );

			if($this->form_validation->run() == FALSE) // validation hasn't been passed
				{
					$this->manage_user_designation($id);
				}
			else // passed validation proceed to post success logic
				{
					$data = array(
						'designation_name' => @$this->input->post('name'),
						'designation_description' => @$this->input->post('description'),
					);
					
					$result = $this->Admin_model->UpdateDesignation($id, $data);
					
					if ($result == false) // the information has therefore been successfully saved in the db
						{
							$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
							redirect(base_url().'user/designation/');   // or whatever logic needs to occur
						}
					else
						{
							$this->session->set_flashdata('msg','<span class="text-green">User Role added successfully.</span>');
							redirect(base_url().'user/designation/');   // or whatever logic needs to occur	
						}
				}
		}
		
	function add_user_role()
		{
			if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
			
			$data['title']='Add User Role';
			$data['table_title']='Manage Roles';
			$data['RolesArray']=$this->db->get_where('user_role',array('status'=>'1'))->result_array();
			$data['msg']=$this->session->flashdata('msg');
			$this->RedirectToPageWithData('user/add_user_role',$data);
		}
		
	function Save_user_role()
		{
			if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
			
			$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
			$this->form_validation->set_rules('user_role','user role',  'required');
			$this->form_validation->set_rules('permission','permission',  'required');
			$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');
			
			$permission = serialize( @$this->input->post('permission') );

			if($this->form_validation->run() == FALSE) // validation hasn't been passed
				{
					$this->add_user_role();
				}
			else // passed validation proceed to post success logic
				{
					$data = array(
						'role' => @$this->input->post('user_role'),
						'permission' => $permission,
					);
					
					$result = $this->Admin_model->SaveRole($data);
					
					if ($result == false) // the information has therefore been successfully saved in the db
						{
							$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
							redirect(base_url().'user/add_user_role');   // or whatever logic needs to occur
						}
					else
						{
							$this->session->set_flashdata('msg','<span class="text-green">User Role added successfully.</span>');
							redirect(base_url().'user/add_user_role');   // or whatever logic needs to occur	
						}
				}
		}
		
		function manage_user_role($id)
		{
			if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
			
			$data['title']='Update User Role';
			$data['roledata']=$this->db->get_where('user_role',array('id'=>$id, 'status'=>'1'))->row();
			$data['msg']=$this->session->flashdata('msg');
			$this->RedirectToPageWithData('user/update_user_role',$data);
		}
		
		function Update_user_role($id)
		{
			if( !is_UserWebAdmin()){ header('Location: '.base_url().'admin/dashboard'); }
			
			$this->form_validation->set_error_delimiters('<p class="text-red">', '</p>');
			$this->form_validation->set_rules('user_role','user role',  'required');
			$this->form_validation->set_rules('permission','permission',  'required');
			$this->form_validation->set_rules('validate', 'validate', 'callback_check_database');
			
			$permission = serialize( @$this->input->post('permission') );

			if($this->form_validation->run() == FALSE) // validation hasn't been passed
				{
					$this->manage_user_role($id);
				}
			else // passed validation proceed to post success logic
				{
					$data = array(
						'role' => @$this->input->post('user_role'),
						'permission' => $permission,
					);
					
					$result = $this->Admin_model->UpdateRole($id, $data);
					
					if ($result == false) // the information has therefore been successfully saved in the db
						{
							$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
							redirect(base_url().'user/add_user_role/');   // or whatever logic needs to occur
						}
					else
						{
							$this->session->set_flashdata('msg','<span class="text-green">User Role added successfully.</span>');
							redirect(base_url().'user/add_user_role/');   // or whatever logic needs to occur	
						}
				}
		}
		
		public function DeleteRole($id)
			{
				$query = $this->db->get_where('login',array('status'=>'1', 'role'=>$id))->num_rows();
				
				if( $query > 0 )
					{
						$this->session->set_flashdata('msg','<span class="text-red">Role is assign to a user so cant remove</span>');
						redirect(base_url().'user/add_user_role');   // or whatever logic needs to occur	
					}
				else
					{
						$result = $this->Admin_model->DeleteRole($id);

						if ($result == false) // the information has therefore been successfully saved in the db
							{
								$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
								redirect(base_url().'user/add_user_role');   // or whatever logic needs to occur
							}
						else
							{
								$this->session->set_flashdata('msg','<span class="text-green">User Role has been removed.</span>');
								redirect(base_url().'user/add_user_role');   // or whatever logic needs to occur	
							}
					}
			}
			
		public function DeleteDesignation($id)
			{
			
				$query = $this->db->get_where('login',array('status'=>'1', 'designation'=>$id))->num_rows();
				
				if( $query > 0 )
					{
						$this->session->set_flashdata('msg','<span class="text-red">Designation is assign to a user so cant remove</span>');
						redirect(base_url().'user/designation');   // or whatever logic needs to occur	
					}
				else
					{
						$result = $this->Admin_model->DeleteDesignation($id);

						if ($result == false) // the information has therefore been successfully saved in the db
							{
								$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
								redirect(base_url().'user/designation');   // or whatever logic needs to occur
							}
						else
							{
								$this->session->set_flashdata('msg','<span class="text-green">Designation has been removed.</span>');
								redirect(base_url().'user/designation');   // or whatever logic needs to occur	
							}
					}
			}
			
		public function DisableUser($id)
			{
				$result = $this->Admin_model->DisableUser($id);

				if ($result == false) // the information has therefore been successfully saved in the db
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'user/all_users');   // or whatever logic needs to occur
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-green">User has been disable.</span>');
						redirect(base_url().'user/all_users');   // or whatever logic needs to occur	
					}
			}
			
		public function EnableUser($id)
			{
				$result = $this->Admin_model->EnableUser($id);

				if ($result == false) // the information has therefore been successfully saved in the db
					{
						$this->session->set_flashdata('msg','<span class="text-red">An error occurred saving your information. Please try again later</span>');
						redirect(base_url().'user/all_users');   // or whatever logic needs to occur
					}
				else
					{
						$this->session->set_flashdata('msg','<span class="text-green">User has been enable.</span>');
						redirect(base_url().'user/all_users');   // or whatever logic needs to occur	
					}
			}
		
}
