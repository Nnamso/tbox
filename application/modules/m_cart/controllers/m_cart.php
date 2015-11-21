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

class M_Cart extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		$this->m_cart_m = $this->load->model('m_cart/m_cart_m');		
		$m_cart = $this->m_cart_m->getMCart($id);
		if(count($m_cart) > 0)
		{
			$items 					= $this->cart->total_items();
			$this->data['items'] 	= $items;
			
			$css = getCss($m_cart, 'module');
			$this->data['css']	= $css;	
			$this->data['m_cart'] = $m_cart;	
			$this->load->view('m_cart', $this->data);
		}
	}
}