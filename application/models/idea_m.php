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


class Idea_m extends MY_Model
{
	public $_table_name = 'design_idea';
	protected $_order_by = 'id';
	public $_primary_key 	= 'id';	
	public $_timestamps 	= true;	

	function __construct ()
	{
		parent::__construct();
	}
	
	public function getCategories ($count = false, $search = '', $number = '', $segment = '')
	{	
		if($search != '')
			$this->db->like('title', $search);
			
		$this->db->order_by('order', 'ASC');
		$this->db->where('type', 'idea');
		if($count == true)
		{
			$query = $this->db->get('categories');
			return count($query->result());
		}else
		{
			$query = $this->db->get('categories', $number, $segment);
			return $query->result();
		}
	}
	
	public function getNewCategory()
	{
		$category = new stdClass();
		$category->id = '';
		$category->title = '';
		$category->slug = '';
		$category->description = '';
		$category->image = '';
		$category->parent_id = '';
		$category->published = '';
		$category->meta_title = '';
		$category->meta_description = '';
		$category->meta_keyword = '';
		return $category;
	}
	
	// get design
	public function getDesigns($count = true, $page = 0, $keyword = '', $limit = 20)
	{
		$this->db->select('design_idea.*, categories.title as cate_name, users_designs.design_id as design_key, product_id, product_options');
		$this->db->join('categories', 'design_idea.cate_id=categories.id');
		$this->db->join('users_designs', 'users_designs.id=design_idea.design_id');
		
		if ($keyword != '')
		{
			$this->db->like('design_idea.title', $keyword);
			$this->db->or_like('design_idea.description', $keyword);
		}
		
		if ($count === true)
		{
			return $this->db->count_all('design_idea');
		}
		else
		{
			$this->db->limit($limit, $page);
			return $this->get();
		}
	}
	
	public function getNew()
	{
		$data 	= array(
			'id'			=> '',
			'title'			=> '',
			'slug'			=> '',
			'description'	=> '',
			'image'			=> '',
			'meta_description'	=> '',
			'meta_title'	=> '',
			'meta_keywords'	=> '',
			'design_id'		=> 0,
			'cate_id'		=> 0,
			'published'		=> 1			
		);
		
		return $data;
	}
	
	public function checkSlug($slug = '', $id = '')
	{
		$this->db->where('id !=', $id);
		$this->db->where('slug', $slug);
		$this->db->where('type', 'idea');
		$query = $this->db->get('categories');
		if($query->num_rows())
			return true;
		else
			return false;
	}
}