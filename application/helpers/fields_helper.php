<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * Display custom fields
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Field
{

	// display fiels
	public function display($field, $value = null)
	{
		$data 	= new stdClass();
		
		$data->id			= $field->id;
		$data->name			= $field->name;
		$data->title		= $field->title;
		
		if($field->validate == 1)
			$data->validate	= ' validate required';
		else
			$data->validate	= '';
		
		if ($value == null)
			$data->value	= $field->value;
		else
			$data->value	= $value;
		
		
		
		switch ($field->type)
		{
			case 'text':
				$display	= $this->text($data);
				break;
			case 'email':
				$display	= $this->email($data);
				break;
			case 'password':
				$display	= $this->password($data);
				break;
			case 'radio':
				$data->options = $field->value;
				$display	= $this->radio($data);
				break;
			case 'checkbox':
				$data->options = $field->value;
				$display	= $this->checkbox($data);
				break;
			case 'select':
				$data->options = $field->value;
				$display	= $this->select($data);
				break;
			case 'textarea':
				$display	= $this->textarea($data);
				break;
			case 'country':				
				$display	= $this->country($data);
				break;
			case 'state':
				$display	= $this->state($data);
				break;
			default:
				$display	= '';
				break;			
		}
		
		return $display;
	}
	
	// text
	protected function text($data)
	{
		return '<input type="text" class="form-control input-sm '.$data->validate.'" name="fields['.$data->name.']['.$data->id.']" value="'.$data->value.'">';
	}
	
	protected function email($data)
	{
		return '<input type="email" class="form-control input-sm '.$data->validate.'" name="fields['.$data->name.']['.$data->id.']" value="'.$data->value.'">';
	}
	
	protected function password($data)
	{
		return '<input type="password" class="form-control input-sm '.$data->validate.'" name="fields['.$data->name.']['.$data->id.']" value="'.$data->value.'">';
	}
	
	protected function radio($data)
	{
		$field	= '';
		
		if ($data->options != '')
		{
			$values	= json_decode($data->options);
			
			if (count($values) > 0)
			{
				foreach ($values as $key => $value)
				{
					if ($value == $data->value)
						$checked	= 'checked="checked"';
					else
						$checked	= '';
					$field	.= '<label class="radio-inline">'
							.	'<input type="radio" '.$checked.' name="fields['.$data->name.']['.$data->id.']" value="'.$value.'"> '.$key
							.	'</label>';
				}
			}
		}		
		
		return $field;
	}
	
	protected function checkbox($data)
	{
		$field	= '';
		
		if ($data->options != '')
		{
			$values	= json_decode($data->options);
			
			if (count($values) > 0)
			{
				foreach ($values as $key => $value)
				{
					if ($value == $data->value)
						$checked	= 'checked="checked"';
					else
						$checked	= '';
					$field	.= '<label class="checkbox-inline">'
							.	'<input type="checkbox" '.$checked.' name="fields['.$data->name.']['.$data->id.']" value="'.$value.'"> '.$key
							.	'</label>';
				}
			}
		}		
		
		return $field;
	}
	
	protected function select($data)
	{
		$field = '';
		if ($data->options != '')
		{
			$values	= json_decode($data->options);
			
			if (count($values) > 0)
			{
				$field	= '<select autocomplete="off" name="fields['.$data->name.']['.$data->id.']" class="form-control input-sm '.$data->validate.'">';
				foreach ($values as $key => $value)
				{
					if ($value == $data->value)
						$selected	= 'selected="selected"';
					else
						$selected	= '';
						
					$field	.= '<option value="'.$value.'" '.$selected.'> '.$key.'</option>';
				}
				$field	.= '</select>';
			}
		}		
		
		return $field;
	}
	
	protected function textarea($data)
	{
		return '<textarea rows="3" class="form-control input-sm '.$data->validate.'" name="fields['.$data->name.']['.$data->id.']">'.$data->value.'</textarea>';
	}
	
	protected function country($data)
	{
		$CI =& get_instance();
		
		$CI->load->driver('cache');
		
		if (!$country = $CI->cache->file->get('country'))
		{
		
			$CI->db->where('published', 1);
			$query = $CI->db->get('country');
			
			$country	= $query->result();
			
			$CI->cache->file->save('country', $country, 300000);
		}		
		
		$field	= '<select autocomplete="off" name="fields['.$data->name.']['.$data->id.']" id="field-country" onchange="apps.state(this)" class="form-control input-sm '.$data->validate.'">';
		
		$field	.= '<option value="">'.lang('select_country').'</option>';
		
		$n 	= count($country);
		for($i=0; $i<$n; $i++)
		{
			if ($data->value == $country[$i]->id)
				$selected = 'selected="selected"';
			else
				$selected = '';
			$field	.=	'<option '.$selected.' value="'.$country[$i]->id.'">'.$country[$i]->name.'</option>';
		}
		
		$field	.= '</select>';
		
		return $field;
	}
	
	protected function state($data)
	{	
		
		$field	= '<select name="fields['.$data->name.']['.$data->id.']" id="field-state" data-id="'.$data->value.'" class="form-control input-sm '.$data->validate.'">';
		
		$field	.= '<option value="">'.lang('select_state').'</option>';
		$field	.= '</select>';
		
		return $field;
	}
}