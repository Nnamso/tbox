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

class Banner_m extends MY_Model
{
	public $_table_name = 'banner';
	public $_primary_key = 'id';
	
	function __construct ()
	{
		parent::__construct();
		$this->db = $this->load->database('', true);
	}
	
	public function getBanners($count = false, $number = '', $segment = '')
	{
		$this->db->order_by('title', 'ASC');
		if($count == true)
		{
			$query = $this->db->get('banner');
			return count($query->result());
		}else
		{
			$query = $this->db->get('banner', $number, $segment);
			return $query->result();
		}
	}
	
	public function getBanner($id = '')
	{
		$this->db->where('id', $id);
		$query = $this->db->get('banner');
		return $query->row();
	}
	
	public function getNew()
	{
		$banner = new stdClass();
		$banner->title = '';
		$banner->images = '[]';
		$banner->captions = '[]';
		$banner->settings = '[]';
		$banner->params = '[]';
		return $banner;
	}
}
?>