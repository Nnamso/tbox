<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * view cart, checkout
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends Frontend_Controller {
	
	public function __construct()
	{
        parent::__construct();	
		//$this->lang->load('cart');
		$this->load->driver('cache', array('adapter'=>'file')); 		
		
		if ($this->session->userdata('order_session_id'))
		{
			$this->session_id = $this->session->userdata('order_session_id');
		}
		else
		{
			$this->session_id = $this->session->userdata('session_id');
			$this->session->set_userdata('order_session_id', $this->session_id);
		}
				
    }
	
	function index()
	{
		$this->data['designs'] 	= $this->cache->get('orders_designs'.$this->session_id);
		$this->data['items'] 	= $this->cart->contents();
		$this->data['user'] 	= $this->session->userdata('user');
		
		$content				= $this->load->view('components/cart/index', $this->data, true);
		
		$data = array();		
		$data['content']	= $content;		
		$data['subview'] 	= $this->load->view('layouts/cart/cart', array(), true);
		
		$this->theme($data, 'cart');
	}
	
	public function checkout()
	{
		$user = $this->session->userdata('user');
		
		if (empty($user['loggedin']) || $user['loggedin'] == 0)
		{
			redirect('user/login');
		}

		$this->data['designs'] 	= $this->cache->get('orders_designs'.$this->session_id);
		$this->data['items'] 	= $this->cart->contents();		
		$this->data['user'] 	= $user;
		
		if ( count($this->data['items']) == 0)
			redirect('cart');

		// user info		
		$this->load->model('fields_m');
		$profiles	= $this->fields_m->getFiels('checkout', $user['id']);
		$this->data['profiles']	= $profiles;
			
		// get from
		$this->load->model('users_m');
		$this->data['forms'] = $this->users_m->getFormField('checkout');
		$this->load->helper('fields');
		$fields	= new Field();
		$this->data['fields']	= $fields;
		
		// load shipping method
		$this->load->model('shipping_m');
		$this->shipping_m->db->where('published', 1);
		$shipping 					= $this->shipping_m->get();
		$this->data['shipping'] 	= $shipping;
		
		if ($this->session->userdata('shipping') === false)
		{
		}
		
		// load payment method
		$this->load->model('payment_m');
		$this->payment_m->db->where('published', 1);
		$payments 					= $this->payment_m->get();
		$this->data['payments'] 	= $payments;
		
		$content				= $this->load->view('components/cart/checkout', $this->data, true);
		
		$data = array();		
		$data['content']	= $content;		
		$data['subview'] 	= $this->load->view('layouts/cart/checkout', array(), true);
		
		$this->theme($data, 'cart');
	}	
	
	// add to cart in designer
	public function addJs(){		
		$data = $this->input->post();
		
		// get data post
		$product_id		= $data['product_id'];
		$colors			= $data['colors'];
		$print			= $data['print'];		
		$quantity		= $data['quantity'];		
		
		// get attribute
		if ( isset( $data['attribute'] ) )
		{
			$attribute		= $data['attribute'];
		}
		else
		{
			$attribute		= false;
		}
				
		if ($quantity < 1 ) $quantity = 1;
		
		$time = strtotime("now");
		
		if (isset($data['attribute'])) $attribute = $data['attribute'];
		else $attribute = false;
		
		if (isset($data['cliparts'])) $cliparts = $data['cliparts'];
		else $cliparts = false;			
		
		$content = array();
		$content['error'] = 1;
		$this->load->model('product_m');
			
		// check product and user shop
		$options = array(
			'id' => $data['product_id']				
		);
		$product 		= $this->product_m->getProduct($options);
		if ($product == false)
		{
			$content['msg'] = 'Product could not be found';
		}
		else
		{
			$product 		= $product[0];
			$content['error'] = 0;
			$this->load->helper('cart');
			$cart 		= new dgCart();
			
			$post 		= array(
				'colors' 		=> $colors,
				'print' 		=> $print,
				'attribute' 	=> $attribute,
				'quantity' 		=> $quantity,
				'product_id' 	=> $product_id					
			);
			
			// load setting
			$this->load->model('settings_m');
			$row 			= $this->settings_m->getSetting();			
			$setting		= json_decode($row->settings);
			$result 		= $cart->totalPrice($this->product_m, $product, $post, $setting);
			$result->product	= new stdClass();
			$result->product->name 	= $product->title;
			$result->product->sku 	= $product->sku;
			
			// get cliparts
			$clipartsPrice = array();			
			if ( isset($data['cliparts']) )
			{
				$this->load->model('art_m');
				
				$cliparts = $data['cliparts'];
				foreach($cliparts as $view => $arts)
				{
					if (count($arts))
					{
						$art = array();
						foreach($arts as $art_id)
						{
							// check admin shop and desginer
							$clipart 		= $this->art_m->getArt($art_id, 'system, add_price');
							
							if ( empty($clipart) ) continue;
							if ($clipart->add_price == 0) continue;
							
							$prices 		= $clipart->add_price;
							$art[$art_id] 	= $prices;							
						}
						$clipartsPrice[$view] = $art;
					}
				}
			}
			
			$result->cliparts = $clipartsPrice;							
				
			$total	= new stdClass();
			$total->old = $result->price->base + $result->price->colors + $result->price->prints;
			$total->sale = $result->price->sale + $result->price->colors + $result->price->prints;
			
			if (count($result->cliparts))
			{
				foreach($result->cliparts as $view=>$art)
				{
					foreach($art as $id=>$amount)
					{
						$total->old 	= $total->old + $amount;
						$total->sale 	= $total->sale + $amount;
					}
				}
			}
			
			$result->total 	= $total;
			
			// get symbol
			if (!isset($setting->currency_symbol))
				$setting->currency_symbol = '$';
			$result->symbol = $setting->currency_symbol;
			
			// save file image design
			$design = array();
			if (isset($data['design']['images']['front']))
				$design['images']['front'] 	= createFile($data['design']['images']['front'], 'front', $time);
					
			if (isset($data['design']['images']['back']))	
				$design['images']['back'] 	= createFile($data['design']['images']['back'], 'back', $time);
				
			if (isset($data['design']['images']['left']))
				$design['images']['left'] 	= createFile($data['design']['images']['left'], 'left', $time);
				
			if (isset($data['design']['images']['right']))
				$design['images']['right']	= createFile($data['design']['images']['right'], 'right', $time);
			
				
			// add session design
			$rowid			= md5($result->product->sku . $time);
			$designs 		= $this->cache->get('orders_designs'.$this->session_id);
			
			$designs[$rowid]	= array(
				'color' => $data['colors'][key($data['colors'])],
				'images' => $design['images'],
				'vector' => $data['design']['vectors'],
				'fonts' => $data['fonts']
			);
			$this->cache->save('orders_designs'.$this->session_id, $designs, 36000);
				
			if (empty($result->options)) $result->options = array();
			
			if (isset($data['teams'])) $teams = $data['teams'];
			else $teams = '';
			
			// add cart
			$item 	= array(
				'id'      		=> $result->product->sku,
				'product_id'    => $data['product_id'],
				'qty'     		=> $data['quantity'],
				'teams'     	=> $teams,
				'price'   		=> $result->total->sale,
				'prices'   		=> json_encode($result->price),
				'cliparts'   	=> json_encode($result->cliparts),
				'symbol'   		=> $result->symbol,
				'customPrice'   => $result->price->attribute,
				'name'    		=> $result->product->name,
				'time'    		=> $time,
				'options' 		=> json_decode(json_encode($result->options), true)
			);
			$this->cart->product_name_rules = '[:print:]';
			$this->cart->insert($item);
			
			$content['product'] = array(
				'name'=> $result->product->name,
				'quantity'=> $data['quantity'],
				'image'=> base_url().$design['images']['front']
			);
		}
		
		echo json_encode($content);
	}
	
	public function prices()
	{
		$data 	= $this->input->post();
		
		// get data post
		$product_id		= $data['product_id'];
		$colors			= $data['colors'];
		$print			= $data['print'];		
		$quantity		= $data['quantity'];		
		
		// get attribute
		if ( isset( $data['attribute'] ) )
		{
			$attribute		= $data['attribute'];
		}
		else
		{
			$attribute		= false;
		}
				
		if ($quantity < 1 ) $quantity = 1;
		
		// load product
		$this->load->model('product_m');					
		$options = array(
			'id' => $product_id				
		);
		$product 		= $this->product_m->getProduct($options);
		
		if ($product == false)
		{
			echo json_encode( array('error' => 'Product could not be found') );
			exit;
		}
		else
		{
			// load cart
			$this->load->helper('cart');
			$cart 		= new dgCart();	
			$post 		= array(
				'colors' 		=> $colors,
				'print' 		=> $print,
				'attribute' 	=> $attribute,
				'quantity' 		=> $quantity,
				'product_id' 	=> $product_id					
			);
			
			// load setting
			$this->load->model('settings_m');
			$row 		= $this->settings_m->getSetting();			
			$setting	= json_decode($row->settings);
			$result 		= $cart->totalPrice($this->product_m, $product[0], $post, $setting);
			
			// get cliparts
			$clipartsPrice = array();
			/*
			if ( isset($data['cliparts']) )
			{
				$this->load->model('art_m');
				
				$cliparts = $data['cliparts'];
				foreach($cliparts as $view => $arts)
				{
					if (count($arts))
					{
						$art = array();
						foreach($arts as $art_id)
						{
							// check admin shop and desginer
							$clipart 		= $this->art_m->getArt($art_id, 'system, add_price');
							
							if ( empty($clipart[0]) ) continue;
							if ($clipart[0]->add_price == 0) continue;
							
							$prices 		= $clipart[0]->add_price;
							$art[$art_id] 	= $prices;							
						}
						$clipartsPrice[$view] = $art;
					}
				}
			}
			*/
			
			$result->cliparts = $clipartsPrice;
			$result->quantity = $quantity;				
				
			$total	= new stdClass();
			$total->old = $result->price->base + $result->price->colors + $result->price->prints;
			$total->sale = $result->price->sale + $result->price->colors + $result->price->prints;
				
			if (count($result->cliparts))
			{
				foreach($result->cliparts as $view=>$art)
				{
					foreach($art as $id=>$amount)
					{
						$total->old 	= $total->old + $amount;
						$total->sale 	= $total->sale + $amount;
					}
				}
			}
			
			$total->old 	= ($total->old * $quantity) + $result->price->attribute;
			$total->sale 	= ($total->sale * $quantity) + $result->price->attribute;
			
			$total->old 	= number_format($total->old, 2, '.', ',');
			$total->sale 	= number_format($total->sale, 2, '.', ',');
			
			echo json_encode($total);
			exit;
		}	
	}
	
	public function shipping($id = '')
	{
		$id	= (int) $id;
		
		$this->load->model('shipping_m');		
		$shipping 					= $this->shipping_m->get($id, true);		
		
		if ($this->session->userdata('cart') === false)
		{
			$cart 					= new stdClass();
			$cart->shipping			= new stdClass();
			
		}
		else
		{
			$cart	= $this->session->userdata('cart');
			if (empty($cart->shipping))
				$cart->shipping		= new stdClass();
		}
		$cart->shipping->id 	= $id;
		$cart->shipping->price 	= $shipping->price;
		$this->session->set_userdata('cart', $cart);
				
		$this->data['designs'] 	= $this->cache->get('orders_designs'.$this->session_id);
		$this->data['items'] 	= $this->cart->contents();
		
		$this->load->view('components/cart/items', $this->data);
	}
	
	// get coupon
	public function coupon($code = '')
	{		
		$this->load->model('coupon_m');
		$this->coupon_m->db->where('code', $code);
		$this->coupon_m->db->where('publish', 1);		
		$this->coupon_m->db->where('end_date > Now()');
		
		$coupon 				= $this->coupon_m->get();
		if ($this->session->userdata('cart') === false)
		{
			$cart 					= new stdClass();
			$cart->discount			= new stdClass();
		}
		else
		{
			$cart	= $this->session->userdata('cart');
			if (empty($cart->discount))
				$cart->discount		= new stdClass();
		}			
		
		$discount		= true;
		if ( count($coupon) == 0)
		{
			$discount	= false;
		}
		else
		{
			if ($coupon[0]->coupon_type == 'g' && $coupon[0]->count != 0)
			{
				$discount	= false;
			}
			
			// check min total discount
			$total 	= $this->cart->total();
			if ($coupon[0]->minimum > $total)
			{
				$discount	= false;
			}
		}
		
		if ($discount === true)
		{
			$cart->discount->id 			= $coupon[0]->id;
			$cart->discount->type 			= $coupon[0]->coupon_type;
			$cart->discount->discount_type 	= $coupon[0]->discount_type;
			$cart->discount->value 			= $coupon[0]->value;
			$cart->discount->code 			= $coupon[0]->code;
		}
		else
		{
			$cart->discount		= new stdClass();
		}
		$this->session->set_userdata('cart', $cart);
				
		$this->data['designs'] 	= $this->cache->get('orders_designs'.$this->session_id);
		$this->data['items'] 	= $this->cart->contents();
		
		$this->load->view('components/cart/items', $this->data);
	}
	
	function show()
	{	
		echo '<pre>';		
		print_r($this->cache->get('orders_designs'.$this->session_id));
		print_r($this->cart->contents());
		//print_r($this->session->all_userdata());
		echo '</pre>';
	}
	function test(){
		$data = array(
               'id'      => 'sku_123ABC',
               'qty'     => 1,
               'price'   => 39.95,
               'name'    => 'T-Shirt',
			   'time'	=> strtotime("now"),
               'options' => array('Size' => 'L', 'Color' => 'Red')
            );

		$this->cart->insert($data);
	}
	
	function remove($rowid = '')
	{
		if ($rowid != '')
		{
			$data = array(
				'rowid' => $rowid,
				'qty' => '0'
			);
			$this->cart->update($data);
			
			$designs 		= $this->cache->get('orders_designs'.$this->session_id);
			unset($designs[$rowid]);
			$this->cache->save('orders_designs'.$this->session_id, $designs, 86400);
		}
	}
	
	function destroy()
	{
		$this->cart->destroy();
		if ($this->cache->get('orders_designs'.$this->session_id))
			$this->cache->delete('orders_designs'.$this->session_id);
	}
}

?>