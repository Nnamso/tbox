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

class Admin_Controller extends MY_Controller
{

	function __construct ()
	{
		parent::__construct();
		
		$this->load->helper('url');
		
		$file = ROOTPATH .DS. 'install.txt';
		if (file_exists ( $file ))
		{
			if ($this->uri->segment(1) != 'install')
			{
				redirect('install/index');
			}
		}
		
		$className 	= $this->router->fetch_class();
		$method		= $this->router->fetch_method();
		if ( method_exists($className, $method) == false )
		{
			redirect('error404');			
		}
		
		$CI = get_instance();		
		
		$view = $CI->uri->segment_array();
		
		$this->load->database();
		$this->load->library('session');
		$this->load->helper('form');
		$this->load->helper('cms');
		$this->load->library('form_validation');
		$this->lang->load('admin');
		$this->lang->load('system');
		$this->lang->load('metadata');
		$this->load->model('users_m');		
		
		

		// Login check
		$exception_uris = array(
			'admin/users/login', 
			'admin/users/logout',
		);
		
		if (in_array(uri_string(), $exception_uris) == FALSE) {
			if ($this->users_m->loggedin() === FALSE) {				
				if(empty($view[3])) $view[3] = '';
				if(empty($view[2])) $view[2] = '';
				if($view[2] == 'users' && ($view[3] == 'change_pass' || $view[3] == 'forget_password'))
				{					
					return true;
				}
				else
				{		
					if($view[3] != 'login'){
						redirect('admin/users/login');
					}
				}
			}
			else
			{
				$this->user 	= $this->session->userdata('user');
				if ($view[1] == 'admin' && empty($view[2]))
				{
					redirect('admin/dashboard');
				}					
			}
		}	
	}
}