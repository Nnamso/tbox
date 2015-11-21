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

class Orders extends Admin_Controller
{
	public function __construct ()
	{
		parent::__construct();
		
		// check user permission		
		$this->users_m->userPermission('orders');
		
		$this->load->language('order');		
		$this->load->language('designer');	
		$this->user = $this->session->userdata('user');
		$this->load->model('order_m');
	}
	
	function index()
	{
		
		$this->data['breadcrumb'] = lang('orders_admin_orders_title');
        $this->data['meta_title'] = lang('orders_admin_orders_title');
        $this->data['sub_title'] = '';
		
		// load settting
		$this->load->model('settings_m');
		$row 	= $this->settings_m->getSetting();
		$setting = json_decode($row->settings);
		
		$this->data['setting'] 	= $setting;	

		if ($this->input->post('option'))
		{		
			$this->session->set_userdata('search_order', $this->input->post('search'));
			$this->session->set_userdata('option_order', $this->input->post('option_order'));
		}
		
		// pagination
		$this->load->library('pagination');
		$config['base_url'] 		= site_url('admin/orders/index');
		$config['total_rows']		= $this->order_m->getOrders(true, 5, 1, $this->session->userdata('search_order'), $this->session->userdata('option_order'));
		
		if ($this->input->post('option'))
		{
			if ($this->input->post('option') == '')
				$this->session->set_userdata('per_page', $config['total_rows']);
			else
				$this->session->set_userdata('per_page', $this->input->post('per_page'));
		}
		
		if($this->session->userdata('per_page') != '')
			$config['per_page'] = $this->session->userdata('per_page');
		else
			$config['per_page'] 	= 20;
		
		$config['uri_segment'] 		= 4;
		$config['prev_link'] 		= '&larr;';
		$config['next_link'] 		= '&rarr;';
		$config['first_link']		= '&laquo;';
		$config['last_link'] 		= '&raquo;';
		
		$this->pagination->initialize($config); 
		$this->data['per_page'] = $config['per_page'];
		$this->data['links'] 	= $this->pagination->create_links();
		$this->data['per_page'] 	= $config['per_page'];
		$this->data['search'] = $this->session->userdata('search_order');
		$this->data['option'] = $this->session->userdata('option_order');
		
		$orders = $this->order_m->getOrders(false, $config['per_page'], $this->uri->segment(5), $this->session->userdata('search_order'), $this->session->userdata('option_order'));
		$this->data['orders'] = $orders; 
				
		// Load view
		$this->data['subview'] = 'admin/order/index';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function download($id, $position, $product_id, $file = 'svg')
	{
		if ($id > 0)
		{
			$this->load->model('product_m');
			$design 	= $this->product_m->getProductDesign($product_id);
			if (count($design))
			{
				$area		= json_decode($design->area);
				if (isset($area->$position) && $area->$position != '')
				{
					$view 		= json_decode(str_replace("'", '"', $area->$position));	
					$radius 	= str_replace('px', '', $view->radius);					
					$svg = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="'.$view->height.'" width="'.$view->width.'">';
					
					$data 			= $this->order_m->getDesignDetail($id);
					$vectors 		= json_decode($data->vectors);			
					$items			= $vectors->$position;
					
					$items			= json_decode ( json_encode($items), true);
					function cmp($a, $b)
					{
						return strcmp($a['zIndex'], $b['zIndex']);						
					}
					usort($items, 'cmp');
					
					$items			= json_decode ( json_encode($items) );
					
					foreach($items as $item)
					{
						
						$top 		= str_replace('px', '', $item->top);
						$left 		= str_replace('px', '', $item->left);
						
						if ( isset($item->file) && isset($item->file->type) && $item->file->type == 'image' )
						{
							preg_match_all("/xlink:href=\"(.*)\">/i", $item->svg, $links);
							if (isset($links[1][0]))
							{
								$link 	= str_replace('_thumb', '', $links[1][0]);
								$data 	= file_get_contents($link);								
								$base64 = 'data:image/PNG;base64,' . base64_encode($data);
								$temp = explode($links[1][0], $item->svg);
								if (isset($temp[1]))
								{
									$item->svg = $temp[0].$base64.$temp[1];
								}								
							}
						}
						
						$doc = new SimpleXMLElement($item->svg);
						unset($doc->attributes()['x']);
						unset($doc->attributes()['y']);						
						$item->svg = $doc->asXml();					
						
						if ($item->rotate != 0)
						{
							$width 		= str_replace('px', '', $item->width);
							$height 	= str_replace('px', '', $item->height);
							$width		= (int) $width/2;
							$height		= (int) $height/2;

							$strsvg = str_replace('<svg ', '<svg ', $item->svg);
							$svg 		.= '<g transform="translate('.$left.', '.$top.')  rotate('.$item->rotate.' '.$width.' '.$height.')">'.$strsvg.'</g>';
						}
						else
						{
							$svg 		.= str_replace('<svg ', '<svg y="'.$top.'" x="'.$left.'" ', $item->svg);
						}
					}
					if ($radius > 0)
						$svg .= '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="'.($view->height+$radius).'" width="'.($view->width+$radius).'"><rect x="-'.(int)($radius/2).'" y="-'.(int)($radius/2).'" rx="'.$radius.'" ry="'.$radius.'" height="'.($view->height+$radius).'" width="'.($view->width+$radius).'" style="fill:none;stroke:#FFFFFF;stroke-width:'.$radius.';"/></svg>';
					$svg .= '</svg>';
					
					$svg = str_replace('<?xml version="1.0"?>', '', $svg);
										
					header('Content-type:image/svg+xml');					
					if ($file == 'svg')
					{
						header('Content-Disposition: attachment; filename="'.$position.'.svg"');
					}
					else
					{						
						$dom = new DOMDocument;
						$dom->loadXML($svg);
						$books = $dom->getElementsByTagName('svg');
						foreach ($books as $book)
						{
							$width 	= $book->getAttribute('width') * 15;
							$book->setAttribute('width', $width);
							
							$height 	= $book->getAttribute('height') * 15;
							$book->setAttribute('height', $height);
							
							$x 	= $book->getAttribute('x') * 15;
							$book->setAttribute('x', $x);
							
							$y 	= $book->getAttribute('y') * 15;
							$book->setAttribute('y', $y);							
						}
						
						$images = $dom->getElementsByTagName('image');
						if ($images->length  > 0) {
							foreach ($images as $image) {
								$width 	= $image->getAttribute('width') * 15;
								$image->setAttribute('width', $width);
								
								$height 	= $image->getAttribute('height') * 15;
								$image->setAttribute('height', $height);
								
								$x 	= $image->getAttribute('x') * 15;
								$image->setAttribute('x', $x);
								
								$y 	= $image->getAttribute('y') * 15;
								$image->setAttribute('y', $y);
							}							
						}
						
						echo $dom->saveXML();						
						exit;
					}					
					echo $svg;
					exit();					
				}
			}
		}
	}
		
	
	function detail($id = '')
	{		
		if((int)$id == 0)
			redirect('admin/orders');
			
		$this->data['breadcrumb'] = lang('orders_admin_order_title');
        $this->data['meta_title'] = lang('orders_admin_order_title');
        $this->data['sub_title'] = lang('detail');
		
		// get order detail
		$order 	= $this->order_m->getOrder($id);
		
		if(count($order) == 0)
		{		
			$this->session->set_flashdata('error', lang('orders_admin_item_id_not_found_msg'.$id));
			redirect('admin/orders');			
		}		
		
		// get items
		$this->data['order'] = $order;
		$items = $this->order_m->getItems($id);
		$this->data['items'] = $items;
		
		// get cliparts
		$listClipart = array();
		$cliparts = $this->order_m->getCliparts($id);
		
		$i = 0;
		foreach($cliparts as $clipart)
		{
			foreach($clipart as $key=>$val)
			{				
			}
			$i++;
		}
		$this->data['listClipart'] = $listClipart;
		
		// get setting
		$this->load->model('settings_m');
		$row 	= $this->settings_m->getSetting();
		$setting = json_decode($row->settings);
		$this->data['setting'] = $setting;
		
		
		// get histories
		$this->data['histories'] = $this->order_m->getHistory($id);
		
		// get user info
		$userInfo	= $this->order_m->getUserInfo($id);
		if ($userInfo !== false)
		{
			$address	= json_decode($userInfo->address);
		}
		else
		{
			$address	= false;
		}
		$this->data['address'] = $address;
		
		
		// get shipping method
		$this->load->model('shipping_m');
		$shipping	= $this->shipping_m->get($order->shipping_id, true);
		$this->data['shipping'] = $shipping;
		
		// get payment method
		$this->load->model('payment_m');
		$payment	= $this->payment_m->get($order->payment_id, true);
		$this->data['payment'] = $payment;
		
		// get discount
		if ($order->discount_id > 0)
		{
			$this->load->model('coupon_m');
			$discount	= $this->coupon_m->get($order->discount_id, true);
		}
		else
		{
			$discount	= array();
		}
		$this->data['discount'] = $discount;
		
		
		// Load view
		$this->data['subview'] = 'admin/order/detail';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	function status($type = '', $id = '')
	{
		// load setting
		$this->load->model('settings_m');
		$row 	= $this->settings_m->getSetting();
		$setting = json_decode($row->settings);	
			
		if($this->input->post('id'))
		{
			// change status of each item
			$id 		= $this->input->post('id');
			$order_id 	= $this->input->post('order_id');
			$status 	= $this->input->post('status');
			
			$data['poduct_status'] = $status;
			
			//status exists.
			if($this->order_m->checkStatus($id, $status, false)) 
				return;
			
			// update item order
			$data['modified_on']	= date('Y-m-d H:i:s');
			$this->order_m->_table_name	= 'order_items';
			$this->order_m->save($data, $id);
			
			// update history
			$item = $this->order_m->getItem($id);
			$item_name= $item->product_name;
			$content = array(
				$item_name=>$status
			);
					
			$data_his = array(
				'order_id'=>$order_id,
				'label'=>'item_status',
				'content'=>	json_encode($content),
				'date'=>date('Y-m-d H:i:s'),
			);
			$this->order_m->_table_name = "orders_histories";
			if($this->order_m->save($data_his))
			{
				//send email to customer.
				$customer = $this->order_m->getUser($order_id);
					
				if(count($customer) > 0)
				{
					$this->load->library('email');
					//config email.
					$config = array(
						'mailtype' => 'html',
						'charset'  => 'utf-8',
						'priority' => '1'
					);
					$subject = 'Changed item order status';
					$message = '<p>Hello '.$customer->username.'</p><p>The status of product <a target="_blank" href="'.site_url('product/'.$id).'">'.$item_name.'</a> in your order number '.$customer->order_number.' is changed to completed.</p><p>Regards,</p><p><a href="'.site_url().'">'.site_url().'</a></p>';
					
					$this->load->library('email');
					$this->email->initialize($config);
					$this->email->from(getEmail(config_item('admin_email')), getEmail(config_item('site_name')));
					$this->email->to($customer->email);    
					$this->email->subject ( $subject);
					$this->email->message ($message);   
				
					$this->email->send();
				}
			}	
			$order 	= $this->order_m->getOrder($order_id);
			
			// get setting
			$this->load->model('settings_m');
			$row 	= $this->settings_m->getSetting();
			$setting = json_decode($row->settings);
			$this->data['setting'] = $setting;
			// get shipping method
			$this->load->model('shipping_m');
			$shipping	= $this->shipping_m->get($order->shipping_id, true);
			$this->data['shipping'] = $shipping;
			
			// get payment method
			$this->load->model('payment_m');
			$payment	= $this->payment_m->get($order->payment_id, true);
			$this->data['payment'] = $payment;
			
			// get discount
			if ($order->discount_id > 0)
			{
				$this->load->model('coupon_m');
				$discount	= $this->coupon_m->get($order->discount_id, true);
			}
			else
			{
				$discount	= array();
			}
			$this->data['discount'] = $discount;
			$this->data['order'] = $order;
			
			$this->data['items'] = $this->order_m->getItems($order->id);
			$this->load->view('admin/order/list_item', $this->data);
		}
		elseif(($type == 'pending' || $type == 'completed' || $type == 'refused' ) && $id != '')
		{
			$data['status'] = $type;
			
			if($this->order_m->checkStatus($id, $type, true)) //status order exists.
			{
				$this->session->set_flashdata('error', lang('orders_admin_cannot_change_status_msg'));
				redirect(site_url('admin/orders'));
			}
				
			$where = array(
				'id'=>$id,
			);
			$this->order_m->_table_name = "orders";
			if($this->order_m->updateOrder($where, $data))
			{	
				$order = $this->order_m->getOrder($id);
				$order_name = $order->order_number;
				$content = array(
					$order_name=>$type
				);
				$data_his = array(
					'order_id'=>$id,
					'label'=>'order_status',
					'content'=>json_encode($content),
					'date'=>date('Y-m-d H:i:s'),
				);
				$this->order_m->_table_name = "orders_histories";
				if($this->order_m->save($data_his))
				{
					$customer = $this->order_m->getUser($id);
					
					$this->load->library('email');
					
					//params shortcode
					$params = array(
						'username'=>$customer->username,
						'email'=>$customer->email,
						'date'=>date('Y-m-d H:i:s'),
						'total'=>$customer->total,
						'order_number'=>$customer->order_number,
						'status'=>$type,
					);
					
					//config email.
					// send email to customer 
					$config = array(
						'mailtype' => 'html',
						'charset'  => 'utf-8',
						'priority' => '1'
					);
					$subject = configEmail('sub_order_status', $params);
					$message = configEmail('order_status', $params);
					
					$this->load->library('email');
					$this->email->initialize($config);
					$this->email->from(getEmail(config_item('admin_email')), getEmail(config_item('site_name')));
					$this->email->to($customer->email);    
					$this->email->subject ( $subject);
					$this->email->message ($message);   
				
					if ($this->email->send())
						$this->session->set_flashdata('msg', lang('orders_admin_email_change_status_order_msg').$type);
					else
						$this->session->set_flashdata('error', lang('orders_admin_change_status_not_send_email_msg'));
					redirect(site_url('admin/orders'));
				}
			}else
			{
				$this->session->set_flashdata('error', lang('orders_admin_cannot_change_status_msg'));
			}
			redirect(site_url('admin/orders'));
		}else
		{
			redirect(site_url('admin/orders'));
		}
	}
	
	function delete($id = '')
	{
		if($id != '')
		{
			$this->order_m->_table_name = "orders";
			$where = array(
				'id'=>$id,
			);
			if($this->order_m->deleteOrder($where))
			{
				//delete userinfo.
				$this->order_m->_table_name = "orders_userinfo";
				$where_user = array(
					'order_id'=>$id,
				);
				$this->order_m->deleteOrder($where_user);
				
				//delete clipart.
				$this->order_m->_table_name = "order_cliparts";
				$where_items = array(
					'order_id'=>$id,
				);
				$this->order_m->deleteOrder($where_items);
				
				//delete items.
				$this->order_m->_table_name = "order_items";
				$where_items = array(
					'order_id'=>$id,
				);
				$this->order_m->deleteOrder($where_items);
				
				//delete history.
				$this->order_m->_table_name = "orders_histories";
				$where_his = array(
					'order_id'=>$id,
				);
				$this->order_m->deleteOrder($where_his);
				
				$this->session->set_flashdata('msg', lang('orders_admin_delete_order_success_msg'));
				redirect(site_url('admin/orders'));
			}else
			{
				$this->session->set_flashdata('error', lang('orders_admin_delete_order_error_msg'));
				redirect(site_url('admin/orders'));
			}
		}else
		{
			if($checkb = $this->input->post('checkb'))
			{
				foreach($checkb as $id)
				{
					$this->order_m->_table_name = "orders";
					$where = array(
						'id'=>$id,
					);
					if($this->order_m->deleteOrder($where))
					{
						//delete userinfo.
						$this->order_m->_table_name = "orders_userinfo";
						$where_user = array(
							'order_id'=>$id,
						);
						$this->order_m->deleteOrder($where_user);
						
						//delete clipart.
						$this->order_m->_table_name = "order_cliparts";
						$where_items = array(
							'order_id'=>$id,
						);
						$this->order_m->deleteOrder($where_items);
						
						//delete items.
						$this->order_m->_table_name = "order_items";
						$where_items = array(
							'order_id'=>$id,
						);
						$this->order_m->deleteOrder($where_items);
						
						//delete history.
						$this->order_m->_table_name = "orders_histories";
						$where_his = array(
							'order_id'=>$id,
						);
						$this->order_m->deleteOrder($where_his);
					}
				}
				$this->session->set_flashdata('msg', lang('orders_admin_delete_order_success_msg'));
				redirect(site_url('admin/orders'));
			}
			$this->session->set_flashdata('error', lang('orders_admin_delete_order_error_msg'));
			redirect(site_url('admin/orders'));
		}
	}
	
	function history()
	{
		if($this->input->post('id'))
		{
			$id = $this->input->post('id');
			$this->data['histories'] = $this->order_m->listHistory($id);
			$this->load->view('admin/order/list_history', $this->data);
		}
	}
	
	function pdf($id = '')
	{
		if($id == '' || $id == 0)
			redirect('admin/orders');
			
		// load settting
		$this->load->model('settings_m');
		$row 	= $this->settings_m->getSetting();
		$setting = json_decode($row->settings);
		
		$order = $this->order_m->getOrder($id);
		if(count($order) == 0)
		{	
			$this->session->set_flashdata('error', lang('orders_admin_item_id_not_found_msg').$id);
			redirect('admin/orders');
		}
		
		// get user info
		$billing = array(
			'name'=>$order->name,
			'username'=>$order->username,
			'email'=>$order->email,
		);
		
		$userInfo	= $this->order_m->getUserInfo($id);
		if ($userInfo !== false)
		{
			$address	= json_decode($userInfo->address, true);
		}
		else
		{
			$address	= array();
		}
		
		// get items
		$items = $this->order_m->getItems($id);
		
		// get shipping method
		$this->load->model('shipping_m');
		$shipping	= $this->shipping_m->get($order->shipping_id, true);
		
		// get payment method
		$this->load->model('payment_m');
		$payment	= $this->payment_m->get($order->payment_id, true);
		
		// get discount
		if ($order->discount_id > 0)
		{
			$this->load->model('coupon_m');
			$discounts	= $this->coupon_m->get($order->discount_id, true);
		}
		else
		{
			$discounts	= array();
		}
		
		if(empty($setting->invoice_logo))
			$setting->invoice_logo = '';
		
		// get Products.
		$design_item = $this->order_m->getDesigns($id);
		
		$data = array(
			'shop_name'=>$setting->site_name,
			'shop_url'=>site_url(),
			'logo'=>$setting->invoice_logo,
			'order_number'=>$order->order_number,
			'date'=>date("Y-m-d", strtotime($order->created_on)),
			'date_ship'=>date("Y-m-d", strtotime($order->modified_on)),
			'status'=>$order->status,
			'billing'=>$billing,
			'user_id'=>$order->user_id,
			'address'=>$address,
			'shipping'=>$shipping,
			'shipping_price'=>$order->shipping_price,
			'payment_price'=>0.0,
			'items'=>$items,
			'setting'=>$setting,
			'payment'=>$payment,
			'discounts'=>$discounts,
			'discount'=>$order->discount,
			'products'=>$design_item,
		);
		
		//create pdf.
		$this->load->library('pdf/pdf.php');
		$config = array(
			'write_type'=>'I'
		);

		$pdf = new Pdf($config);
		$file_name = 'Order-'.$order->order_number.'.pdf';
		$pdf->CreatePdf($file_name, $data);
	}
	
	// view detail of design
	function view($id = '', $confirm = '')
	{
		$this->load->model('settings_m');
		$row 	= $this->settings_m->getSetting();
		$setting = json_decode($row->settings);
		$this->data['setting'] = $setting;
		
		$data = $this->order_m->getDesign($id);
		$this->data['product'] = $data;				
		$this->load->view('admin/order/view_lightbox', $this->data);
	}

}