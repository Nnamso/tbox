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

class Share extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		$this->share_m = $this->load->model('share/share_m');		
		$share = $this->share_m->getshare($id);
		if(count($share) > 0)
		{
			$css = getCss($share, 'module');
			$this->data['css']	= $css;	
			$this->data['share'] = $share;	
			$this->load->view('share', $this->data);
		}
	}
}