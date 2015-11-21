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

class M_Slider extends MY_Controller{ 

	public function __construct(){ 
		parent::__construct(); 
		$this->load->helper('url');
	} 
	
	public function index($id = null){		
		$this->m_slider_m = $this->load->model('m_slider/m_slider_m');		
		$slider = $this->m_slider_m->getSlider($id);
		if(count($slider) > 0)
		{			
			$css = getCss($slider, 'module');
			$this->data['css']	= $css;
			$this->data['slider'] = $slider;
			$this->load->view('m_slider', $this->data);
		}
	}
}