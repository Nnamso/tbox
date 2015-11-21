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

class Banner extends MY_Controller{ 

	public function __construct(){ 
		parent::__construct(); 
		$this->load->helper('url');
	} 
	
	public function index($id = null){		
		$this->banner_m = $this->load->model('banner/banner_m');		
		$banner = $this->banner_m->getBanner($id);
		if(count($banner) > 0)
		{			
			$css = getCss($banner, 'module');
			$this->data['css']	= $css;
			$this->data['banner'] = $banner;
			$this->load->view('banner', $this->data);
		}
	}
}