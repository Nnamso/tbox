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

class M_Custom extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		$this->custom_m = $this->load->model('m_custom/m_custom_m');		
		$custom = $this->custom_m->getCustom($id);
		if(count($custom) > 0)
		{
			$css = getCss($custom, 'module');
			$this->data['css']	= $css;		
			$this->data['custom'] = $custom;
			$this->load->view('m_custom', $this->data);
		}
	}
}