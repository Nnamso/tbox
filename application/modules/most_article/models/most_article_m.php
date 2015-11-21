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

class most_article_m extends MY_Model
{
	public $_table_name = 'modules';
	public $_primary_key = 'id';
	
	function __construct ()
	{
		parent::__construct();
		$this->db = $this->load->database('', true);
	}
	
	public function getArticles($count)
	{
		$this->db->where('publish', 1);
		$this->db->order_by('view', 'DESC');
		$this->db->limit($count);
		$query = $this->db->get('article');
		return $query->result();
	}
	
	public function getMostArticles($count = false, $number = '', $segment = '')
	{
		$this->db->where('type', 'most_article');
		$this->db->order_by('title', 'ASC');
		if($count == true)
		{
			$query = $this->db->get('modules');
			return count($query->result());
		}else
		{
			$query = $this->db->get('modules', $number, $segment);
			return $query->result();
		}
	}
	
	public function getMostArticle($id = '')
	{
		$this->db->where('id', $id);
		$this->db->where('type', 'most_article');
		$query = $this->db->get('modules');
		return $query->row();
	}
	
	public function getNew()
	{
		$most_article = new stdClass();
		$most_article->title = '';
		$most_article->content = '[]';
		$most_article->options = '[]';
		$most_article->params = '[]';
		return $most_article;
	}
	
	public function delete($id = '')
	{
		$this->db->where('id', $id);
		$this->db->where('type', 'most_article');
		if($this->db->delete('modules'))
			return true;
		else
			return false;
	}
}
?>