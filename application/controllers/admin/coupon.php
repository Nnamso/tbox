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

class Coupon extends Admin_Controller
{

	public function __construct ()
	{
		parent::__construct();
		
		// check user permission		
		$this->users_m->userPermission('coupon');
		
		$this->lang->load('coupon');
		$this->lang->load('metadata');
		$this->load->library('session');
		$this->load->model('coupon_m');
		$this->user = $this->session->userdata('user');
	}

	public function index ()
	{
		$this->data['breadcrumb'] = lang('coupon_admin_breadcrumb');
        $this->data['meta_title'] = lang('coupon_admin_meta_title');
        $this->data['sub_title'] = lang('coupon_admin_sub_title');
		
		// pagination
        $this->load->library('pagination'); 
        $this->load->helper('url');
        $config['base_url'] = base_url('admin/coupon'); 
		
		if ($this->input->post('option'))
		{
			$this->session->set_userdata('search_counpon', $this->input->post('search'));
			$this->session->set_userdata('option_counpon', $this->input->post('option'));
		}
			
        $config['total_rows'] = $this->coupon_m->getCoupons(true, $this->session->userdata('search_counpon'), $this->session->userdata('option_counpon'));
		
		if ($this->input->post('option'))
		{
			if($this->input->post('per_page') == '')
				$this->session->set_userdata('per_page', $config['total_rows']);
			else
				$this->session->set_userdata('per_page', $this->input->post('per_page'));
		}
		
		if($this->session->userdata('per_page') != '')
			$config['per_page'] = $this->session->userdata('per_page');
		else
			$config['per_page'] 	= 20;
			
        $config['uri_segment'] = 3; 
        $config['next_link'] = lang('next'); 
        $config['prev_link'] = lang('prev'); 
        $config['first_link'] = lang('first'); 
        $config['last_link'] = lang('last'); 
        $config['num_links']	= 2;                 
        $this->pagination->initialize($config); 
        $this->data['links'] = $this->pagination->create_links();
		$this->data['per_page'] = $config['per_page'];
		$this->data['search'] = $this->session->userdata('search_counpon');
		$this->data['option'] = $this->session->userdata('option_counpon');
		
		// Fetch all users
		$this->data['coupons'] = $this->coupon_m->getCoupons(false, $this->session->userdata('search_counpon'), $this->session->userdata('option_counpon'), $config['per_page'], $this->uri->segment(3));
		
		// Load view
		$this->data['subview'] = 'admin/coupon/index';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function edit($id = '')
	{
		$this->data['id'] = $id;
		$this->data['error'] = '';
		$this->data['coupon'] = $this->coupon_m->getNew();
		$this->data['breadcrumb'] = lang('coupon_admin_add_coupon_breadcrumb');
        $this->data['meta_title'] = lang('coupon_admin_add_coupon_meta_title');
        $this->data['sub_title'] = lang('coupon_admin_add_coupon_sub_title');
		
		if($id != '')
		{
			$this->data['breadcrumb'] = lang('coupon_admin_edit_coupon_breadcrumb');
			$this->data['meta_title'] = lang('coupon_admin_edit_coupon_meta_title');
			$this->data['sub_title'] = lang('coupon_admin_edit_coupon_sub_title');
			$coupon = $this->coupon_m->getCoupon($id);
			$this->data['coupon'] = $coupon;
			if(count($coupon) == 0)
			{
				$this->session->set_flashdata('error', lang('coupon_not_exsits'));
				redirect(site_url().'admin/coupon');
			}
		}
		if($data = $this->input->post('data'))
		{
			$this->load->library('form_validation');
			// Set form  
			$this->form_validation->set_rules('data[name]', lang('coupon_name'), 'trim|required|min_length[2]|max_length[150]'); 
			$this->form_validation->set_rules('data[value]', lang('coupon_value'), 'trim|required|numeric|min_length[1]|max_length[10]'); 
			$this->form_validation->set_rules('data[minimum]', lang('minimum'), 'trim|required|numeric|min_length[1]|max_length[10]'); 
			$this->form_validation->set_rules('data[coupon_type]', lang('coupon_type'), 'trim|required|min_length[1]|max_length[10]|callback_couponType'); 
			$this->form_validation->set_rules('data[discount_type]', lang('coupon_percent_or_total'), 'trim|required|min_length[1]|max_length[10]|callback_discounType'); 
			$this->form_validation->set_rules('data[start_date]', lang('date_start'), 'trim|required|min_length[1]|max_length[10]|callback_checkdate'); 
			$this->form_validation->set_rules('data[end_date]', lang('date_end'), 'trim|required|min_length[1]|max_length[10]'); 
			
			if ($this->form_validation->run() == TRUE)
			{
				if($id != '')
				{
					if($this->coupon_m->save($data, $id))
					{
						$this->session->set_flashdata('msg', lang('coupon_msg_edit_success'));
						redirect(site_url().'admin/coupon');
					}else
					{
						$this->session->set_flashdata('error', lang('coupon_msg_edit_error'));
						redirect(site_url().'admin/coupon');
					}
				}else
				{
					$data['code'] = $this->createCode($this->user['id']);
					$cou_id = $this->coupon_m->save($data);
					if($cou_id > 0)
					{
						$this->session->set_flashdata('msg', lang('coupon_msg_add_success'));
						redirect(site_url().'admin/coupon');
					}else
					{
						$this->session->set_flashdata('error', lang('coupon_msg_add_error'));
						redirect(site_url().'admin/coupon');
					}
 				}
			}
		}
		$this->data['subview'] = 'admin/coupon/edit';
		$this->load->view('admin/_layout_main', $this->data);
	}
	
	public function couponType()
	{
		$data = $this->input->post('data');
		if ($data['coupon_type'] != 'p' && $data['coupon_type'] != 'g')
		{
			$this->form_validation->set_message('coupon_type', lang('coupon_coupon_type_validate'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function discounType()
	{
		$data = $this->input->post('data');
		if ($data['discount_type'] != 't' && $data['discount_type'] != 'p')
		{
			$this->form_validation->set_message('discount_type', lang('coupon_discount_type_validate'));
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function checkDate()
	{
		$data = $this->input->post('data');
		if (strtotime($data['start_date']) < strtotime($data['end_date']))
		{
			return TRUE;
		}
		else
		{
			$this->form_validation->set_message('checkdate', lang('coupon_checkdate_validate'));
			return FALSE;
		}
	}
	
	public function publish($id = '')
	{
		$data['publish'] = 1;
		if($id != '')
		{
			if(count($this->coupon_m->getCoupon($id)) > 0)
			{
				$this->coupon_m->save($data, $id);
				redirect(site_url().'admin/coupon');
			}
		}else
		{
			if($checkb = $this->input->post('checkb'))
			{
				if(is_array($checkb))
				{
					foreach($checkb as $id)
					{
						$this->coupon_m->save($data, $id);
					}
				}
			}
		}
		redirect(site_url().'admin/coupon');
	}
	
	public function unPublish($id = '')
	{
		$data['publish'] = 0;
		if($id != '')
		{
			if(count($this->coupon_m->getCoupon($id)) > 0)
			{
				$this->coupon_m->save($data, $id);
				redirect(site_url().'admin/coupon');
			}
		}else
		{
			if($checkb = $this->input->post('checkb'))
			{
				if(is_array($checkb))
				{
					foreach($checkb as $id)
					{
						$this->coupon_m->save($data, $id);
					}
				}
			}
		}
		redirect(site_url().'admin/coupon');
	}
	
	public function delete($id = '')
	{
		if($id != '')
		{
			if($this->coupon_m->delete($id))
			{
				$this->session->set_flashdata('msg', lang('coupon_delete_success_msg'));
				redirect(site_url().'admin/coupon');
			}else
			{
				$this->session->set_flashdata('error', lang('coupon_delete_error_msg'));
				redirect(site_url().'admin/coupon');
			}
		}else
		{
			if($checkb = $this->input->post('checkb'))
			{	
				$check = true;
				if(is_array($checkb))
				{
					foreach($checkb as $id)
					{
						if(!$this->coupon_m->delete($id))
						{
							$check = false;
							break;
						}
					}
					if($check == true)
						$this->session->set_flashdata('msg', lang('coupon_delete_success_msg'));
					else
						$this->session->set_flashdata('error', lang('coupon_delete_multi_error_msg'));
				}else
				{
					$this->session->set_flashdata('error', lang('coupon_delete_error_msg'));
				}
			}
		}
		redirect(site_url().'admin/coupon');
	}
	
	public function createCode($user_id)
	{
		$rand 			= strtoupper(uniqid(sha1(time())));
		$code 	= substr($rand, -7);
		
		$code	.= $user_id;
		
		return $code;
	}

}