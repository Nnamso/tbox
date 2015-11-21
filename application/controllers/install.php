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

class Install extends CI_Controller {
	
	public function __construct(){
        parent::__construct();		
	
		$this->load->helper('url');	
		$this->lang->load('system');
		$this->lang->load('frontend');
		
		$file = ROOTPATH .DS. 'install.txt';
					
		if (!file_exists ( $file ))
		{			
			redirect('index.php');
		}
		$this->config->set_item('sess_use_database', false);
		$this->config->set_item('subclass_prefix', 'INSTALL_');		
    }
	
	// check server
	public function index()
	{		
		$this->load->view('components/install/start', array());		
	}
	
	// add info
	public function info()
	{
		$data 	= array(
			'error' => false,
			'hostname' => 'localhost',
			'username' => '',
			'password' => '',
			'database' => ''
		);
		
		include_once (ROOTPATH .DS. 'application' .DS. 'config' .DS. 'database.php');
		
		if ($db['default']['hostname'] != '%HOSTNAME%')
		{
			$data['hostname']	= $db['default']['hostname'];
		}
		
		if ($db['default']['username'] != '%USERNAME%')
		{
			$data['username']	= $db['default']['username'];
		}
		
		if ($db['default']['password'] != '%PASSWORD%')
		{
			$data['password']	= $db['default']['password'];
		}
		
		if ($db['default']['database'] != '%DATABASE%')
		{
			$data['database']	= $db['default']['database'];
		}
		
		$this->load->view('components/install/info', $data);	
	}
	
	public function setup()
	{	
		$data = $this->input->post('data');
		
		$check = true;
		if (count($data) > 1)
		{
			$conn = @mysql_connect($data['hostname'], $data['username'], $data['password']);
						
			if (!$conn) {
				$data['error'] = lang('install_db_connect_false');
				$check = false;
			}
			
			$db_selected = @mysql_select_db($data['database'], $conn);
			if (!$db_selected){
				$data['error'] = lang('install_db_connect_false');
				$check = false;
			}
			
			if ($check === false)
			{
				$this->load->view('components/install/info', $data);
			}
			else
			{
				// save database config
				$this->load->helper('file');
				$config 	= ROOTPATH .DS. 'application' .DS. 'config' .DS. 'database_install.php';
				$file 		= ROOTPATH .DS. 'application' .DS. 'config' .DS. 'database.php';
				$content 	= read_file($config);
				
				$patterns		= array('/%HOSTNAME%/', '/%USERNAME%/', '/%PASSWORD%/', '/%DATABASE%/');
				$replacements 	= array($data['hostname'], $data['username'], $data['password'], $data['database']);
							
				$content 		= preg_replace($patterns, $replacements, $content);
				
				if ( ! write_file($file, $content))
				{
					$data['error'] = lang('install_write_file');		 
					$this->load->view('components/install/info', $data);
				}
				else
				{
					// add tables					
					$sql 		= ROOTPATH .DS. 'sql' .DS. 'tables.sql';
					$content 	= file_get_contents($sql);
					
					$tables 	= explode(';', $content);
					foreach($tables as $table)
					{
						if ($table == '' || strlen($table) < 10) continue;
						
						$result = mysql_query($table);
						if (!$result)
						{							
							$data['error'] = mysql_error();
							$this->load->view('components/install/info', $data);
							return true;
						}
					}
					
					// insert data
					$sql 		= ROOTPATH .DS. 'sql' .DS. 'data.sql';
					$content 	= file_get_contents($sql);
					$values 	= explode('INSERT INTO', $content);
					foreach($values as $value)
					{
						if ($value != '' && strlen($value) >10 )
						{
							$result = mysql_query('INSERT INTO' . $value);
						}
					}
					
					redirect('install/config');
				}
			}
		}
		else
		{
			redirect('install/info');
		}
	}
	
	public function config()
	{
		$data 	= array(
			'error' => false,
			'email' => '',
			'username' => ''			
		);
		$this->load->view('components/install/config', $data);	
	}
	
	public function save()
	{
		$data = $this->input->post('data');
		
		// add user admin
		$this->load->library('form_validation');
		$this->form_validation->set_rules('data[username]', lang('username'), 'trim|required|min_length[2]|max_length[255]|xss_clean'); 
		$this->form_validation->set_rules('data[email]', lang('email'), 'trim|required|valid_email'); 
		
		$data['error'] = false;
		if ( $data['password'] != $data['password1'])
		{			
			$data['error'] = 'Password and Confirm password is different';
		}
		else
		{
			if($this->form_validation->run() == TRUE)
			{
				$this->load->database();
				// save user admin
				$this->load->model('users_m');
				$user 	= array();
				
				$user['name'] 		= $data['username'];
				$user['username'] 	= $data['username'];
				$user['email'] 		= $data['email'];
				$user['password'] 	= $this->users_m->hash($data['password']);
				$user['group'] 		= 1;
				$user['block'] 		= 0;
				$user['send_email'] = 0;
				$user['register_date'] 	= date('Y-m-d H:i:s');
				$user['activation'] = 1;
					
				if($user_id = $this->users_m->save($user))
				{
					rename(ROOTPATH .DS. 'install.txt', ROOTPATH .DS. 'install.done.txt');
					
					$this->load->view('components/install/finish', array());
					return true;
				}
				else
				{
					$data['error'] = 'System can not add admin. Please try again';
				}
			}
			else
			{				
				$data['error'] = validation_errors();
			}
		}		
				
		$this->load->view('components/install/config', $data);
	}
}

?>