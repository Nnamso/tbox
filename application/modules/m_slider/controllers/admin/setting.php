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

class Setting extends Admin_Controller
{
	public function __construct ()
	{
		parent::__construct();		
		$this->load->model('m_slider_m');
		$this->lang->load('slider');
	}
	
	public function index()
	{ 
		// pagination
        $this->load->library('pagination'); 
        $config['base_url'] = base_url('m_slider/admin/setting/index'); 
        $config['total_rows'] = $this->m_slider_m->getSliders(true);
		$config['per_page'] = 10;
        $config['uri_segment'] = 5; 
        $config['next_link'] = lang('next'); 
        $config['prev_link'] = lang('prev'); 
        $config['first_link'] = lang('first'); 
        $config['last_link'] = lang('last'); 
        $config['num_links']	= 2;                 
        $this->pagination->initialize($config); 
        $this->data['links'] = $this->pagination->create_links();
		if($this->uri->segment(4) == 'index')
			$segment = $this->uri->segment(5);
		else
			$segment = '';
			
		$this->data['sliders'] = $this->m_slider_m->getSliders(false, $config['per_page'], $segment);
		
		if($this->input->post('type') == 'ajax')
			$this->load->view('admin/ajax', $this->data);
		else
			$this->load->view('admin/index', $this->data);
	}
	
	public function edit($id = '')
	{ 
		if($id == '')
		{
			$this->data['slider'] = $this->m_slider_m->getNew();
		}else
		{
			$slider = $this->m_slider_m->getslider($id);
			if(count($slider) > 0)
			{
				$this->data['slider'] = $slider;
			}else
			{
				echo '<p class="col-md-12">Data not found.</p>';
				exit;
			}
		}
		$this->data['id'] = $id;
		$this->load->view('admin/setting', $this->data);
	}

	public function save($id = '') //Add or Edit slider.
	{
		$this->load->library('form_validation');
		
		if($title = $this->input->post('title'))
		{
			$this->form_validation->set_rules('title', lang('title'), 'trim|required|min_length[2]|max_length[200]');
			$this->form_validation->set_rules('data[images][]', lang('image'), 'trim|required|min_length[2]|max_length[200]');
			if ($this->form_validation->run() == TRUE)
			{
				$data['title'] = $title;
				$data['options'] = json_encode($this->input->post('setting'));
				$data['content'] = json_encode($this->input->post('data'));
				$data['params'] = json_encode($this->input->post('params'));
				if($id == '')
				{
					$data['type'] = 'slider';
					$data['key'] = 'slider'.uniqid();
					if($id = $this->m_slider_m->save($data))
					{
						$content = array(
							'id'		=> $id,
							'error'		=> 0,
							'key'		=> $data['key'],
							'title'		=> $data['title'],
							'module'	=> 'm_slider',
							'control'	=> 'm_slider',
							'method'	=> 'index',
							'content'	=> '{module:m_slider/index,'.$id.'}'
						);
					}else
					{
						$content = array(
							'error'		=> 1,
							'content'		=> lang('slider_admin_setting_add_error_msg'),
						);
					}
				}else
				{
					$slider = $this->m_slider_m->getslider($id);
					if(count($slider) > 0)
					{
						if($this->m_slider_m->save($data, $id))
						{
							$content = array(
								'id'		=> $id,
								'error'		=> 0,
								'key'		=> $slider->key,
								'title'		=> $data['title'],
								'module'	=> 'm_slider',
								'control'	=> 'm_slider',
								'method'	=> 'index',
								'content'	=> '{module:m_slider/index,'.$id.'}'
							);
						}else
						{
							$content = array(
								'error'		=> 1,
								'content'		=> lang('slider_admin_setting_edit_error_msg'),
							);
						}
					}else
					{
						$content = array(
							'error'		=> 1,
							'content'		=> lang('slider_admin_setting_edit_not_found_error_msg'),
						);
					}
				}
			}else
			{
				$content = array(
					'error'		=> 1,
					'content'		=> strip_tags(validation_errors()),
				);
			}
			echo json_encode($content);
		}
		exit;
	}
	
	public function remove($id = '')
	{
		if($this->input->post('type') == 'ajax')
		{
			$this->m_slider_m->delete($id);
			$this->index();
		}
	}
}