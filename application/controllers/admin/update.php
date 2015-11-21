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


class Update extends Admin_Controller {

    public function __construct(){
	
        parent::__construct();
		
		$this->load->library('session');
		$this->user = $this->session->userdata('user');
    }

    public function index() 
	{		
		$this->data['meta_title'] = $this->lang->line('update_admin_meta_title');
		$this->data['breadcrumb'] = $this->lang->line('update_admin_breadcrumb');
		
		$content 	= file_get_contents('http://updates.tshirtecommerce.com/updates.json');
		$data 		= json_decode($content);		
		$this->data['update'] = $data;
		$this->data['subview'] = 'admin/update/index';
    	$this->load->view('admin/_layout_main', $this->data);
    }
	
	public function tool($ver = '')
	{
		if($ver != '')
		{
			$file = 'http://updates.tshirtecommerce.com/'.$ver.'.zip';
			$data = file_get_contents($file);
			if($data != '')
			{				
				$path = ROOTPATH .DS. $ver.'.zip';
				if(file_put_contents($path, $data))
				{
					//unzip.
					$this->load->library('unzip');
					if($this->unzip->extract($path) !== false)
					{						
						$this->session->set_flashdata('msg', $this->lang->line('update_admin_update_success_msg'));
					}
					else
					{
						$this->session->set_flashdata('error', 'Can not unzip files');
					}
					redirect(site_url().'admin/update');
				}
				else
				{
					$this->session->set_flashdata('error', 'Can not unzip files');
					redirect(site_url().'admin/update');
				}
			}
			else
			{
				$this->session->set_flashdata('error', $this->lang->line('update_admin_download_error_msg'));
				redirect(site_url().'admin/update');
			}
		}
		else
		{
			redirect(site_url().'admin/update');
		}
	}
	
}