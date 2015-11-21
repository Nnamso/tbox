<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * payment
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends Frontend_Controller
{
	public function __construct(){
		parent::__construct();	
	}
	
	// check form
	function index()
	{
		$this->user 	= $this->session->userdata('user');
		$this->items 	= $this->cart->contents();
		
		if (count($this->items) == 0 || count($this->user) == 0)
			redirect('cart');
			
		if($this->input->post('payment'))
		{
			$data = $this->input->post();			
			
			// add payment to session
			if ($this->session->userdata('cart'))
			{
				$cart = $this->session->userdata('cart');
			}
			else
			{
				$cart = new stdClass();
			}
			$cart->payment = $data['payment'];				
			
			// update user profile
			$fields = $data['fields'];
			if (count($fields) == 0)
				redirect('cart/checkout');
							
			$user_profile	= array();
			foreach($fields as $key => $value)
			{
				$id 	= key($value);
				$user_profile[] = array(
					'field_id'=>$id,
					'form_field'=>'checkout',
					'value'=>$value[$id],
					'object'=>$this->user['id'],
				);				
			}
			$this->load->model('fields_m');
			if ( count($user_profile) > 0 )
			{
				$this->fields_m->add($user_profile);
			}			
			
			// get design option
			$this->load->driver('cache', array('adapter'=>'file')); 
			$session_id 	= $this->session->userdata('order_session_id');
			$designs 		= $this->cache->get('orders_designs'.$session_id);
			
			
			$items	= array();
			$i 			= 0;
			$total 		= 0;
			$subtotal 	= 0;				
			foreach($this->items as $key => $item)
			{
				$subtotal  = $subtotal + $item['subtotal'] + $item['customPrice'];
				$items['design'][$i] = $designs[$key];
				$items['cart'][$i]	= $item;
				$items['cart'][$i]['teams']	= json_encode($items['cart'][$i]['teams']);
				$items['cart'][$i]['options']	= json_encode($items['cart'][$i]['options']);
				$i++;
									
			}
			$items['user'] 				= $this->user;
			$items['metod'] 			= $cart;				
			$items['metod']->subtotal 	= $subtotal;
			
		
			// save design
			$this->load->model('order_m');
			$design_ids = array();
			if (count($items['design']))
			{
				$this->load->model('design_m');
				foreach($items['design'] as $i=>$design)
				{
					$design_id 				= $this->order_m->creteOrderNumber(15);
					$design_ids[$i]			= $design_id;
					$insert = array(
						'title'				=> '', 
						'description'		=> '', 
						'design_id'			=> $design_id,						
						'modified'			=> '',
						'fonts'				=> $design['fonts'],
						'system_id'			=> 0,
						'user_id'			=> $this->user['id'], 
						'product_id'		=> $items['cart'][$i]['product_id'], 
						'product_options'	=> $design['color'], 
						'vectors'			=> $design['vector'], 
						'teams'				=> json_encode($items['cart'][$i]['teams']), 
						'image' 			=> $design['images']['front'],						
						'created' 			=> date("Y-m-d H:i:s")
					);
					
					$this->design_m->save($insert, null);					
				}
			}
			
			
			// save order
			$order 					= $this->order_m->addNew('order');
			$order['order_number']	= $this->order_m->creteOrderNumber();
			$order['order_pass']	= $this->order_m->creteOrderNumber();
			$order['user_id']		= $this->user['id'];			
			$order['payment_id']	= $items['metod']->payment;
			$order['shipping_id']	= $items['metod']->shipping->id;
			
			if ( isset($items['metod']->discount) && isset($items['metod']->discount->id) )
			{
				// get discount
				$order['discount_id']	= $items['metod']->discount->id;
				if ( $items['metod']->discount->discount_type == 't' )
				{
					$order['discount']	=  $items['metod']->discount->value;
				}
				else
				{
					$order['discount']	=  ($order['sub_total'] * $items['metod']->discount->value)/100;
				}
				
				// update coupon
				$this->load->model('coupon_m');
				if ( $items['metod']->discount->type == 'g' )
				{
					$coupon 	= array(
						'count'	=> 1
					);
				}
				else
				{
					$row 		= $this->coupon_m->get($items['metod']->discount->id, true);
					$coupon 	= array(
						'count'	=> $row->count + 1
					);
				}
				$this->coupon_m->save($coupon, $items['metod']->discount->id);
			}
			$order['shipping_id']	= $items['metod']->shipping->id;
			$order['shipping_price']= $items['metod']->shipping->price;
			$order['sub_total']		= $items['metod']->subtotal;
			$order['total']			= $order['sub_total'] + $order['shipping_price'] - $order['discount'];			
			$order['status']		= 'pending';
			$order_id 				= $this->order_m->save($order, null);
			
			
			// save order items
			$order_item				= $this->order_m->addNew('item');
			$order_item['order_id'] = $order_id;
			
			// get setting
			$this->load->model('settings_m');
			$row 	= $this->settings_m->getSetting();
			$setting = json_decode($row->settings);
			
			// get shipping method
			$this->load->model('shipping_m');
			$shipping	= $this->shipping_m->get($items['metod']->shipping->id, true);
			
			// get payment method
			$this->load->model('payment_m');
			$payment	= $this->payment_m->get($items['metod']->payment, true);
			
			// get discount
			if (isset($items['metod']->discount->id))
			{
				$this->load->model('coupon_m');
				$discount	= $this->coupon_m->get($items['metod']->discount->id, true);
			}
			else
			{
				$discount	= array();
			}
			$this->data['discount'] = $discount;
			// html email.
			$total = 0;
			$count = 1;
			$shipping_price = $items['metod']->shipping->price;
			$payment_price = 0.0;
			
			$this->load->language('order');
			$html = '<table style="border-collapse:collapse;">';
			$html .= '<tr>';
			$html .= '<td style="border: 1px solid #ccc; padding: 5px;">'.lang("name").'</td>';
			$html .= '<td style="border: 1px solid #ccc; padding: 5px;">'.lang("sku").'</td>';
			$html .= '<td style="border: 1px solid #ccc; padding: 5px;">'.lang("orders_admin_product_price_title").'</td>';
			$html .= '<td style="border: 1px solid #ccc; padding: 5px;">'.lang("orders_admin_print_price_title").'</td>';
			$html .= '<td style="border: 1px solid #ccc; padding: 5px;">'.lang("orders_admin_product_clipart_title").'</td>';
			$html .= '<td style="border: 1px solid #ccc; padding: 5px;">'.lang("orders_admin_product_attributes_title").'</td>';
			$html .= '<td style="border: 1px solid #ccc; padding: 5px;">'.lang("orders_admin_product_qty_title").'</td>';
			$html .= '<td style="border: 1px solid #ccc; padding: 5px;">'.lang("orders_admin_product_option_title").'</td>';
			$html .= '<td style="border: 1px solid #ccc; padding: 5px;">'.lang("total").'</td>';
			$html .= '</tr>';
			
			foreach($items['cart'] as $i=>$item)
			{
				$price_clipart					= 0;
				$cliparts						= json_decode($item['cliparts']);
				if (count($cliparts))
				{	
					// save order cliparts
					$arts 	= array();
					$ij = 0;
					foreach($cliparts as $view=>$art)
					{
						if (count($art))
						{
							foreach($art as $art_id=>$price)
							{
								if ($art_id > 0)
								{
									$price_clipart 	= $price_clipart + $price;
									$arts[$ij]		= array(										
										'clipart_id'=> $art_id,
										'order_id'	=> $order_id,
										'status'	=> 'pending',
										'created'	=> date("Y-m-d H:i:s")
									);
									$ij++;
								}
							}
						}
					}
					if (count($arts))
						$this->db->insert_batch('order_cliparts', $arts);
				}				
				
				$prices							= json_decode($item['prices']);
				$order_item['design_id'] 		= $design_ids[$i];
				$order_item['product_id'] 		= $item['product_id'];				
				$order_item['product_name'] 	= $item['name'];				
				$order_item['product_sku'] 		= $item['id'];				
				$order_item['product_price'] 	= $prices->sale;				
				$order_item['price_print'] 		= $prices->prints;				
				$order_item['price_clipart'] 	= $price_clipart;				
				$order_item['price_attributes'] = $item['customPrice'];				
				$order_item['quantity'] 		= $item['qty'];				
				$order_item['poduct_status'] 	= 'pending';				
				$order_item['attributes'] 		= json_encode($item['options']);				
				
				$this->order_m->save($order_item, null);
				
				// html email.
				$html .= '<tr>';
				$html .= '<td style="border: 1px solid #ccc; padding: 5px;">'.$item['name'].'</td>';
				$html .= '<td style="border: 1px solid #ccc; padding: 5px;">'.$item['id'].'</td>';
				$html .= '<td style="border: 1px solid #ccc; padding: 5px;">'.$setting->currency_symbol.number_format($prices->sale, 2).'</td>';
				$html .= '<td style="border: 1px solid #ccc; padding: 5px;">'.$setting->currency_symbol.number_format($prices->prints, 2).'</td>';
				$html .= '<td style="border: 1px solid #ccc; padding: 5px;">'.$setting->currency_symbol.number_format($price_clipart, 2).'</td>';
				$html .= '<td style="border: 1px solid #ccc; padding: 5px;">'.$setting->currency_symbol.number_format($item['customPrice'], 2).'</td>';
				$html .= '<td style="border: 1px solid #ccc; padding: 5px;">'.$item['qty'].'</td>';
				$html .= '<td style="border: 1px solid #ccc; padding: 5px;">';
					if($item['options'] != '')
					{
						$size = json_decode($item['options'], true);										
						if (count($size) > 0)
						{
							foreach($size as $option) {
								$html .= '<div>
									<strong>'.$option['name'].': </strong>'; 
										if (is_string($option['value'])) 
										{
											$html .= $option['value'];
										}elseif (is_array($option['value']) && count($option['value']))
										{
											foreach($option['value'] as $v=>$value)
											{
												if ($option['type'] == 'textlist')
													$html .= $v .' - '.$value.'; ';
												else
													$html .= $value.'; ';
											}
										}
								$html .= '</div>';
							}
						}
					}
				$html .= '</td>';
				$total_row = $item['qty']*($prices->sale+$prices->prints+$price_clipart)+$item['customPrice'];
				$html .= '<td style="border: 1px solid #ccc; text-align: right;">'.$setting->currency_symbol.number_format($total_row, 2).'</td>
				</tr>';
			}
			
			// html email.
			$html .= '<tr>
				<td  style="border: 1px solid #ccc; text-align: right; padding: 5px;" colspan="8">
					'.lang("orders_admin_shipment_fee_title");
					if (count($shipping)) {							
						$html .= '<br><small>'.lang("orders_admin_shipping_method").': <a href="'.site_url().'"><strong>'.$shipping->title.'</strong></a></small>
						<br><small>'.$shipping->description.'</small>';
					}
					
				$html .= '</td>
				<td style="border: 1px solid #ccc; text-align: right; padding: 5px;">'.$setting->currency_symbol.number_format($shipping_price, 2).'</td>
			</tr>
			<tr>
				<td  style="border: 1px solid #ccc; text-align: right; padding: 5px;" colspan="8">
					'.lang("orders_admin_payment_fee_title");
					if (count($payment)) {							
						$html .= '<br><small>'.lang("orders_admin_payment_method").': <a href="'.site_url().'"><strong>'.$payment->title.'</strong></a></small>
						<br><small>'.$payment->description.'</small>';
					}
				$html .= '</td>
				<td style="border: 1px solid #ccc; text-align: right; padding: 5px;">'.$setting->currency_symbol.number_format($payment_price, 2).'</td>
			</tr>
			<tr>
				<td colspan="8" style="border: 1px solid #ccc; text-align: right; padding: 5px;">
					'.lang("orders_admin_discount");
					if (count($discount)) {							
						$html .= '<br><small>'.$discount->name.': <a href="'.site_url().'"><strong>'.$discount->code.'</strong></a></small>';							
					}
				$html .= '</td>
				<td style="border: 1px solid #ccc; text-align: right; padding: 5px;">'.$setting->currency_symbol.number_format($order['discount'], 2).'</td>
			</tr>
			<tr>';
			$total = $order['total'];
			$html .= '<td colspan="8" style="border: 1px solid #ccc; text-align: right;">'.lang("orders_admin_total_title").'</td>
				<td style="border: 1px solid #ccc; text-align: right; padding: 5px;" colspan="7"><strong>'.$setting->currency_symbol.number_format($total, 2).'<strong></td>
			</tr></table>';
			
			// send email.
			$params = array(
				'username'=>$this->user['username'],
				'date'=>date('Y-m-d H:i:s'),
				'total'=>$setting->currency_symbol.number_format($total, 2),
				'order_number'=>$order['order_number'],
				'table'=>$html,
			);
			
			//config email.
			$config = array(
				'mailtype' => 'html',
			);
			$subject = configEmail('sub_order_detai', $params);
			$message = configEmail('order_detai', $params);
			
			$this->load->library('email', $config);
			$this->email->from(getEmail(config_item('admin_email')), getSiteName(config_item('site_name')));
			$this->email->to($this->user['email']);    
			$this->email->subject ( $subject);
			$this->email->message ($message);   
			$this->email->send();
			
			$this->email->clear();
			$this->email->from($this->user['email'], $this->user['username']);
			$this->email->to(getEmail(config_item('admin_email')));    
			$this->email->subject ($subject);
			$this->email->message ($message);   
			$this->email->send();
			
			
			// save user address shipping
			$order_info				= $this->order_m->addNew('info');
			$order_info['order_id'] = $order_id;
			$order_info['user_id'] 	= $this->user['id'];
			$profiles				= array();
			foreach($fields as $key => $value)
			{
				$id 	= key($value);
				$field	= $this->fields_m->getField($id);
				
				if ($field != '')
				{
					if ($field->type == 'country')
					{
						$profiles[$field->title]	= $this->fields_m->getCountry($value[$id]);
					}
					elseif ($field->type == 'state')
					{
						$profiles[$field->title]	= $this->fields_m->getState($value[$id]);
					}
					else
					{
						$profiles[$field->title]	= $value[$id];
					}
				}
			}
			$order_info['address'] 	= json_encode($profiles);
			$this->order_m->save($order_info, null);
			
			// Payment
			$this->load->model('payment_m');
			$row	= $this->payment_m->get($cart->payment, true);
			if (count($row) == 0)
			{
				redirect('cart/checkout');
			}
			$payment_method	= $row->type;
			$file = ROOTPATH .DS. 'application' .DS. 'payments' .DS. $payment_method .DS. $payment_method.'.php';
						
			// get currency
			$this->load->model('settings_m');
			$currency	= $this->settings_m->getCurrency();
			$product = array(
				'item_name'=> $order['order_number'],
				'item_number'=> $order['order_number'],
				'amount'=> ($subtotal - $order['discount']),
				'shipping'=> $items['metod']->shipping->price,
				'qty'=> 1,
				'currency_code'=> $currency->currency_code
			);
			
			//remove all session, cache			
			$this->session->unset_userdata('cart');
			$this->session->unset_userdata('order_session_id');
			$this->cart->destroy();
			$this->cache->delete('orders_designs'.$session_id);			
			
			if(file_exists($file))
			{
				include_once($file);
				$options	= json_decode($row->configs, true);				
				$pay = new $payment_method( $options );
				$pay->action($product, $data, $row->id);
			}
			else
			{
				redirect('cart/checkout');
			}
		}
		else
		{
			redirect('index.php');
		}	
	}
	
	function paymentIpn($payment = '', $id = '')
	{
		if($this->input->post()) //payment listener post.
		{			
			$file = ROOTPATH.DS.'application'.DS.'payments'.DS.$payment.DS.$payment.'.php';
			
			if(file_exists($file))
			{
				include_once($file);
				$this->load->model('payment_m');
				$row = $this->payment_m->getData($id);
				if(count($row) > 0)
				{
					$options = json_decode($row->configs, true);	
					$pay = new $payment($options);
					$pay->ipn($this->input->post());
				}
			}else
			{
				redirect(site_url());
			}
		}else
		{
			redirect(site_url());
		}
	}
	
	function confirm()
	{
		$user = $this->session->userdata('user'); 
		if((isset($user['id']) && $user['id'] != '') )
		{
			$content				= $this->load->view('components/payment/confirm', $this->data, true);
			
			$this->data['content']	= $content;		
			$this->data['subview'] 	= $this->load->view('layouts/payment/confirm', array(), true);
		}else
		{
			redirect(site_url());
		}
		$this->theme($this->data, 'payment');
	}
}
?>