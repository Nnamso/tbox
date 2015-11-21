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

class Maps extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		$this->maps_m = $this->load->model('maps/maps_m');		
		$maps = $this->maps_m->getMaps($id);
		if(count($maps) > 0)
		{
			$css = getCss($maps, 'module');
			$this->data['css']	= $css;	
			$this->data['maps'] = $maps;	
			$this->load->view('maps', $this->data);
		}
	}
}