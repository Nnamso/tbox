<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * payment with paypal
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paypal
{
	function __construct($options)
	{
		$this->ini = $options;		
	}
	
	function action($data = array(), $post = array(), $id)
	{		
		$post_data = array(
			'notify_url'	 => site_url('payment/paymentipn/paypal/'.$id),
			'return'		 => site_url('payment/confirm'),
			'cancel_return'	 => site_url(),
			'tax'			 => 0,
			'no_note'		 => 1,
			'cmd'		 => '_xclick',
		);
		
		if(isset($this->ini['email']))
		{
			$post_data['business'] = $this->ini['email'];
		}
		
		if(isset($data['currency_code']))
		{
			$post_data['currency_code'] = $data['currency_code'];
		}
		
		if(isset($data['item_name']))
		{
			$post_data['item_name'] = $data['item_name'];
		}
		
		if(isset($data['item_number']))
		{
			$post_data['item_number'] = $data['item_number'];
		}
		
		if(isset($data['qty']))
		{
			$post_data['quantity'] = $data['qty'];
		}
		
		if(isset($data['amount']))
		{
			$post_data['amount'] = number_format($data['amount'], 2);
		}
		
		if(isset($data['shipping']))
		{
			$post_data['shipping'] = $data['shipping'];
		}
		
		if(isset($this->ini['sandbox']))
		{
			if($this->ini['sandbox'] == 1)
			{
				header('Location: https://www.sandbox.paypal.com/cgi-bin/webscr?' . http_build_query($post_data));
			}
			else
			{
				header('Location: https://www.paypal.com/cgi-bin/webscr?' . http_build_query($post_data));
			}
			
			$ci = & get_instance();
			$ci->load->library('session');
			
			if(isset($this->ini['message']))
				$ci->session->set_flashdata('message', $this->ini['message']);
			
			$ci->session->set_flashdata('msg', 'Thanks you for payment!');
		}
		else
		{
			redirect(site_url('payment'));
		}
	}
	
	function ipn($data = array())
	{
		if(isset($this->ini['sandbox']) && isset($this->ini['api_username']) && isset($this->ini['password']) && isset($this->ini['signature']))
		{
			$config = array( 
						'Sandbox' => $this->ini['sandbox'],
						'APIUsername' => $this->ini['api_username'],
						'APIPassword' => $this->ini['password'],
						'APISignature' => $this->ini['signature'], 
						'PrintHeaders' => false, 
						'LogResults' => false,
						'LogPath' => site_url('/payment'),
			); //config paypal get transition.
			
			if(isset($data['txn_id']) && isset($data['item_number']))
			{	
				$ci = & get_instance();
				$ci->load->library('getpaypal');
				$paypal = new getPaypal($config);
			
				$trans = $paypal->getTransaction($data['txn_id']);
				if(!isset($trans['AMT']))
					exit();
					
				$money = $paypal->getMoney($data['txn_id']);
				
				$ci->load->model('order_m');
				$order = $ci->order_m->getOrderNumber($data['item_number']);
					
				if(isset($order->total) && $money == $order->total)
				{
					$update['status'] = 'completed';
					$updatehis['order_id'] = $order->id;
					$updatehis['label'] = 'order_status';
					$updatehis['content'] = json_encode(array($order->order_number=>'completed'));
					$updatehis['date'] = date('Y-m-d H:i:s');
					if($ci->order_m->save($update, $order->id))
					{
						$ci->order_m->_table_name = 'orders_histories';
						$ci->order_m->save($updatehis);
						
						$ci->load->helper('cms');
						$user = $ci->order_m->getUser($order->id);
						//params shortcode email.
						$params = array(
							'username'=>$user->username,
							'email'=>$user->email,
							'date'=>date('Y-m-d H:i:s'),
							'total'=>number_format($money, 2),
							'order_number'=>$data['item_number'],
							'status'=>'completed',
						);
						
						//config email.
						$config = array(
							'mailtype' => 'html',
						);
						$subject = configEmail('sub_order_status', $params);
						$message = configEmail('order_status', $params);
						
						$ci->load->library('email', $config);
						$ci->email->from(getEmail(config_item('admin_email')), getSiteName(config_item('site_name')));
						$ci->email->to($user->email);    
						$ci->email->subject ( $subject);
						$ci->email->message ($message);   
						$ci->email->send();
					}
				}
			}
		}
	}
}
?>