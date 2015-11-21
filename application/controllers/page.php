<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * Static page
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends Frontend_Controller 
{
    function __construct()
    {
        parent::__construct();
    }
	
	public function index($string = '')
	{
		$id 	= (int) $string;
		
		$found 	= true;
		if ($id == 0)
		{
			$found 	= false;
		}
		else
		{
			$data = array();
			$this->load->model('pages_m');
			
			$page = $this->pages_m->get($id, true);			
		
			if (count($page) == 0)
			{
				$found 	= false;
			}
			else
			{
				$content 	= $page->html;
			}
			
		}
		
		if ($found === true && isset($content))
		{
			$data['subview'] 	= $content;
			
			if ($page->meta_title != '')
				$data['title']	= $page->meta_title;
			
			if ($page->meta_keywords != '')
				$data['meta_keywords']	= $page->meta_keywords;
			
			if ($page->meta_description != '')
				$data['meta_description']	= $page->meta_description;
		}
		else
		{
			$data['subview'] = $this->load->view('layouts/404/404', array(), true);
		}
		
		$this->theme($data);
	}
}
?>