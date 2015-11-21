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

class Menu extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		$this->menu_m = $this->load->model('menu/menu_m');		
		$menu = $this->menu_m->getmenu($id);
		
		if(count($menu) > 0)
		{
			$css = getCss($menu, 'module');
			$this->data['css']	= $css;
			$this->data['menu'] = $menu;
			
			// get menu type id
			$options 	= json_decode($menu->options);
			$menu_id	= 0;
			if (isset($options->menu_type))
			{
				$menu_id 	= $options->menu_type;
				
				// load menu items
				if ($menu_id > 0)
				{
					$this->menu_m->_table_name = 'menus';
					$this->menu_m->db->where('menu_type_id', $menu_id);
					$items 	= $this->menu_m->get();
					
					if (count($items) == 0)
					{
						return false;
					}
					
					$this->data['items']	= $items;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
			$this->data['menu_id'] = $menu_id;
			
			$this->load->view('menu', $this->data);
		}
	}
}