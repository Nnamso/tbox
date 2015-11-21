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

class Social extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		$this->social_m = $this->load->model('social/social_m');		
		$social = $this->social_m->getSocial($id);
		if(count($social) > 0)
		{
			$css = getCss($social, 'module');
			$this->data['css']	= $css;	
			$this->data['social'] = $social;	
			$this->load->view('social', $this->data);
		}
	}
}