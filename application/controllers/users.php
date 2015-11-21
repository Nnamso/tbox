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

class Users extends Frontend_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->lang->load('system');
		$this->lang->load('user');
		$this->load->model('users_m');
		$this->user = $this->session->userdata('user');
	}
	
	function index()
	{
		redirect(site_url());
	}
	
	function login()
	{
		// check ajax login.
		if($this->input->post('ajax') !== false)
		{
			$ajax = true;
			$langFile = ROOTPATH .DS. 'media' .DS. 'data' .DS. 'lang.ini';
			$langdata = parse_ini_file($langFile);
		}
		else
		{
			$ajax = false;
		}
		
		//get data facebook.
		$settings = getSettings();
		if(isset($settings->app_id)) 
			$appid = $settings->app_id; 
		else 
			$appid = '';
			
		if(isset($settings->app_secret)) 
			$appsecret = $settings->app_secret; 
		else 
			$appsecret = '';
			
		$config = array(
			'appId'=>$appid,
			'secret'=>$appsecret,
		);
		$this->load->library('library/facebook', $config);
		$user_facebook = $this->facebook->getUser();
		if($user_facebook)
		{
			try{
				$facebook = $this->facebook->api('/me');
			} 
			catch(FacebookApiException $e) 
			{
				return error_log($e->getMessage());
				$user_facebook = null;
			}
		}
		
		//check token.
		if ($this->auth->checkToken() === false && empty($facebook['email']))
		{
			if($ajax)
			{
				echo $this->load->view('components/users/ajax', array('error'=>lang('user_login_ajax_token_error_msg'), 'data'=>array(), 'lang'=>$langdata), true);
				return false;
			}
			else
			{
				redirect(site_url('user/login'));
			}
		}
		
		//check loggedin.
		if(isset($this->user['username']) && $this->user['username'] != '')
		{
			if($ajax)
			{
				$userdata = $this->session->userdata('user');
				echo $this->load->view('components/users/ajax', array('error'=>'', 'data'=>$userdata), true);
				return false;
			}
			else
			{
				redirect(site_url());
			}
		}
			
		$this->load->library('form_validation');
		// Login form
		if($this->input->post('data'))
		{
			// Set form   
			$this->form_validation->set_rules('data[email]', lang('email'), 'trim|required|max_length[100]|valid_email'); 
			$this->form_validation->set_rules('data[password]', lang('password'), 'trim|required|min_length[6]|max_length[128]'); 
			
			// login.
			if($this->form_validation->run() == TRUE)
			{
				if($this->users_m->login(false))
				{
					if($ajax)
					{
						$userdata = $this->session->userdata('user');
						echo $this->load->view('components/users/ajax', array('error'=>'', 'data'=>$userdata), true);
						return false;
					}
					else
					{
						$return 	= $this->input->post('return');
						if ($return == false) $return = '';
						redirect(site_url($return));
					}
				}
				else
				{
					$this->session->set_flashdata('error', lang('user_login_not_match_msg'));
					
					if ($ajax == true)
					{
						echo $this->load->view('components/users/ajax', array('error'=>lang('user_login_not_match_msg'), 'data'=>array(), 'lang'=>$langdata), true);
						return false;
					}
				}
			}
			else
			{
				$this->session->set_flashdata('error', validation_errors());
				
				if ($ajax == true)
				{
					echo $this->load->view('components/users/ajax', array('error'=>validation_errors(), 'data'=>array(), 'lang'=>$langdata), true);
					return false;
				}
			}
		}
		else
		{
			// login.
			if(isset($facebook['email']))
			{
				$this->users_m->login(false, $facebook['email']); 
				$sUser = $this->session->userdata('user');
				if(isset($sUser['username']) && $sUser['username'] != '') // loggedin.
				{
					if ($this->input->post('fb') == 'facebook')
					{
						$userdata = $this->session->userdata('user');
						echo $this->load->view('components/users/ajax', array('error'=>'', 'data'=>$userdata), true);
						return false;
					}else
					{
						redirect(site_url('user/login'));
					}					
				}else // register by facebook.
				{
					// check user exists.
					$where_check = array(
						'email'=>$facebook['email'],
					);
					if($this->users_m->checkUser($where_check))
					{
						if ($this->input->post('fb') == 'facebook')
						{
							$userdata = $this->session->userdata('user');
							echo $this->load->view('components/users/ajax', array('error'=>lang('user_login_ajax_facebook_not_register_error_msg'), 'data'=>$userdata), true);
							return false;
						}else
						{
							$this->session->set_flashdata('error', lang('user_login_not_match_msg'));
							redirect(site_url('user/login'));
						}
					}
						
					if(isset($facebook['username']))
					{
						$username = $facebook['username'];
						$name = $facebook['username'];
					}else
					{
						if(!isset($facebook['id']))
						{
							if ($this->input->post('fb') == 'facebook')
							{
								$userdata = $this->session->userdata('user');
								echo $this->load->view('components/users/ajax', array('error'=>lang('user_login_ajax_facebook_not_register_error_msg'), 'data'=>$userdata), true);
								return false;
							}else
							{
								$this->session->set_flashdata('error', lang('user_login_ajax_facebook_not_register_error_msg'));
								redirect(site_url());
							}
						}
						$username = $facebook['id'];
						$name = $facebook['id'];
					}
					
					if(isset($facebook['name']))
						$name = $facebook['name'];
					
					// get group id
					$group	= $this->users_m->getDefault();
					if ( count($group) > 0)
						$group_id 	= $group->id;
					else
						$group_id 	= 0;
					
					$pass = md5(uniqid());
					$data = array(
						"name" 			=> $name,
						"username" 		=> $username,
						"email" 		=> $facebook['email'],
						"password" 		=> $this->users_m->hash($pass),
						"group" 		=> $group_id,
						"block" 		=> 0,
						"send_email" 	=> 1,
						"register_date" => date('Y-m-d H:i:s'),
						"activation" 	=> 1
					);
					
					$this->users_m->save($data);
					$this->users_m->login(false, $facebook['email']);
					$sUser = $this->session->userdata('user');
					if(isset($sUser['username']) && $sUser['username'] != '')
					{
						//config email.
						$config = array(
							'mailtype' => 'html',
						);
						$subject = 'Registered site '.getSiteName(config_item('site_name'));
						$message = '<p>Hi, '.$username.' </p><p> Thank you for registering on our website.</p><p>You can login here: <a target="_blank" href="'.site_url('user/login').'" title="'.getSiteName(config_item('site_name')).'">'.getSiteName(config_item('site_name')).'</a> with email: '.$facebook['email'].' </p><p> Password: '.$pass.'</p>';
						
						$this->load->library('email', $config);
						$this->email->from(getEmail(config_item('admin_email')), getSiteName(config_item('site_name')));
						$this->email->to($data['email']);    
						$this->email->subject ( $subject);
						$this->email->message ($message);   
						$this->email->send();
						
						if ($this->input->post('fb') == 'facebook')
						{
							$userdata = $this->session->userdata('user');
							echo $this->load->view('components/users/ajax', array('error'=>'', 'data'=>$userdata), true);
							return false;
						}else
						{
							redirect(site_url());
						}
					}else
					{
						if ($this->input->post('fb') == 'facebook')
						{
							$userdata = $this->session->userdata('user');
							echo $this->load->view('components/users/ajax', array('error'=>lang('user_login_ajax_facebook_not_register_error_msg'), 'data'=>$userdata), true);
							return false;
						}else
						{
							$this->session->set_flashdata('error', lang('user_login_ajax_facebook_not_register_error_msg'));
							redirect(site_url('user/login'));
						}
					}
				}
			}
		}
		
		// login error.
		if ($ajax == true)
		{
			echo $this->load->view('components/users/ajax', array('error'=>lang('user_login_ajax_not_login_error_msg'), 'data'=>array(), 'lang'=>$langdata), true);
			return false;
		}
		
		$this->session->set_flashdata('data_fields', $this->input->post('data'));
		redirect(site_url().'user/login');
	}
	
	function confirm($key = '')
	{
		//check loggedin.
		if(isset($this->user['username']) && $this->user['username'] != '')
			redirect(site_url());
			
		$user = $this->users_m->getKey($key);
		
		// get group id
		$group	= $this->users_m->getDefault();
		if ( count($group) > 0)
			$group_id 	= $group->id;
		else
			$group_id 	= 0;
		
		//check key user.
		if ( count($user) && $user != false )
		{
			$data = array(
				"name" 			=> $user->username,
				"username" 		=> $user->username,
				"email" 		=> $user->email,
				"password" 		=> $user->password,
				"group" 		=> $group_id,
				"block" 		=> 0,
				"send_email" 	=> 1,
				"register_date" 	=> date('Y-m-d H:i:s'),
				"activation" 	=> 1
			);
			
			// check account exists.
			$post = $this->input->post('data');
			$fields = array(
				"email" => $post['email'],
			);
			if ($this->users_m->checkUser($fields)){
				$this->session->set_flashdata('error', lang('user_error_email_or_username_exists'));
				redirect('user/login');
			}
			
			//save data.
			$this->users_m->_table_name = 'users';
			$user_id = $this->users_m->save($data);
			
			//save field.
			$fields = $this->users_m->checkField($key);
			if(count($fields) > 0)
			{
				foreach($fields as $value)
				{
					$field_value = array(
						'object'=>$user_id
					);
					saveField($field_value, $value->id);
				}
			}
			
			// delete user temp.
			$this->users_m->_table_name = 'users_temp';
			$this->users_m->delete($user->id);
			
			// set session value.
			$user = array(
				'name' => $user->username,
				'username' => $user->username,
				'email' => $user->email,
				'id' => $user_id,
				'loggedin' => TRUE,
			);
			$this->session->set_userdata('user', $user);
			$this->session->set_userdata($user);
			redirect(site_url());
		} else 
		{
			redirect('user/login');
		}
	}
	
	function register()
	{
		$return		= $this->input->post('return');		
		// check register ajax.
		if($this->input->post('ajax') !== false)
		{
			$ajax = true;
			$langFile = ROOTPATH .DS. 'media' .DS. 'data' .DS. 'lang.ini';
			$langdata = parse_ini_file($langFile);
		}
		else
		{
			$ajax = false;
		}
		
		//check token.
		if ($this->auth->checkToken() === false)
		{
			if($ajax)
			{
				if ($return !== false)
					redirect(site_url('user/register'));
					
				echo $this->load->view('components/users/ajax', array('error'=>lang('user_login_ajax_token_error_msg'), 'data'=>array(), 'lang'=>$langdata), true);
				return false;
			}
			else
			{
				redirect(site_url('user/register'));
			}
		}
		
		//check loggedin.
		if(isset($this->user['username']) && $this->user['username'] != '')
		{
			if($ajax)
			{
				if ($return !== false)
					redirect(site_url($return));
					
				$userdata = $this->session->userdata('user');
				echo $this->load->view('components/users/ajax', array('error'=>'', 'data'=>$userdata), true);
				return false;
			}
			else
			{
				redirect(site_url());
			}
		}
			
		$this->load->library('form_validation');
		if($data = $this->input->post('data'))
		{
			// Set form  
			$this->form_validation->set_rules('data[username]', lang('username'), 'trim|required|min_length[2]|max_length[150]|xss_clean|callback_checkUsername'); 
			$this->form_validation->set_rules('data[email]', lang('email'), 'trim|required|max_length[100]|valid_email|callback_checkEmail'); 
			if($ajax)
			{
				$this->form_validation->set_rules('data[password]', lang('password'), 'trim|required|min_length[6]|max_length[128]'); 
			}
			else
			{
				$this->form_validation->set_rules('data[password]', lang('password'), 'trim|required|min_length[6]|max_length[128]|matches[cf_password]'); 
				$this->form_validation->set_rules('cf_password', lang('cf_password'), 'trim|required|min_length[6]|max_length[128]');
			}
			
			// validate true.
			if($this->form_validation->run() == TRUE)
			{
			
				// register ajax.
				if($ajax)
				{
					// get group id
					$group	= $this->users_m->getDefault();
					if ( count($group) > 0)
						$group_id 	= $group->id;
					else
						$group_id 	= 0;
			
					$data['name'] = $data['username'];
					$data['password'] = $this->users_m->hash($data['password']);
					$data['group'] = $group_id;
					$data['block'] = 0;
					$data['send_email'] = 1;
					$data['register_date'] = date('Y-m-d H:i:s');
					$data['activation'] = 1;
					
					if($user_id = $this->users_m->save($data)) //register success.
					{					
						$user['id'] = $user_id;
						$user['name'] = $data['username'];
						$user['username'] = $data['username'];
						$user['email'] = $data['email'];
						$user['admin'] = '';
						$user['loggedin'] = 1;
						$this->session->set_userdata('user', $user);
						$this->session->set_userdata($user);
						
						//config email.
						$config = array(
							'mailtype' => 'html',
						);
						$subject = 'Registered site '.config_item('site_name');
						$message = '<p>Hi, '.$data['username'].' <br/> Thank you for registering on our website.<br/> You can login here: <a target="_blank" href="'.site_url().'user/login" title="'.config_item('site_name').'">'.config_item('site_name').'</a> with username: '.$data['username'].'</p>';
						
						$this->load->library('email', $config);
						$this->email->from(config_item('admin_email'), config_item('site_name'));
						$this->email->to($data['email']);    
						$this->email->subject ( $subject);
						$this->email->message ($message);   
					
						if ($this->email->send())
							$msg = lang('user_register_send_email_success_msg');
						else
							$msg = lang('user_register_send_email_error_msg');
						
						if ($return !== false)
							redirect(site_url($return));
						
						$userdata = $this->session->userdata('user');
						echo $this->load->view('components/users/ajax', array('msg'=>$msg, 'data'=>$userdata), true);
						return false;
					}
					else // cannot register.
					{
						if ($return !== false)
							redirect(site_url('user/register'));
							
						echo $this->load->view('components/users/ajax', array('error'=>lang('user_login_ajax_not_register_error_msg'), 'data'=>array(), 'lang'=>$langdata), true);
						return false;
					}
				}
				else // register form.
				{
					$this->session->set_userdata('session_register', 1);
					$key = md5(uniqid());
					$data['password'] = $this->users_m->hash($data['password']);
					$data['created'] = date('Y-m-d H:i:s');
					$data['key'] = $key;
				}
				
				//save fields value.
				$fields = $this->input->post('fields');
				if(is_array($fields))
				{
					foreach($fields as $k=>$val)
					{
						$field_val = array(
							'field_id'=>$k,
							'form_field'=>'register',
							'value'=>$val,
							'object'=>$key,
						);
						saveField($field_val);
					}
				}
				
				//save data in table temp and send emai.
				if ($this->users_m->addUserTemp($data))
				{
					$post = $this->input->post('data');
					//params shortcode
					$params = array(
						'username'=>$data['username'],
						'email'=>$data['email'],
						'password'=>$post['password'],
						'date'=>date('Y-m-d H:i:s'),
						'confirm_url'=>site_url('users/confirm/' .$key),
					);
					//config email.
					$config = array(
						'mailtype' => 'html',
					);
					$subject = configEmail('sub_register', $params);
					$message = configEmail('register', $params);
					
					$this->load->library('email', $config);
					$this->email->from(getEmail(config_item('admin_email')), getSiteName(config_item('site_name')));
					$this->email->to($data['email']);    
					$this->email->subject ( $subject);
					$this->email->message ($message);   
					
					if (!$this->email->send()){
						redirect('user/complete/email');
					}
					redirect('user/complete/success');
				} else {
					redirect('user/complete/error');
				}
			}
			else
			{
				$this->session->set_flashdata('error', validation_errors());
				
				if($ajax)
				{
					if ($return !== false)
						redirect(site_url('user/register'));
						
					echo $this->load->view('components/users/ajax', array('error'=>validation_errors(), 'data'=>array(), 'lang'=>$langdata), true);
					return false;
				}
			}
		}
		
		// login error.
		if($ajax)
		{
			echo $this->load->view('components/users/ajax', array('error'=>lang('user_login_ajax_not_register_error_msg'), 'data'=>array(), 'lang'=>$langdata), true);
			return false;
		}
				
		$this->session->set_flashdata('data_fields', $this->input->post('data'));
		redirect(site_url().'user/register');
	}
	
	public function checkEmail()
	{
		$post = $this->input->post('data');
		$fields = array(
			"email" => $post['email'],
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
		$post = $this->input->post('data');
		$fields = array(
			"username" => $post['username'],
		);
		
		if(!preg_match('/^[a-zA-Z0-9._]+?[a-zA-Z0-9]+$/D', $post['username']))
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
	
	//forgot password.
	function forgotPassword()
	{
		//check token.
		if ($this->auth->checkToken() === false)
			redirect(site_url('user/forgotpassword'));
			
		//check loggedin.
		if(isset($this->user['username']) && $this->user['username'] != '')
			redirect(site_url());
			
		if($data = $this->input->post('data'))
		{
			if(!isset($data['email']))
				$data['email'] = '';
				
			$where = array(
				'email'=>$data['email']
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
				
				// add data table temp and send email.
				if ($this->users_m->addUserTemp($user))
				{
					//params shortcode
					$params = array(
						'username'=>$info->username,
						'email'=>$info->email,
						'date'=>date('Y-m-d H:i:s'),
						'confirm_url'=>site_url('user/changepass/' .$key),
					);
					//config email.
					$config = array(
						'mailtype' => 'html',
					);
					$subject = configEmail('sub_forget_pass', $params);
					$message = configEmail('forget_pass', $params);
					
					$this->load->library('email', $config);
					$this->email->from(getEmail(config_item('admin_email')), getSiteName(config_item('site_name')));
					$this->email->to($data['email']);    
					$this->email->subject ( $subject);
					$this->email->message ($message);   
					
					if ($this->email->send())
						$this->session->set_flashdata('msg', lang('user_msg_send_email_success'));
					else
						$this->session->set_flashdata('error', lang('user_error_not_send_email'));
				} else 
				{
					$this->session->set_flashdata('error', lang('user_error_can_not_check_email'));
				}
			}else
			{
				$this->session->set_flashdata('error', lang('user_error_email_not_exists'));
			}
		}
		redirect(site_url().'user/forgotpassword');
	}
	
	function changePass() {
	
		// check ajax login.
		if($this->input->post('ajax') !== false)
		{
			$ajax = true;
			$langFile = ROOTPATH .DS. 'media' .DS. 'data' .DS. 'lang.ini';
			$langdata = parse_ini_file($langFile);
		}
		else
		{
			$ajax = false;
		}
		
		//check token.
		if ($this->auth->checkToken() === false)
			redirect(site_url('user/changepass'));
		
		if($data = $this->input->post('data'))
		{
			if(!isset($this->user['username']) && $this->input->post('key') == '')
			{
				if($ajax)
				{
					$userdata = $this->session->userdata('user');
					echo $this->load->view('components/users/ajax', array('msg'=>'', 'data'=>$userdata), true);
					return false;
				}else
				{
					redirect(site_url().'user/register');
				}
			}
			
			$this->load->library('form_validation');
			
			// change pass when forget.			
			if($this->input->post('key') != '') 
			{
				//check loggedin.
				if(isset($this->user['username']) && $this->user['username'] != '')
					redirect(site_url());
				
				//set form.
				$this->form_validation->set_rules('data[password]', lang('new_password'), 'trim|required|min_length[6]|max_length[128]|matches[cf_password]'); 
				$this->form_validation->set_rules('cf_password', lang('cf_password'), 'trim|required|min_length[6]|max_length[128]');
				
				// validate true.
				if($this->form_validation->run() == TRUE)
				{
					$user = $this->users_m->getKey($this->input->post('key'));
					
					if(count($user) && $user != false)
					{
						$where = array(
							'email'=>$user->email,
						);
						if($this->users_m->changePass($data['password'], $where))
						{
							// delete user temp.
							$this->users_m->_table_name = 'users_temp';
							$this->users_m->delete($user->id);
							$this->session->set_flashdata('msg', lang('user_msg_change_password_success'));
							
							//params shortcode email.
							$params = array(
								'username'=>$user->username,
								'password'=>$data['password'],
								'email'=>$user->email,
								'date'=>date('Y-m-d H:i:s'),
							);
							
							//config email.
							$config = array(
								'mailtype' => 'html',
							);
							$subject = configEmail('sub_change_pass', $params);
							$message = configEmail('change_pass', $params);
							
							$this->load->library('email', $config);
							$this->email->from(getEmail(config_item('admin_email')), getSiteName(config_item('site_name')));
							$this->email->to($this->user['email']);    
							$this->email->subject ( $subject);
							$this->email->message ($message);   
							$this->email->send();
						}else
						{
							$this->session->set_flashdata('error', lang('user_error_change_password_error'));
						}
					}else
					{
						$this->session->set_flashdata('error', lang('user_error_link_key_not_match'));
					}
				}else
				{
					$this->session->set_flashdata('error', validation_errors());
				}
				redirect(site_url().'user/changepass/'.$this->input->post('key'));
			}
			
			// change pass when loggedin.
			//set form.
			if($ajax == false)
			{
				$this->form_validation->set_rules('data[old_password]', lang('old_password'), 'trim|required|min_length[6]|max_length[128]|callback_checkPassword');
			}
			$this->form_validation->set_rules('data[password]', lang('new_password'), 'trim|required|min_length[6]|max_length[128]|matches[cf_password]'); 
			$this->form_validation->set_rules('cf_password', lang('cf_password'), 'trim|required|min_length[6]|max_length[128]');
			
			// validate true.
			if($this->form_validation->run() == TRUE)
			{
				if($this->users_m->updatePass($data['password'], $this->user['id']))
				{
					//params shortcode email.
					$params = array(
						'username'=>$this->user['username'],
						'password'=>$data['password'],
						'email'=>$this->user['email'],
						'date'=>date('Y-m-d H:i:s'),
					);
					
					//config email.
					$config = array(
						'mailtype' => 'html',
					);
					$subject = configEmail('sub_change_pass', $params);
					$message = configEmail('change_pass', $params);
					
					$this->load->library('email', $config);
					$this->email->from(getEmail(config_item('admin_email')), getSiteName(config_item('site_name')));
					$this->email->to($this->user['email']);    
					$this->email->subject ( $subject);
					$this->email->message ($message);   
					$this->email->send();
					
					if($ajax)
					{
						$userdata = $this->session->userdata('user');
						echo $this->load->view('components/users/ajax', array('msg'=>lang('user_msg_change_password_success'), 'data'=>$userdata), true);
						return false;
					}else
					{
						$this->session->set_flashdata('msg', lang('user_msg_change_password_success'));
					}
				}else
				{
					if($ajax)
					{
						$userdata = $this->session->userdata('user');
						echo $this->load->view('components/users/ajax', array('error'=>lang('user_error_change_password_error'), 'data'=>$userdata), true);
						return false;
					}else
					{
						$this->session->set_flashdata('error', lang('user_error_change_password_error'));
					}
				}
			}else
			{
				if($ajax)
				{
					$userdata = $this->session->userdata('user');
					echo $this->load->view('components/users/ajax', array('error'=>validation_errors(), 'data'=>$userdata), true);
					return false;
				}else
				{
					$this->session->set_flashdata('error', validation_errors());
				}
			}
		}
		redirect(site_url('user/changepass'));
	}
	
	function checkPassword()
	{
		$post = $this->input->post('data');
		if ($this->users_m->checkPass($post['old_password']) == false){
			$this->form_validation->set_message('checkPassword', lang('user_change_pass_old_pass_not_match_msg'));
			return false;
		} else {
			return true;
		}
	}
	
	function logout()
	{
		$this->session->unset_userdata('user');
		redirect(site_url());
	}
}

?>