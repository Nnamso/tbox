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

class Authorize
{
	function __construct($options)
	{
		$this->ini = $options;		
	}
	
	function action($data = array(), $post = array(), $id)
	{		
		$ci = & get_instance();
		$ci->load->library('session');
		
		if(isset($this->ini['sandbox']) && isset($this->ini['api_login_id']) && isset($this->ini['transaction_key']) && isset($post['card_num']) && isset($post['exp_date']))
		{
			require dirname(__FILE__) . '/lib/shared/AuthorizeNetRequest.php';
			require dirname(__FILE__) . '/lib/shared/AuthorizeNetTypes.php';
			require dirname(__FILE__) . '/lib/shared/AuthorizeNetXMLResponse.php';
			require dirname(__FILE__) . '/lib/shared/AuthorizeNetResponse.php';
			require dirname(__FILE__) . '/lib/AuthorizeNetAIM.php';
			define("AUTHORIZENET_API_LOGIN_ID", $this->ini['api_login_id']);
			define("AUTHORIZENET_TRANSACTION_KEY", $this->ini['transaction_key']);
			define("AUTHORIZENET_SANDBOX", $this->ini['sandbox']);
			
			$sale = new AuthorizeNetAIM;
			$sale->amount = number_format($data['amount'], 2);
			$sale->card_num = $post['card_num'];
			$sale->exp_date = $post['exp_date'];
			$response = $sale->authorizeAndCapture();
			if ($response->approved) 
			{
				$ci = & get_instance();
				$ci->load->model('order_m');
				$order = $ci->order_m->getOrderNumber($data['item_number']);
				if(count($order) > 0)
				{
					$update['status'] = 'completed';
					$updatehis['order_id'] = $order->id;
					$updatehis['label'] = 'order_status';
					$updatehis['content'] = json_encode(array($order->order_number=>'completed'));
					$updatehis['date'] = date('Y-m-d H:i:s');
					$ci->order_m->_table_name = 'orders';
					if($ci->order_m->save($update, $order->id))
					{
						$ci->order_m->_table_name = 'orders_histories';
						$ci->order_m->save($updatehis);
						
						$ci->load->helper('cms');
						$user = $ci->session->userdata('user');
						//params shortcode email.
						$params = array(
							'username'=>$user['username'],
							'email'=>$user['email'],
							'date'=>date('Y-m-d H:i:s'),
							'shop'=>getSiteName(config_item('site_name')),
							'shop_url'=>site_url(),
							'total'=>number_format($data['amount'], 2),
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
						$ci->email->to($user['email']);    
						$ci->email->subject ( $subject);
						$ci->email->message ($message);   
						$ci->email->send();
					}
				}
				
				$ci->session->set_flashdata('msg', 'Thanks you for payment!');
				if(isset($this->ini['message']))
					$ci->session->set_flashdata('message', $this->ini['message']);
			}else
			{
				$ci->session->set_flashdata('error', 'Your payment not success!');
			}
		}
		redirect(site_url('payment/confirm'));
	}
	
	function ipn($data = array())
	{
		return true;
	}
}
?>