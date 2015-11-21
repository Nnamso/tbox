<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Users extends Admin_Controller
{
	public function __construct ()
	{
		parent::__construct();
		
		$this->lang->load('user');
		$this->lang->load('metadata');
		$this->load->library('session');
		$this->user = $this->session->userdata('user');
	}

	public function index ()
	{
		// check user permission		
		$this->users_m->userPermission('edit_user');
		
		$this->data['breadcrumb'] = lang('user_admin_users_breadcrumb');
        $this->data['meta_title'] = lang('user_admin_users_meta_title');
        $this->data['sub_title'] = lang('user_admin_users_sub_title');
		
		// pagination
        $this->load->library('pagination'); 
        $this->load->helper('url');
        $config['base_url'] 	= base_url('admin/users'); 
		
		if($this->input->post('option'))
		{
			$this->session->set_userdata('search_user',  $this->input->post('search'));
			$this->session->set_userdata('option_user',  $this->input->post('option'));
		}
		
        $config['total_rows'] = $this->users_m->getUsers(true, $this->session->userdata('search_user'), $this->session->userdata('option_user'));
		
		if ($this->input->post('option'))
		{
			if ($this->input->post('per_page') == '')
				$this->session->set_userdata('per_page', $config['total_rows']);
			else
				$this->session->set_userdata('per_page', $this->input->post('per_page'));
		}
		
		if($this->session->userdata('per_page') != '')
			$config['per_page'] = $this->session->userdata('per_page');
		else
			$config['per_page'] 	= 20;
			
        $config['uri_segment'] = 3; 
        $config['next_link'] = lang('next'); 
        $config['prev_link'] = lang('prev'); 
        $config['first_link'] = lang('first'); 
        $config['last_link'] = lang('last'); 
        $config['num_links']	= 2;                 
        $this->pagination->initialize($config); 
        $this->data['links'] = $this->pagination->create_links();
		$this->data['per_page'] = $config['per_page'];
		$this->data['search'] = $this->session->userdata('search_user');
		$this->data['option'] = $this->session->userdata('option_user');
		$this->data['groups'] = $this->users_m->getGroupsUser(false, false);
		
		// Fetch all users
		$this->data['users'] = $this->users_m->getUsers(false, $this->session->userdata('search_user'), $this->session->userdata('option_user'), $config['per_page'], $this->uri->segment(3));
		
		// Load view
		$this->data['subview'] = 'admin/users/index';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function edit ($id = '')
	{
		// check user permission		
		$this->users_m->userPermission('edit_user');
		
		$this->data['error'] = '';
		$this->data['id'] = $id;
		$this->data['user'] = $this->users_m->getNew();
		$this->load->library('form_validation');
		$this->data['groups'] = $this->users_m->getGroupsUser(false, false);
		
		$this->data['forms'] = $this->users_m->getFormField('register');
		
		if ($id != '') 
		{ 
			//edit
			
			$this->data['user'] = $this->users_m->getUser($id);
			
			if(count($this->data['user']) == ''){
				$this->session->set_flashdata('error', lang('user_error_could_not_user_edit'));
				redirect(site_url().'admin/users');
			}
			
			if ($data = $this->input->post('data'))
			{
				// Set form  
				$this->form_validation->set_rules('data[name]', lang('name'), 'trim|required|min_length[2]|max_length[255]|xss_clean'); 
				$this->form_validation->set_rules('data[group]', lang('group'), 'trim|required|is_natural'); 
				$this->form_validation->set_rules('data[password]', lang('password'), 'trim|matches[cf_password]'); 
				$this->form_validation->set_rules('cf_password', lang('cf_password'), 'trim');
				
				if($this->form_validation->run() == TRUE)
				{
					$where = array(
						'id'=>$id,
					);
					
					if($this->users_m->checkUser($where)){
						if(isset($data['password']) && $data['password'] != '')
							$data_edit['password'] = $this->users_m->hash($data['password']);
						$data_edit['name'] = $data['name'];
						$data_edit['group'] = $data['group'];
						
						if($this->users_m->save($data_edit, $id)){
							//edit fields value.
							$this->users_m->deleteFields($id);
							
							$fields = $this->input->post('fields');
							if (count($fields) > 0 && $fields !== false)
							{
								foreach($fields as $k=>$val)
								{
									$field_val = array(
										'field_id'=>$k,
										'form_field'=>'register',
										'value'=>$val,
										'object'=>$id,
									);
									saveField($field_val);
								}
							}
							$this->session->set_flashdata('msg', lang('user_msg_update_success'));
						}else{
							$this->session->set_flashdata('error', lang('user_error_can_not_update'));
						}
					}else
					{
						$this->session->set_flashdata('error', lang('user_error_not_exists'));
					}
					redirect(site_url().'admin/users');
				}
			}
			$this->data['breadcrumb'] = lang('users_admin_edit_breadcrumb');
			$this->data['meta_title'] = lang('users_admin_edit_meta_title');
			$this->data['sub_title'] = lang('users_admin_edit_sub_title');
		}
		else 
		{ //add new
		
			if ($data = $this->input->post('data'))
			{
				// Set form  
				$this->form_validation->set_rules('data[name]', lang('name'), 'trim|required|min_length[2]|max_length[255]|xss_clean'); 
				$this->form_validation->set_rules('data[username]', lang('username'), 'trim|required|min_length[2]|max_length[255]|xss_clean|callback_checkUsername'); 
				$this->form_validation->set_rules('data[email]', lang('email'), 'trim|required|valid_email|callback_checkEmail'); 
				$this->form_validation->set_rules('data[password]', lang('password'), 'trim|required|min_length[2]|max_length[32]|matches[cf_password]'); 
				$this->form_validation->set_rules('cf_password', lang('cf_password'), 'trim|required|min_length[6]|max_length[32]');
				$this->form_validation->set_rules('data[group]', lang('group'), 'trim|required|is_natural'); 
				
				if($this->form_validation->run() == TRUE)
				{
					$data['activation'] = 1;
					$data['register_date'] = date("Y-m-d H:i:s"); 
					$data['password'] = $this->users_m->hash($data['password']);
					
					if($user_id = $this->users_m->save($data)){
						//save fields value.
						$fields = $this->input->post('fields');
						if (count($fields) > 0 && $fields !== false)
						{
							foreach($fields as $k=>$val)
							{
								$field_val = array(
									'field_id'=>$k,
									'form_field'=>'register',
									'value'=>$val,
									'object'=>$user_id,
								);
								saveField($field_val);
							}
						}
						
						$this->session->set_flashdata('msg', lang('users_msg_add_user_success'));
						redirect(site_url().'admin/users');
					}else{
						$this->data['error'] = lang('user_error_can_add_username');
					}
				}
				else
				{
					$this->data['user']->name = $data['name'];
					$this->data['user']->username = $data['username'];
					$this->data['user']->email = $data['email'];
					$this->data['user']->group = $data['group'];
				}
			}
			$this->data['breadcrumb'] = lang('users_admin_add_breadcrumb');
			$this->data['meta_title'] = lang('users_admin_add_meta_title');
			$this->data['sub_title'] = lang('users_admin_add_sub_title');
		}
		// Load the view
		$this->data['subview'] = 'admin/users/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function checkEmail()
	{
		$data = $this->input->post('data');
		$fields = array(
			"email" => $data['email']
		);
		
		if ($this->users_m->checkUser($fields)){
			$this->form_validation->set_message('checkEmail', lang('user_email_exits'));
			return false;
		} else {
			return true;
		}
	}
	
	public function checkUsername()
	{
		$data = $this->input->post('data');
		$fields = array(
			"username" => $data['username'],
		);
		
		if(!preg_match('/^[a-zA-Z0-9._]+?[a-zA-Z0-9]+$/D', $data['username']))
		{
			$this->form_validation->set_message('checkUsername', lang('user_username_invalid_error'));
			return false;
		}
		
		if ($this->users_m->checkUser($fields)){
			$this->form_validation->set_message('checkUsername', lang('user_username_exits'));
			return false;
		} else {
			return true;
		}
	}
	
	public function block ($id = null){
		
		// check user permission		
		$this->users_m->userPermission('edit_user');
		
		if($id != null){
			$data['block'] = 1;
			$this->users_m->_table_name = 'users';
			$this->users_m->save($data, $id);
			redirect(site_url().'admin/users');
		}else{
			if($this->input->post('checkb') != ''){
				foreach($this->input->post('checkb') as $id){
					$data['block'] = 1;
					$this->users_m->_table_name = 'users';
					$this->users_m->save($data, $id);
				}
			}
				redirect(site_url().'admin/users');
		}
	}
	
	public function unBlock ($id = null){
		// check user permission		
		$this->users_m->userPermission('edit_user');
		
		if($id != null){
			$data['block'] = 0;
			$this->users_m->_table_name = 'users';
			$this->users_m->save($data, $id);
			redirect(site_url().'admin/users');
		}else{
			if($this->input->post('checkb') != ''){
				foreach($this->input->post('checkb') as $id){
					$data['block'] = 0;
					$this->users_m->_table_name = 'users';
					$this->users_m->save($data, $id);
				}
			}
			redirect(site_url().'admin/users');
		}
	}

	public function delete ($id = null)
	{
		// check user permission		
		$this->users_m->userPermission('edit_user');
		
		if($id != null){
			if($this->user['id'] == $id)
			{
				$this->session->set_flashdata('error', lang('user_error_delete'));
				redirect(site_url().'admin/users');
			}
		
			if($this->users_m->delete($id))
				$this->session->set_flashdata('msg', lang('user_msg_delete_success'));
			else
				$this->session->set_flashdata('error', lang('user_error_delete'));

			redirect(site_url().'admin/users');
		}else{
			if($this->input->post('checkb') != ''){
				foreach($this->input->post('checkb') as $id){
					if($this->user['id'] != $id)
						$this->users_m->delete($id);
				}
				$this->session->set_flashdata('msg', lang('user_msg_delete_success'));
				redirect(site_url().'admin/users');
			}else{
				$this->session->set_flashdata('error', lang('user_error_delete'));
				redirect(site_url().'admin/users');
			}
		}
	}

	public function login ()
	{
		$this->data['meta_title'] = lang('user_admin_login_meta_title');
		// Redirect a user if he's already logged in
		$dashboard = 'admin/dashboard';
		$this->users_m->loggedin() == FALSE || redirect($dashboard);	
		
		$this->form_validation->set_rules('email', lang('user_email'), 'trim|required|valid_email');
        $this->form_validation->set_rules('password', lang('user_password'), 'trim|required|min_length[6]|max_length[32]');
		
		// Process form
		if ($this->form_validation->run() == TRUE) 
		{ 
			// We can login and redirect
			if ($this->users_m->login() == TRUE) 
			{
				redirect($dashboard);
			}
			else 
			{
				$this->session->set_flashdata('error', lang('user_login_error'));				
				redirect('admin/users/login');
			}
		}
		
		$this->data['breadcrumb'] = lang('users_admin_login_breadcrumb');
		$this->data['meta_title'] = lang('users_admin_login_meta_title');
		$this->data['sub_title'] = lang('users_admin_login_sub_title');
			
		// Load view
		$this->data['subview'] = 'admin/users/login';
		$this->load->view('admin/_layout_modal', $this->data);
	}	

	public function forgetPassword ()
	{
		$dashboard = 'admin/dashboard';
		$this->users_m->loggedin() == FALSE || redirect($dashboard);	
		
		if($this->input->post('email', true))
		{
			$where = array(
				'email'=>$this->input->post('email')
			);
			$info = $this->users_m->checkEmail($where);
			if(count($info) > 0)
			{
				// create key of active
			   $key = md5(uniqid());
			   $user = array(
					'username' => $info->username,
					'email' => $info->email,
					'password' => $info->password,
					'key' => $key
				);
				
				if ($this->users_m->addUserTemp($user))
				{
					// send email
					$config = array(
						'mailtype' => 'html',
					);
					$this->load->library('email', $config);
					$this->email->from(getEmail(config_item('admin_email')), getSiteName(config_item('site_name')));
					$this->email->to($info->email);    
					$this->email->subject ( lang('user_email_forgot_password') );
					
					$message = '<p>If you forgot password for login!</p>';
					$message = '<p>Please <a href="'.site_url(). 'admin/users/changepass/' .$key.'">Click here</a> to change your password!</p>';
					$this->email->message ($message);    
				
					if ($this->email->send()){
						$this->session->set_flashdata('msg', lang('user_msg_send_email_success'));
					}else
					{
						$this->session->set_flashdata('error', lang('user_error_not_send_email'));
					}
				} else {
					$this->session->set_flashdata('error', lang('user_error_can_not_check_email'));
				}
			}else{
				$this->session->set_flashdata('error', lang('user_error_email_not_exists'));
			}
		}
		redirect(site_url().'admin/users/login');
	}
	
	function changePass($key = '') { 
		$this->data['error'] = '';
		
		// change password.
		if($key == ''){
			if($this->users_m->loggedin() == FALSE)
				redirect(site_url().'admin/users/login');
				
			$this->data['breadcrumb'] = lang('users_admin_change_pass_breadcrumb');
			$this->data['meta_title'] = lang('user_admin_change_pass_meta_title');
			$this->data['sub_title'] = lang('user_admin_change_pass_sub_title');
			if($this->input->post('password'))
			{	
				if(($this->input->post('password') != '') && $this->input->post('password') == $this->input->post('cf_password'))
				{
					if($this->users_m->checkPass($this->input->post('old_password')))
					{
						$data['password'] = $this->users_m->hash($this->input->post('password'));
						if($this->users_m->save($data, $this->user['id']))
						{
							$this->data['msg'] = lang('user_msg_change_password_success');
						}else{
							$this->data['error'] = lang('user_error_not_change_pass');
						};
					}else{
						$this->data['error'] = lang('user_error_old_password_not_match');
					}
				}else
				{
					$this->data['error'] = lang('user_error_password_not_match');
				}
			}
			
			$this->data['subview'] = 'admin/users/change_password';
			$this->load->view('admin/_layout_main', $this->data);
			
		}else // confirm password.
		{
			$this->data['meta_title'] = lang('user_admin_login_change_pass_meta_title');
			$user = $this->users_m->getKey($key);
			if ( count($user) ==  0){
				$this->session->set_flashdata('error', lang('user_error_link_key_not_match'));
				redirect(site_url().'admin/users/login');
			}
			if($this->input->post('password') != '')
			{
				$password = $this->input->post('password', true);
				$cfpassword = $this->input->post('cf_password', true);
				if(strlen($password) < 6){
					$this->data['error'] = lang('user_error_password_length');
				}elseif($password != $cfpassword){
					$this->data['error'] = lang('user_error_cfpassword_not_match');
				}else{
					$where = array(
						'username'=>$user->username
					);
					if($this->users_m->changePass($password, $where)){
						$this->session->set_flashdata('msg', lang('user_msg_change_password_success'));
						$this->users_m->_table_name = 'users_temp';
						$this->users_m->_primary_key = 'key';
						$this->users_m->delete($key);
						redirect(site_url().'admin/users/login');
					}else{
						$this->session->set_flashdata('msg', lang('user_error_not_update_password'));
						redirect(site_url().'admin/users/login');
					};
				}
			}elseif($this->input->post('action') == 'change_pass')
			{
				$this->data['error'] = lang('user_error_password_is required');
			}
			
			$this->data['key'] = $key;
			$this->data['subview'] = 'admin/users/change_pass';
			$this->load->view('admin/_layout_modal', $this->data);
		}
	}
	
	public function logout ()
	{
		$this->users_m->logout();
		redirect('admin/users/login');
	}
	
	public function groups()
	{
		// check user permission		
		$this->users_m->userPermission('edit_user');
		
		$this->data['breadcrumb'] = lang('users_admin_groups_breadcrumb');
		$this->data['meta_title'] = lang('user_admin_groups_meta_title');
		$this->data['sub_title'] = lang('user_admin_groups_sub_title');
		
		// pagination
		
        $this->load->library('pagination'); 
        $this->load->helper('url');
        $config['base_url'] = base_url('admin/users/groups'); 
		
		if ($this->input->post('per_page'))
			$this->session->set_userdata('search_group', $this->input->post('search'));
			
        $config['total_rows'] = $this->users_m->getGroupsUser(true, false, $this->session->userdata('search_group'));
				
		if ($this->input->post('per_page'))
		{
			if ($this->input->post('per_page') == 'all')
				$this->session->set_userdata('per_page', $config['total_rows']);
			else
				$this->session->set_userdata('per_page', $this->input->post('per_page'));
		}
		
		if($this->session->userdata('per_page') != '')
			$config['per_page'] = $this->session->userdata('per_page');
		else
			$config['per_page'] 	= 10;
			
        $config['uri_segment'] = 4; 
        $config['next_link'] = lang('next'); 
        $config['prev_link'] = lang('prev'); 
        $config['first_link'] = lang('first'); 
        $config['last_link'] = lang('last'); 
        $config['num_links']	= 2;                 
        $this->pagination->initialize($config); 
        $this->data['links'] = $this->pagination->create_links();
		$this->data['per_page'] = $config['per_page'];
		$this->data['search'] = $this->session->userdata('search_group');
		
		$this->data['groups'] = $this->users_m->getGroupsUser(false, true, $this->session->userdata('search_group'), $config['per_page'], $this->uri->segment(4));
		$this->data['subview'] = 'admin/users/groups';
		$this->load->view('admin/_layout_main', $this->data);
	}

	public function editGroup($id = '')
	{
		// check user permission		
		$this->users_m->userPermission('edit_user');
		
		$this->data['id'] = $id;
		$folder = opendir(ROOTPATH.DS.'application'.DS.'controllers'.DS.'admin');
		$control = array();
		while (false !== ($filename = readdir($folder))) {
			if($filename != '.' && $filename != '..'){
				$control[str_replace('.php', '', $filename)] = ucfirst(str_replace('.php', '', $filename));
			}
		}
		$this->data['control'] = $control;
		$this->session->set_flashdata('group_id', $id);
		if($this->input->post('title'))
		{
			$this->form_validation->set_rules('title', lang('title'), 'trim|required|min_length[2]|max_length[200]|callback_checkTitleGroup');
			if ($this->form_validation->run() == TRUE) {
				$data['title'] = $this->input->post('title');
				$data['permissions'] = json_encode($this->input->post('permission'));
				$this->users_m->_table_name = 'user_groups';
				if($id == '')
				{
					if($this->users_m->save($data))
						$this->session->set_flashdata('msg', lang('user_admin_group_add_success_msg'));
					else
						$this->session->set_flashdata('error', lang('user_admin_group_add_error_msg'));
				}else
				{
					if($this->users_m->save($data, $id))
						$this->session->set_flashdata('msg', lang('user_admin_group_edit_success_msg'));
					else
						$this->session->set_flashdata('error', lang('user_admin_group_edit_error_msg'));
				}
				redirect(site_url().'admin/users/groups');
			}
		}
		
		if($id == '')
		{
			$this->data['breadcrumb'] = lang('users_admin_add_groups_breadcrumb');
			$this->data['meta_title'] = lang('user_admin_add_groups_meta_title');
			$this->data['sub_title'] = lang('user_admin_add_groups_sub_title');
			$this->data['group'] = $this->users_m->getNewGroup();
		}else
		{
			$this->data['breadcrumb'] = lang('users_admin_edit_groups_breadcrumb');
			$this->data['meta_title'] = lang('user_admin_edit_groups_meta_title');
			$this->data['sub_title'] = lang('user_admin_edit_groups_sub_title');
			$this->data['group'] = $this->users_m->getGroupUser($id);
		}
		
		$this->data['subview'] = 'admin/users/edit_group';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function checkTitleGroup()
	{
		if($this->users_m->checkTitleGroup($this->input->post('title'), $this->session->flashdata('group_id')))
		{
			$this->form_validation->set_message('checkTitleGroup', lang('user_title_group_exits_msg'));
			return false;
		}else
		{
			return true;
		}
	}
	
	public function deleteGroup($id = '')
	{
		// check user permission		
		$this->users_m->userPermission('edit_user');
		
		$this->users_m->_table_name = 'user_groups';
		if($id != '')
		{
			$group = $this->users_m->getGroupUser($id, false);
			if(count($group))
			{
				if($this->users_m->delete($id))
				{
					// delete all users in group.
					if(isset($group->id))
					{
						$users = $this->users_m->getUsersGroup($group->id);
						if(count($users) > 0)
						{
							$this->users_m->_table_name = 'users';
							foreach($users as $user)
							{
								$this->users_m->delete($user->id);
							}
						}
					}
					$this->session->set_flashdata('msg', lang('user_delete_group_success_msg'));
				}else
				{
					$this->session->set_flashdata('error', lang('user_delete_group_error_msg'));
				}
			}else
			{
				$this->session->set_flashdata('error', lang('user_delete_group_default_error_msg'));
			}
		}elseif($checkb = $this->input->post('checkb'))
		{
			foreach($checkb as $id)
			{
				$group = $this->users_m->getGroupUser($id, false);
				if(count($group))
				{
					if($this->users_m->delete($id))
					{
						// delete all users in group.
						if(isset($group->id))
						{
							$users = $this->users_m->getUsersGroup($group->id);
							if(count($users) > 0)
							{
								$this->users_m->_table_name = 'users';
								foreach($users as $user)
								{
									$this->users_m->delete($user->id);
								}
							}
						}
						$this->session->set_flashdata('msg', lang('user_delete_group_success_msg'));
					}else
					{
						$this->session->set_flashdata('error', lang('user_delete_group_some_error_msg'));
						break;
					}
				}else
				{
					$this->session->set_flashdata('error', lang('user_delete_group_default_some_error_msg'));
				}
			}
		}
		redirect(site_url().'admin/users/groups');
	}
	
	public function defaultGroup($id = '')
	{
		// check user permission		
		$this->users_m->userPermission('edit_user');
		
		$this->users_m->_table_name = 'user_groups';
		if($id != '')
		{
			$default = $this->users_m->getDefault();
			if(count($default) > 0)
			{
				$data['default'] = 0;
				$this->users_m->save($data, $default->id);
			}
			$update['default'] = 1;
			$this->users_m->save($update, $id);
		}
		redirect(site_url().'admin/users/groups');
	}
}