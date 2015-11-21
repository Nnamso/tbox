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

class Video extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		$this->video_m = $this->load->model('video/video_m');		
		$video = $this->video_m->getVideo($id);
		if(count($video) > 0)
		{
			$css = getCss($video, 'module');
			$this->data['css']	= $css;	
			$this->data['video'] = $video;	
			$this->load->view('video', $this->data);
		}
	}
}