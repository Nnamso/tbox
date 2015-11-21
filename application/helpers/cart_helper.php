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

class DgCart{
	
	/*
	 * get price of base product with discount quantity, sale
	 *
	 * $product product info
	 * $lisPrice list price with quantity
	 *
	*/
	function getPrice($product, $lisPrice, $quantity){
	
		$prices	= new stdClass();
		
		$prices->base = $product->price;
		$prices->sale = $product->price;
		
		// overwrite price
		if ($product->sale_price > 0)
		{
			$prices->sale = $product->sale_price;
			return $prices;
		}
		
		// check price with quantity
		if ($lisPrice == false) return $prices;
				
		$mins 	= json_decode($lisPrice->min_quantity);
		$maxs 	= json_decode($lisPrice->max_quantity);
		$price 	= json_decode($lisPrice->price);
		$i 		= count($price) - 1;
		
		if (count($mins) == 0 || count($maxs) == 0 || count($price) == 0) return $prices;
		
		if ($quantity <= $mins[0])
		{
			$prices->sale = $price[0];
			return $prices;
		}

		if ($quantity >= $maxs[$i])
		{
			$prices->sale = $price[$i];
			return $prices;
		}
		
		for($j=0; $j<($i + 1); $j++)
		{
			if ( $quantity >= $mins[$j] && $quantity < $maxs[$j]  )
			{
				$prices->sale = $price[$j];
				return $prices;
			}			
		}
		return $prices;
	}
	
	function getPricePrint($print_type, $setting, $print)
	{
		if ($print['sizes'] == '{}') return 0;
		
		$price = 0;
		
		// get price with size
		$price_A4 =	settingPrint($setting, $print_type, '4', 0);
		$price_A3 =	settingPrint($setting, $print_type, '3', 0);
		
		$sizes = json_decode($print['sizes']);
		$colors = json_decode($print['colors']);
		foreach($sizes as $view=>$value)
		{
			if ($value->size == 3)
			{
				if ($print_type == 'DTG' || $print_type == 'sublimation')
					$price = $price + $price_A3;
				else
					$price = $price + ($price_A3 * count($colors->$view));
			}
			else if ($value->size == 4)
			{
				if ($print_type == 'DTG' || $print_type == 'sublimation')
					$price = $price + $price_A4;
				else
					$price = $price + ($price_A4 * count($colors->$view));
			}
		}
		
		return $price;
	}
	/*
	 * $fields is all attribute get from post
	 * $attributes get attribute from database
	*/
	function getPriceAttributes($attributes, $fields)
	{
		$total 			= 0;
		$data 			= new stdClass();
		$data->prices 	= 0;
		$data->fields 	= array();
		
		$prices 	= json_decode($attributes->prices);
		$types	 	= json_decode($attributes->type);
		$names	 	= json_decode($attributes->name);
		$titles	 	= json_decode($attributes->titles);
		
		if (count($prices) == 0)
		{
			return $data;
		}
		else
		{
			foreach($types as $i=>$type)
			{
				if ( isset($fields[$i]) )
				{
					$data->fields[$i] = array();
					$data->fields[$i]['name'] = $names[$i];
					$data->fields[$i]['type'] = $types[$i];
					$data->fields[$i]['value'] = array();
					
					if ($type == 'selectbox' || $type == 'radio')
					{
						$total = $total + $prices[$i][$fields[$i]];
						
						$data->fields[$i]['value'] = $titles[$i][$fields[$i]];
					}
					elseif ($type == 'textlist') // product size
					{						
						foreach($fields[$i] as $j=>$value)
						{
							$total = $total + ($prices[$i][$j] * $value);
							if ($value == '' || $value == 0) continue;
							$data->fields[$i]['value'][$titles[$i][$j]] = $value;
						}
					}
					elseif ($type == 'checkbox')
					{
						foreach($fields[$i] as $j=>$value)
						{
							$total = $total + $prices[$i][$value];
							
							$data->fields[$i]['value'][$j] = $titles[$i][$j];
						}
					}
				}
			}
		}
		
		$data->prices = $total;
		
		return $data;
	}
	
	function getArtPrice($user, $prices)
	{
		$setting = json_decode($user->shop->setting);
		
		$price 					= new stdClass();
		if (!isset($setting->currency_id))
			$setting->currency_id = 144;
			
		if (!isset($setting->currency_symbol))
			$setting->currency_symbol = '$';
			
		if (!isset($setting->currency_code))
			$setting->currency_code = 'USD';
			
		$price->currency_id		= $setting->currency_id;
		$price->currency_symbol	= $setting->currency_symbol;
		$price->currency_code	= $setting->currency_code;
		
		if (count($prices) == 0)
		{
			$price->amount	= 0;
		}
		else
		{
			$price->amount		= $prices[0]->price;
			$price->from_code	= $prices[0]->currency_code;
			foreach ($prices as $p)
			{
				if ($price->currency_id == $p->currency_id)
				{						
					$price->amount		= $p->price;
					$price->from_code	= $p->currency_code;
					break;
				}
			}
		}
		$price->amount = (int) $price->amount;
		
		if ($price->amount <= 0) return 0;
		
		if ($price->currency_code == $price->from_code) return $price->amount;
		
		if ($price->amount >0 && $price->currency_code != $price->from_code)
		{
			$CI = get_instance();
			$CI->load->helper('google_currency');
			
			$price->amount = currency($price->from_code, $price->currency_code, $price->amount);
		}
		
		return $price->amount;
	}
	
	function totalPrice($products_m, $product, $post, $setting)
	{
		$data 		= new stdClass();
		
		// get base price of product
		$prices 	= $products_m->getProductPrices($post['product_id']);		
		$data->price = $this->getPrice($product, $prices, $post['quantity']);
		
		// get price of product color
		$design = $products_m->getProductDesign($post['product_id']);
		if ($design == false)
		{
			$data->price->colors = 0;
		}
		else
		{
			$data->price->colors 	= 0;
			$color_hex				= json_decode($design->color_hex);
			$color_price			= json_decode($design->price);
			if( $color_hex[key($post['colors'])] == $post['colors'][key($post['colors'])])
				$data->price->colors = $color_price[key($post['colors'])];
			else
				$data->price->colors = 0;
		}
		
		// get price of print
		if (count($setting) > 0)
		{
			if ($product->print_type == '')
				$print_type = 'screen';
			else
				$print_type = $product->print_type;
			
			$data->price->prints = $this->getPricePrint($print_type, $setting, $post['print']);
		}
		else
		{
			$data->price->prints = 0;
		}
		
		// get price attribute
		if ($post['attribute'] == false)
		{
			$data->price->attribute = 0;
		}
		else
		{
			$attributes	= $products_m->getAttribute($post['product_id']);
			if($attributes == false)
			{
				$data->price->attribute = 0;
				$data->options = false;
			}
			else
			{
				if (empty($post['attribute'][$attributes->id]))
				{
					$data->price->attribute = 0;
					$data->options = false;
				}
				else
				{
					$customField 			= $this->getPriceAttributes($attributes, $post['attribute'][$attributes->id]);
					$data->price->attribute = $customField->prices;
					$data->options 			= $customField->fields;
				}					
			}
		}
		
		return $data;
	}
}
?>