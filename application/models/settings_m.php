<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * Field
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_m extends MY_Model {

    public $_table_name     = 'settings';
    public $_order_by       = 'id desc';
    public $_primary_key    = 'id';
	
	public function setNew()
	{
		$setting = new stdClass();
		
		$setting->site_logo				= '';
		$setting->site_name				= '';
		$setting->meta_description		= '';
		$setting->meta_keywords			= '';
		$setting->currency_id			= 144;
		$setting->currency_name			= 'United States dollar';
		$setting->currency_code			= 'USD';
		$setting->currency_symbol		= '$';
		
		return $setting;
	}
	
	public function getSetting()
	{
		$query = $this->db->get('settings');
		return $query->row();
	}
	
	public function getCurrency()
	{
		$setting 	= $this->getSetting();
		$options	= json_decode($setting->settings);
		
		$currency 	= new stdClass();
		if (empty($options->currency_symbol) && empty($options->currency_code))
		{
			$currency->id 				= 144;
			$currency->currency_symbol 	= '$';
			$currency->currency_code 	= 'USD';
		}
		else
		{
			$currency->id 				= $options->currency_id;
			$currency->currency_symbol 	= $options->currency_symbol;
			$currency->currency_code 	= $options->currency_code;
		}
		
		return $currency;
	}
	
	public function getCurrencies()
	{
		$query = $this->db->get('currencies');
		return $query->result();
	}
}
?>