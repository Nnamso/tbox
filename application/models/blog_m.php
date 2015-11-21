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

class Blog_m extends MY_Model
{
	
	public $_table_name 	= 'article';
	protected $_order_by 	= 'date';
	public $_primary_key 	= 'id';

	function __construct ()
	{
		parent::__construct();
	}

	public function getCategories()
	{
		$this->db->where('type', 'article');
		$this->db->where('published', 1);
		$query = $this->db->get('categories');
		return $query->result();
	}
	
	public function getArticles($count = false, $cate_id, $number = '', $segment = '')
	{
		$this->db->select('article.*');
		$this->db->join('categories', 'categories.id = article.cate_id');
		$this->db->where('article.cate_id', $cate_id);
		$this->db->order_by('article.date', 'DESC');
		if($count == true)
		{
			$query = $this->db->get('article');
			return count($query->result());
		}else
		{
			$query = $this->db->get('article', $number, $segment);
			return $query->result();
		}
	}
	
	public function getLastestArticle()
	{
		$this->db->order_by('date', 'DESC');
		$this->db->where('publish', 1);
		$this->db->limit(5);
		$query = $this->db->get('article');
		return $query->result();
	}
	
	public function getArticle($id = '', $publish = false)
	{
		if($publish == true)
			$this->db->where('publish', 1);
		$this->db->where('id', $id);
		$query = $this->db->get('article');
		return $query->row();
	}
	
	public function getCategory($id = '', $publish = false)
	{	
		if($publish == true)
			$this->db->where('published', 1);
		$this->db->where('id', $id);
		$this->db->where('type', 'article');
		$query = $this->db->get('categories');
		return $query->row();
	}
	
	public function getChildCategory($id = '')
	{	
		$this->db->where('published', 1);
		$this->db->where('parent_id', $id);
		$this->db->where('type', 'article');
		$query = $this->db->get('categories');
		return $query->result();
	}
	
	public function getListArticle($id, $cate_id = '')
	{
		$this->db->where('cate_id', $cate_id);
		$this->db->where('id !=', $id);
		$this->db->where('publish', 1);
		$this->db->order_by('date', 'DESC');
		$this->db->limit(5);
		$query = $this->db->get('article');
		return $query->result();
	}
}