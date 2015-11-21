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

class Likebox extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		$this->likebox_m = $this->load->model('likebox/likebox_m');		
		$likebox = $this->likebox_m->getLikebox($id);
		if(count($likebox) > 0)
		{
			$css = getCss($likebox, 'module');
			$this->data['css']	= $css;	
			$this->data['likebox'] = $likebox;	
			$this->load->view('likebox', $this->data);
		}
	}
}