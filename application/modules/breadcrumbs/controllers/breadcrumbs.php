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

class breadcrumbs extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		$this->breadcrumbs_m = $this->load->model('breadcrumbs/breadcrumbs_m');		
		$breadcrumbs = $this->breadcrumbs_m->getbreadcrumbs($id);
		if(count($breadcrumbs) > 0)
		{
			$css = getCss($breadcrumbs, 'module');
			$this->data['css']	= $css;	
			$this->data['breadcrumbs'] = $breadcrumbs;	
			$this->load->view('breadcrumbs', $this->data);
		}
	}
}