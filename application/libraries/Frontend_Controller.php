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

class Frontend_Controller extends MY_Controller
{
	private $cssFiles	= array();
	private $jsFiles	= array();
	function __construct ()
	{
		parent::__construct();		
		$this->load->helper('url');

		$file = ROOTPATH .DS. 'install.txt';
		if (file_exists ( $file ))
		{
			if ($this->uri->segment(1) != 'install')
			{
				redirect('install/index');
			}
		}
		
		$className 	= $this->router->fetch_class();
		$method		= $this->router->fetch_method();
		if ( method_exists($className, $method) == false )
		{
			redirect('error404');			
		}
		
		$this->load->database();
		
		$this->load->helper('cms');
		$this->load->helper('form');
				
		$this->lang->load('system');
		$this->lang->load('frontend');
		
		$this->load->library('session');
		$this->load->library('cart');	
		$this->load->library('auth');		
	}
	
	// load page theme with data
	public function theme($data, $control = '')
	{		
		// get setting
		$this->load->model('settings_m');
		$setting 	= $this->settings_m->getSetting();
		$settings	= json_decode($setting->settings);
		
		if (empty($settings->theme))
			$theme = 'default';
		else
			$theme = $settings->theme;
		
		// check page title and load page title default
		if (empty($data['title']))
		{
			$data['title']	= $settings->site_name;
		}
		
		if (empty($data['meta_description']))
		{
			$data['meta_description']	= $settings->meta_description;
		}
		
		if (empty($data['meta_keywords']))
		{
			$data['meta_keywords']	= $settings->meta_keywords;
		}
		
		if (empty($data['meta']))
		{
			$data['meta']	= '';
		}
		
		// load header
		$head = $this->load->view('layouts/components/head', array(), true);
		$footer = $this->load->view('layouts/components/footer', array(), true);
		
		// add core js, css
		$this->output->css(base_url('assets/plugins/bootstrap/css/bootstrap.min.css'));
		$this->output->css(base_url('assets/plugins/jquery-ui/jquery-ui.min.css'));
		$this->output->css(base_url('assets/plugins/font-awesome/css/font-awesome.min.css'));
		$this->output->css(base_url('assets/css/core.css'));
		
		$this->js('assets/js/jquery.min.js');
		$this->js('assets/plugins/jquery-ui/jquery-ui.min.js');
		$this->js('assets/plugins/bootstrap/js/bootstrap.min.js');
		$this->js('assets/js/core.js');
		
		$this->assets();
		
		// call control
		if ($control != '' && isset($data['subview']) && isset($data['content']))
		{
			$data['subview']	= str_replace('{page:'.$control.'}', $data['content'], $data['subview']);
			unset($data['content']);
		}		
		$data['subview'] 	= $head.$data['subview'].$footer;
		
		$this->parser->parse('themes/'.$theme.'/index.php', $data);
	}
	
	// add css
	public function css($file = null, $full = false)
	{
		if($file != null && !in_array($file , $this->cssFiles))
        {
			if ($full === true)
				$this->cssFiles[] = $file;
			else
				$this->cssFiles[] = base_url($file);
        }
	}
	
	// add js
	public function js($file = null, $full = false)
	{
		if($file != null && !in_array($file , $this->jsFiles))
        {
			if ($full === true)
				$this->jsFiles[] = $file;
			else
				$this->jsFiles[] = base_url($file);
        }
	}
	
	// get all css, js file
	private function assets()
	{
		// js
		if(!empty($this->jsFiles))
        {
            foreach($this->jsFiles as $file)
			{
				$this->output->js($file);
			}
		}
		
		//css
		if(!empty($this->cssFiles))
        {
            foreach($this->cssFiles as $file)
			{
				$this->output->css($file);
			}
		}
	}
}