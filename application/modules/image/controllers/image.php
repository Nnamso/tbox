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

class Image extends MY_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		
		if ( (int) $id <= 0) return;		
		$this->image_m = $this->load->model('image/image_m');		
		$image = $this->image_m->getImage($id);
		if(count($image)>0)
		{			
			$css = getCss($image, 'module');
			$this->data['css']	= $css;	
			$this->data['image'] = $image;
			$this->load->view('image', $this->data);
		}
	}
}