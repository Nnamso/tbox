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

class Login extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
		$this->lang->load('login');
	} 
	
	public function index($id = ''){
		$this->login_m = $this->load->model('login/login_m');		
		$login = $this->login_m->getlogin($id);
		if(count($login) > 0)
		{
			$css = getCss($login, 'module');
			$this->data['css']	= $css;	
			$this->data['login'] = $login;	
			$this->load->view('login', $this->data);
		}
	}
}