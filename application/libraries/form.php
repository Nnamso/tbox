<!-- 
********************* CREATE XML FORM FILE *********************

***   type="layout-open": open new html.
*     name="div, ul, li, a, span, a, ..." & add (class="", id="", rol="",...).
*     EG: <field type="layout-option" name="div" class="abc"/> => <div class="abc">
*
***   type="layout-close": close html.
*	  name="div, ul, li, a, span, a, ..."
*     EG: <field type="layout-close" name="div"/> => </div>
*
***   type="label-tooltip": Tooltips hover on question-icon in label.  
*	  value="language_codeigniter" -> Language.
*     title="language_codeigniter" -> Language.
*
***	  type="label": Form Label
*	  value="language_codeigniter" -> Language.
*
***	  type="text, file, submit, password, radio, checkbox": Form Input
*	  placeholder="language_codeigniter" -> Language.
*	  data-msg="language_codeigniter" -> Language(form validate).
*
***	  type="select": Form Select
*	  EG: <field type="select">
*		  		<option value="1">language_codeigniter</option>
*         </field>
*
***   type="textarea": Form Textarea.
*     placeholder="language_codeigniter" -> Language.
*
***	  tooltip: class="tooltips", data-toggle="tooltip", data-placement="top, right, left, bottom", title="language".
-->

<!--
********************* READ FORM XML FILE CLASS *********************

$data = array('name_form'=>'value'); value of form.
$form = new form();
$form->field($path, $data)
-->

<?php

	include_once('xml.php');
	
	class form extends MY_Controller
	{
		function __construct()
		{
			$this->xml = new xml();
		}
		
		function field($path, $form_vl = array())
		{
			$CI = get_instance();
			$CI->lang->load('admin');
			$CI->lang->load('system');
			
			if(!file_exists($path))
			{
				return array();
			}
			
			$data = $this->xml->parse($path);

			$form_field = array();
			
			foreach($data as $fields)
			{
				foreach($fields as $field)
				{
					//layout-open.
					if(isset($field["@attributes"]["type"]) && $field["@attributes"]["type"] == 'layout-open')
					{
						$layout = '';
						$name = '';
						foreach($field["@attributes"] as $key=>$value)
						{	
							if($key=='name')
								$name = $value;
							else if($value != 'layout-open')
								$layout .= $key .' = "'.$value.'"';
						}
						$form_field[] = '<'.$name.' '.$layout.'>';
					}
					
					//layout-close.
					if(isset($field["@attributes"]["type"]) && $field["@attributes"]["type"] == 'layout-close')
					{
						$name = '';
						foreach($field["@attributes"] as $key=>$value)
						{	
							if($key=='name')
								$name = $value;
						}
						$form_field[] = '</'.$name.'>';
					}
					
					//form type label_tooltip question.
					if(isset($field["@attributes"]["type"]) && $field["@attributes"]["type"] == 'label-tooltip')
					{
						$label = '';
						$label_value = '';
						$tooltip = '';
						foreach($field["@attributes"] as $key=>$value)
						{
							if($key == 'data-toggle' || $key == 'data-placement' || $key == 'title')
							{
								if($key == 'title')
									$tooltip .= $key .' = "'.$CI->lang->line($value).'"';
								else
									$tooltip .= $key .' = "'.$value.'"';
							}else if($key != 'value')
							{
								$label .= $key .' = "'.$value.'"';
							}else
							{
								$label_value = $value;
							}
						}
						$form_field[] = '<label '.$label.'>'.$CI->lang->line($label_value).' <i class="fa fa-question-circle tooltips" '.$tooltip.'></i></label>';
					}
					
					//form type label.
					if(isset($field["@attributes"]["type"]) && $field["@attributes"]["type"] == 'label')
					{
						$label = '';
						$label_value = '';
						foreach($field["@attributes"] as $key=>$value)
						{	
							if($key == 'title')
							{
								$label .= $key .' = "'.$CI->lang->line($value).'"';
							}else if($key != 'value')
							{
								$label .= $key .' = "'.$value.'"';
							}else
							{
								$label_value = $value;
							}
						}
						$form_field[] = '<label '.$label.'>'.$CI->lang->line($label_value).'</label>';
					}
					
					//form type input.
					if(isset($field["@attributes"]["type"]) && ($field["@attributes"]["type"] == 'text' || $field["@attributes"]["type"] == 'password' || $field["@attributes"]["type"] == 'checkbox' || $field["@attributes"]["type"] == 'file' || $field["@attributes"]["type"] == 'submit' || $field["@attributes"]["type"] == 'hidden' || $field["@attributes"]["type"] == 'reset'))
					{
						$text = '';
						foreach($field["@attributes"] as $key=>$value)
						{	
							if($key == 'title' || $key == 'placeholder' || $key == 'data-msg')
							{
								$text .= $key .' = "'.$CI->lang->line($value).'"';
							}else 
							{
								$text .= $key .' = "'.$value.'"';
							}
							if(isset($form_vl[$value]) && $key == 'name')
							{
								$text .= 'value="'.$form_vl[$value].'"';
							}
						}
						$form_field[] = '<input '.$text.' >';
					}
					
					//form type help block.
					if(isset($field["@attributes"]["type"]) && ($field["@attributes"]["type"] == 'help-block'))
					{
						$text = '';
						foreach($field["@attributes"] as $key=>$value)
						{	
							if($key == 'value')
								$text .= $CI->lang->line($value);
						}
						$form_field[] = '<span class="help-block"> '.$text.' </span>';
					}
					
					//form type input radio.
					if(isset($field["@attributes"]["type"]) && $field["@attributes"]["type"] == 'radio')
					{
						$radio = '';
						$checked = '';
						$val = '';
						$name = '';
						foreach($field["@attributes"] as $key=>$value)
						{	
							if($key == 'title')
							{
								$radio .= $key .' = "'.$CI->lang->line($value).'"';
							}else if($key == 'value')
							{
								$val = $value;
								$radio .= $key .' = "'.$value.'"';
							}else if($key == 'name')
							{
								$name = $value;
								$radio .= $key .' = "'.$value.'"';
							}else 
							{
								$radio .= $key .' = "'.$value.'"';
							}
						}
						if($val != '' && $name != '')
						{
							if(isset($form_vl[$name]) && $form_vl[$name] == $val)
							{
								$checked = 'checked=""';
							}
						}
						$form_field[] = '<input '.$radio.' '.$checked.'>';
					}
					
					//form type input radio label.
					if(isset($field["@attributes"]["type"]) && $field["@attributes"]["type"] == 'label-radio')
					{
						$label = '';
						$title = '';
						foreach($field["@attributes"] as $key=>$value)
						{	
							if($key == 'name')
							{
								$title .= $CI->lang->line($value);
							}else if($key != 'title')
							{
								$label .= $key .' = "'.$value.'"';
							}
						}
						$form_field[] = '<label '.$label.' >'.$title.'</label>';
					}
					
					//form type select option.
					if(isset($field["@attributes"]["type"]) && $field["@attributes"]["type"] == 'select')
					{
						$select = '';
						foreach($field["@attributes"] as $key=>$value)
						{
							if($key == 'title')
							{
								$select .= $key .' = "'.$CI->lang->line($value).'"';
							}else
							{
								$select .= $key .' = "'.$value.'"';
							}
							if(isset($form_vl[$value]) && $key == 'name')
							{
								$option_value = $form_vl[$value];
							}
						}
					}
					if(isset($field["option"]) && $select != '')
					{
						$option = '';
						foreach($field["option"] as $value)
						{
							if(isset($value["@content"]) && isset($value["@attributes"]['value']))
							{
								if(isset($option_value))
								{
									if($value["@attributes"]['value'] == $option_value)
									{
										$option .= '<option selected="" value = "'.$value["@attributes"]['value'].'">'.$CI->lang->line($value["@content"]).'</option>';
									}else
									{
										$option .= '<option value = "'.$value["@attributes"]['value'].'">'.$CI->lang->line($value["@content"]).'</option>';
									}
								}else
								{
									$option .= '<option value = "'.$value["@attributes"]['value'].'">'.$CI->lang->line($value["@content"]).'</option>';
								}
							}
						}
						$form_field[] = '<select '.$select.'>'.$option.'</select>';
					}
					
					//form type textarea.
					if(isset($field["@attributes"]["type"]) && $field["@attributes"]["type"] == 'textarea')
					{
						$textarea = '';
						$text_value = '';
						foreach($field["@attributes"] as $key=>$value)
						{	
							if($key == 'title' || $key == 'placeholder' || $key == 'data-msg')
							{
								$textarea .= $key .' = "'.$CI->lang->line($value).'"';
							}else if($key != 'value')
							{
								$textarea .= $key .' = "'.$value.'"';
							}
							if(isset($form_vl[$value]) && $key == 'name') $text_value = $form_vl[$value];
						}
						$form_field[] = '<textarea '.$textarea.' >'.$text_value.'</textarea>';
					}
					
					//form type button.
					if(isset($field["@attributes"]["type"]) && $field["@attributes"]["type"] == 'button')
					{
						$button = '';
						$button_value = '';
						foreach($field["@attributes"] as $key=>$value)
						{
							if($key == 'title')
							{
								$button .= $key .' = "'.$CI->lang->line($value).'"';
							}else if($key != 'value')
							{
								$button .= $key .' = "'.$value.'"';
							}else
							{
								$button_value = $value;
							}
						}
						$form_field[] = '<button '.$button.' >'.$button_value.'</button>';
					}
				}
			}
			return $form_field;
		}
	}