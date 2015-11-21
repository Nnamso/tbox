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

class m_search extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		$this->m_search_m = $this->load->model('m_search/m_search_m');		
		$search = $this->m_search_m->getsearch($id);
		if(count($search) > 0)
		{
			$css = getCss($search, 'module');
			$this->data['css']	= $css;	
			$this->data['search'] = $search;	
			$this->load->view('m_search', $this->data);
		}
	}
}