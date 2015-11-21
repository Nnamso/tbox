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

class Popup extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		$this->popup_m = $this->load->model('popup/popup_m');		
		$popup = $this->popup_m->getPopup($id);
		if(count($popup) > 0)
		{
			$css = getCss($popup, 'module');
			$this->data['css']	= $css;	
			$this->data['popup'] = $popup;	
			$this->load->view('popup', $this->data);
		}
	}
}