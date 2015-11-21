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

class Ajax extends Admin_Controller
{

	public function __construct ()
	{
		parent::__construct();
		
	}
	
	function categoriesTree(){
		$this->load->model('categories_m');
		$type 		= $this->input->get('type', 'clipart');
		$categories = $this->categories_m->getTreeCategories($type, true);
		
		$all 				= array();
		$all[0]				= new stdClass();
		$all[0]->id 		= 0;
		$all[0]->title 		= 'All Art';
		$all[0]->children 	= array();
		$all[0]->parent_id 	= 0;
			
			
		$categories = array_merge($all, $categories);		
		
		echo json_encode($categories);
	}
}
?>