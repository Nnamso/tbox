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

class Art_m extends MY_Model
{
	public $_table_name 	= 'cliparts';
	public $_order_by 		= 'created desc';
	public $_primary_key 	= 'clipart_id';
	public $_timestamps 	= TRUE;
	public $rules = array(
		'user_id' => array(
			'field' => 'user_id', 
			'label' => 'author', 
			'rules' => 'trim|required'
		), 
		'type' => array(
			'field' => 'type', 
			'label' => 'Type', 
			'rules' => 'trim|required|max_length[100]|xss_clean'
		), 
		'colors' => array(
			'field' => 'colors', 
			'label' => 'Colors', 
			'rules' => 'trim|required|max_length[100]|url_title|xss_clean'
		), 
		'view' => array(
			'field' => 'view', 
			'label' => 'View', 
			'rules' => 'trim|required|max_length[100]|url_title|xss_clean'
		), 
		'display' => array(
			'field' => 'display', 
			'label' => 'Display', 
			'rules' => 'trim|required|max_length[100]|url_title|xss_clean'
		), 
		'created' => array(
			'field' => 'created', 
			'label' => 'Created', 
			'rules' => 'trim|required|max_length[100]|url_title|xss_clean'
		), 
		'colors' => array(
			'field' => 'colors', 
			'label' => 'Colors', 
			'rules' => 'trim|required|max_length[100]|url_title|xss_clean'
		),		
		'published' => array(
			'field' => 'published', 
			'label' => 'Published', 
			'rules' => 'trim|required'
		)
	);

	public function getNew ($type = '')
	{
		$data = new stdClass();
		
		$data->clipart_id 	= null;
		$data->user_id 		= 0;
		$data->cate_id 		= 0;
		$data->system 		= 0;
		$data->system_id 	= 0;
		$data->title 		= '';
		$data->slug 		= '';
		$data->description 	= '';
		$data->status 		= '';
		$data->feature 		= 0;
		$data->remove 		= 0;
		$data->type 		= 'vector';
		$data->fle_url 		= '';
		$data->file_name 	= '';
		$data->file_type 	= '';
		$data->colors 		= '';
		$data->view 		= 0;
		$data->copyright	= 0;
		$data->change_color	= 0;
		$data->add_price 	= 0;				
		$data->display 		= 1;				
		$data->published 	= 1;
		$data->created 		= date('Y-m-d');
		$data->modified		= date('Y-m-d');
		
		return $data;
	}
	
	public function getArts($cate_id = 0, $count = false, $limit = 0, $art_id = 0, $search = '')
	{
		$this->db->select('cliparts.*');		
				
		if($search != '')
		{			
			$this->db->where('(`title` LIKE \'%'.$search.'%\' OR `description` LIKE \'%'.$search.'%\')');
		}
				
		if ($cate_id > 0)
			$this->db->where('cate_id', $cate_id);
			
		$this->db->order_by('created', 'DESC');
		
		if ($count == true)
		{
			$query 	= $this->db->get('cliparts');
			$art 	= count($query->result());
		}
		else
		{
			$this->db->limit(24, $limit);
			$query 	= $this->db->get('cliparts');
			$art 	= $query->result();			
		}
		
		return $art;
	}
	
	public function getArt($id, $select = '*')
	{
		$this->db->select($select);
		return parent::get($id);
	}
	
	
	public function set_published(){
		$this->db->where('pubdate <=', date('Y-m-d'));
	}
	
	public function get_recent($limit = 3){
		
		// Fetch a limited number of recent articles
		$limit = (int) $limit;
		$this->set_published();
		$this->db->limit($limit);
		return parent::get();
	}

}