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

class Module extends Admin_Controller
{
	public function __construct ()
	{
		parent::__construct();
		
		// check user permission		
		$this->users_m->userPermission('module');
	}
	
	public function index()
	{
		$this->load->helper('directory');
		$map = directory_map(APPPATH .DS. 'modules', 1);
		
		// get all modules
		$module = array();
		if (count($map) > 0)
		{
			for($i=0; $i<count($map); $i++)
			{
				$file = APPPATH .DS. 'modules' .DS. $map[$i] .DS. $map[$i].'.xml';
				if (file_exists($file))
				{
					$module[] = $map[$i];
				}
			}
		}
		
		// load modules info
		$this->load->library('xml');
		$xml = new Xml();
		$modules = array();
		$j = 0;
		for($i=0; $i<count($module); $i++)
		{
			$file = APPPATH .DS. 'modules' .DS. $module[$i] .DS. $module[$i].'.xml';
			
			$data = $xml->parse($file);
						
			if ( isset($data['name']) && $data['name'] != ''
				&& isset($data['description']) && $data['description'] != ''				
				)
			{
				$modules[$j]				= new stdclass();
				$modules[$j]->name			= $module[$i];
				$modules[$j]->title			= $data['name'];
				$modules[$j]->description 	= $data['description'];				
				$modules[$j]->thumb 		= 'application/modules/'.$module[$i].'/thumb.png';				
				
				$j++;
			}
		}
		
		// get page layout
		$this->load->library('xml');
		$xml = new Xml();		
		$file = APPPATH .DS. 'views' .DS. 'layouts' .DS. 'layouts.xml';
		
		$layouts = $xml->parse($file);
		$pages	= array();
		if(count($layouts))
		{			
			$i = 0;
			//echo '<pre>'; print_r($layouts['group']); exit;
			foreach($layouts['group'] as $group)
			{
				
				if (empty($group['@attributes']['description'])) continue;
				
				$pages[$i]				= new stdClass();
				$pages[$i]->name 		= $group['@attributes']['name'];			
				$pages[$i]->description = $group['@attributes']['description'];
				
				if (empty($group['@attributes']['icon']) || $group['@attributes']['icon'] == '')
				{
					$pages[$i]->icon 		= base_url('assets/images/system/home.png');
				}
				else
				{
					$pages[$i]->icon 		= base_url('assets/images/system/'.$group['@attributes']['icon']);
				}
				$i++;
			}
		}		
		$this->data['pages'] 			= $pages;		
		
		$this->data['modules'] = $modules;
		$this->load->view('admin/module/index', $this->data);
	}
}