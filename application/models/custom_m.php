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

class Custom_m extends MY_Model
{
	public $_table_name = 'article';
	public $_primary_key = 'id';
	public $_timestamps 	= FALSE;
	
	public function getArticles($count = false, $search = '', $number = '', $segment = '')
	{
		$this->db->order_by('date', 'DESC');
		if($search != '')
			$this->db->like('title', $search);
		
		if($count == true)
		{
			$query = $this->db->get($this->_table_name);
			return count($query->result());
		}else
		{
			$query = $this->db->get($this->_table_name, $number, $segment);
			return $query->result();
		}
	}
	
	public function getCateArticle()
	{
		$this->db->select('id,title');
		$this->db->where('type', 'article');
		$query = $this->db->get('categories');
		return $query->result();
	}
	
	public function getArticle($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get($this->_table_name);
		return $query->row();
	}
	
	public function getNew ()
	{
		$article = new stdClass();
		$article->title = '';
		$article->slug = '';
		$article->cate_id = '';
		$article->meta_title = '';
		$article->meta_keyword = '';
		$article->meta_description = '';
		$article->publish = '';
		$article->description = '';
		$article->created = '';
		$article->image = '';
		return $article;
	}
	
	public function delete ($id)
	{
		$this->db->where('id', $id);
		if($this->db->delete($this->_table_name))
			return true;
		else
			return false;
	}
}