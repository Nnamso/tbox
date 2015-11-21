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

class Tab extends MY_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){ 
		$this->tab_m = $this->load->model('tab/tab_m');		
		$tab = $this->tab_m->getTab($id);
		if(count($tab) > 0)
		{
			$css = getCss($tab, 'module');
			$this->data['css']	= $css;	
			$this->data['tab'] = $tab;
			$this->load->view('index', $this->data);
		}
	}
}