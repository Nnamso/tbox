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

class Modules_m extends MY_Model
{
	public $_table_name 	= 'modules';
	public $_primary_key 	= 'id';
	public $_timestamps 	= FALSE;
	
	public function __construct(){
		parent::__construct();
	}
	
	public function get_new ()
	{
		$data = new stdClass();
		$data->id 			= 0;
		$data->title 		= '';
		$data->type 		= '';
		$data->content		= '';
		$data->options		= '[]';
		$data->params		= '[]';
		
		return $data;
	}
	
	public function save_m($module, $data, $id)
	{
		$data['type'] 		= $module;
		$data['params']		= json_encode($data['params']);
		$data['options']	= json_encode($data['options']);
		if ((int) $id > 0)
		{
			$row 	= $this->get($id, true);
			if (count($row) == 0)
			{
				$id = null;
			}			
		}
		else
		{
			$id = null;
		}
		
		$data['key'] = uniqid();
		
		$id = $this->save($data, $id);
		
		if ((int) $id > 0)
		{
			$content = array(
				'id'		=> $id,
				'error'		=> 0,
				'key'		=> $data['key'],
				'module'	=> $module,
				'control'	=> $module,
				'method'	=> 'index',
				'content'	=> '{module:'.$module.'/index,'.$id.'}'
			);
		}
		else
		{
			$content = array(
				'error' => 1,
				'content' => 'System can not save. Please try again!',
			);
		}
		
		return $content;
		
	}
}