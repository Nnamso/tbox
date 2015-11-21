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

class Categories_m extends MY_Model
{
	public $_table_name = 'categories';
	public $_primary_key = 'id';
	
	public function getNew()
	{
		$cate = new stdClass();
		$cate->title = '';
		$cate->slug = '';
		$cate->description = '';
		$cate->meta_title = '';
		$cate->meta_keyword = '';
		$cate->meta_description = '';
		$cate->parent_id = '';
		$cate->published = '';
		$cate->language = '';
		$cate->image = '';
		return $cate;
	}
	
	function getCategories($type = 'clipart', $count = false, $pagination = false, $search = '', $number = '', $offset = '')
	{
		if($search != '')
			$this->db->like('title', $search);
			
		$this->db->where('type', $type);
		$this->db->order_by('order', 'ASC');
		
		if($count == true)
		{
			$query = $this->db->get('categories');
			return count($query->result());
		}
		elseif($pagination == true)
		{
			$query = $this->db->get('categories', $number, $offset);
			return $query->result();
		}
		else
		{
			$query = $this->db->get('categories');
			return $query->result();
		}
	}
	
	function getCategorie($type="clipart", $id)
	{
		$this->db->where('id', $id);
		$this->db->where('type', $type);
		$query = $this->db->get('categories');
		return $query->row();
	}
	
	function getCategory($type="clipart", $id)
	{
		$this->db->where('id', $id);
		$this->db->where('type', $type);
		$query = $this->db->get('categories');
		return $query->row();
	}
	
	public function getTreeCategories($type = 'clipart', $admin = false)
	{		
		$categories = $this->getCategories($type);
		
		if (count($categories) > 0)
		{
			$new = array();
			foreach ($categories as $a){
				$new[$a->parent_id][] = $a;
			}
			$tree = $this->createTree($new, $new[0]);
			
			$categories = $tree;
		}
		return $categories;
	}
	
	public function createTree(&$list, $parent){
		$tree = array();
		foreach ($parent as $k=>$l){
			if(isset($list[$l->id])){
				$l->children = $this->createTree($list, $list[$l->id]);
				if ( count($l->children) > 0) $l->isFolder = true;	
			}
			$tree[] = $l;
		} 
		return $tree;
	}
	
	// get all sub categories
	public function getChildren($id, $published = 1)
	{
		$this->db->where('parent_id', $id);
		$this->db->where('published', $published);
		
		$query = $this->db->get('categories');		
		return $query->result();
	}
	
	// get all product of category
	//
	public function getProducts($cate_id, $published = 1, $count = false, $pagination = array())
	{
		$this->db->select('products.*');
		$this->db->join('product_categories', "products.id = product_categories.product_id");
		if ($cate_id > 0)
			$this->db->where('cate_id', $cate_id);
		$this->db->where('products.published', $published);
		$this->db->group_by('products.id');
		
		if ($count == false && count($pagination))
		{
			$this->db->order_by($pagination['orderby'], $pagination['order']);
			$this->db->limit($pagination['limit'], $pagination['offset']);		
		}
		
		$query = $this->db->get('products');
		
		if ($count == true)
		{
			return $query->num_rows();
		}
		else
		{
			return $query->result();
		}
	}
	
	public function getCurrency($id)
	{
		$this->db->select = '*';
		$this->db->where('currency_id', $id);		
		
		$query = $this->db->get('currencies');
		return $query->row();
	}
	
	// remove more categories
	public function remove($ids){
	
		if (count($ids))
		{			
			for ($i=0; $i<count($ids); $i++)
			{
				$this->delete($ids[$i]);
			}
		}
	}
	
	// remove one category
	function delete($id)
	{
		$this->db->where('id', $id);
		if($this->db->delete('categories'))
			return true;
		else
			return false;
	}
	
	function getCate($id = '')
	{
		$this->db->where('id', $id);
		$this->db->where('published', 1);
		$query = $this->db->get('categories');
		return $query->row();
	}
	
	function getAllCategories($type = 'clipart', $publish = false)
	{
		if($publish == true)
			$this->db->where('published', 1);
		$this->db->where('type', $type);
		$query = $this->db->get('categories');
		return $query->result();
	}
}
?>