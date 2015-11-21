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

class Row extends Frontend_Controller
{ 

	public function __construct(){
		parent::__construct();
		
		$this->modules_m = $this->load->Pmodel('modules_m');
	} 
	
	public function index($id = ''){
			
		$module = $this->modules_m->get($id);
		
		$css = getCss($module, 'row');
		echo $css;		
	}
}