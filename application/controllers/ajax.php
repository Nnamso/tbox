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

class Ajax extends Frontend_Controller {
	
	public function __construct(){
        parent::__construct();		
    }
	
	public function design($key = '')
	{
		$result	= array();
		$result['error'] 		= 0;
		if ($key == '')
		{
			$result['error'] 	= 1;
			$result['msg'] 		= lang('design_key_found');
		}
		else
		{
			$this->load->model('design_m');
			
			$options = array(
				'design_id'=> $key
			);
			$design = $this->design_m->getDesign($options);
			
			if (count($design) == 0)
			{
				$result['error']	= 1;
				$result['msg'] 		= lang('design_key_found');
			}			
								
			if ($result['error'] == 0)
			{			
				$result['design'] 	= $design;
				$result['msg'] 		= '';
			}
			else
			{
				$result['error'] 	= 1;
				$result['msg'] 		= lang('design_key_found');
			}
		}
		
		echo json_encode($result);
		exit;
	}
	
	
	// get state
	function state($country_id = 0, $value = 0)
	{
		$field	= '<option value="0">'.lang('select_state').'</option>';
		if ($country_id > 0)
		{
			$this->db->where('country_id', $country_id);
			$this->db->where('published', 1);
			
			$query = $this->db->get('states');
			
			$states	= $query->result();
			
			$n 	= count($states);
			for($i=0; $i<$n; $i++)
			{
				if ($value == $states[$i]->id)
					$selected = 'selected="selected"';
				else
					$selected = '';
				$field	.=	'<option '.$selected.' value="'.$states[$i]->id.'">'.$states[$i]->name.'</option>';
			}
		}		
		
		echo $field;
		exit;
	}
	
	// load all color
	function colors()
	{	
		$this->load->model('colors_m');
		$rows 		= $this->colors_m->getColors();		
		
		$colors		= array();
		$data		= array();		
		if(count($rows))
		{
			$data['status']	= 1;
			$i = 0;
			foreach($rows as $color)
			{
				$colors[$i]				= array();
				$colors[$i]['title']	= $color->title;
				$colors[$i]['hex']		= $color->hex;
				$i++;
			}
		}
		else
		{
			$data['status']	= 0;
		}
		
		$data['colors'] = $colors;
		
		echo json_encode($data);
		exit();	
	}
	
	
	// load all fonts
	function fonts()
	{
		$this->load->model('fonts_m');
		$fonts 			= $this->fonts_m->getFonts(false, '', '', 1000, 0);
		
		$data 				= array();
		$google_fonts		= array();
		if (count($fonts) == 0)
		{
			$data['status']	= 0;
		}
		else
		{
			$data['status']	= 1;
			$categories 	= array();
			$cateFonts		= array();
			if (count($fonts))
			{
				foreach ($fonts as $font)
				{
					if ($font->type == 'google')
						$google_fonts[] = $font->title;
						
					$cateFonts[$font->cate_id]['fonts'][] = $font;
					if (!in_array($font->cate_id, $categories))				
					{
						$categories[] = $font->cate_id;
					}
				}
			}
			$data['fonts']					= array();
			
			$google_fonts					= implode('|', $google_fonts);
			$google_fonts					= str_replace(' ', '+', $google_fonts);
			$data['fonts']['google_fonts']	= $google_fonts;
			
			$data['fonts']['fonts']			= $fonts;
			$data['fonts']['cateFonts']		= $cateFonts;
			
			$this->load->model('categories_m');
			$data['fonts']['categories'] 	= $this->categories_m->getCategories('font');
		}
		//echo '<pre>'; print_r($data); echo '</pre>';exit;
		echo json_encode($data);
		exit();	
	}
	
	public function uploadIE()
	{
		$status = "";
		$msg = "";
		
		$data = $this->input->post('myfile');
		$temp 		= explode(';base64,', $data);
		$buffer		= base64_decode($temp[1]);
		
		$this->load->helper('file');
		
		$date 	= new DateTime();
		$year	= $date->format('Y');
		$root 	= ROOTPATH .DS. 'media' .DS. 'assets' .DS. 'uploaded' .DS. $year;
		if (!file_exists($root))
			mkdir($root, 0755);
		
		$month 	= $date->format('m');
		$root 	= $root .DS. $month .DS;
		if (!file_exists($root))
			mkdir($root, 0755);
		
		$file 		= strtotime("now") . '.png';
		$path_file	= $root . $file;
		if ( ! write_file($path_file, $buffer))
		{
			$status = 'error';
			$msg = lang('sys_upload_false');
		}
		else
		{
			$image				= new stdClass();
			
			$image->file_name	= $file;
			$image->file_type	= 'png';
			$image->title		= str_replace('.png', '', $file);
			$image->change_color= 0;
			
			$config['image_library'] 	= 'gd2';
			$config['source_image']		= $path_file;
			$config['create_thumb'] 	= TRUE;
			$config['maintain_ratio'] 	= TRUE;
			$config['width']			= 300;
			$config['height']			= 300;

			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			$thumb 				= str_replace($this->image_lib->dest_folder, '', $this->image_lib->full_dst_path);
			
			$image->thumb 		= site_url() .'media/assets/uploaded/'. $year .'/'. $month .'/'. $thumb;
			
			$info 				= $this->image_lib->get_image_properties($path_file, true);
			$image->width		= $info['width'];
			$image->height		= $info['height'];
			
			$msg 				= $image;
		}
		
		echo json_encode(array('status' => $status, 'msg' => $msg));
	}
	
	public function upload()
	{
		$status = "";
		$msg = "";
		$file_element_name = 'myfile';
		
		$date 	= new DateTime();
		$year	= $date->format('Y');
		$root 	= ROOTPATH .DS. 'media' .DS. 'assets' .DS. 'uploaded' .DS. $year;
		if (!file_exists($root))
			mkdir($root, 0755);
		
		$month 	= $date->format('m');
		$root 	= $root .DS. $month .DS;
		if (!file_exists($root))
			mkdir($root, 0755);
		
		$config['upload_path']		= $root;
		$config['allowed_types'] 	= 'gif|jpg|png|jpge';
		$config['max_size'] 		= 1024 * 10;		
 
		$this->load->library('upload', $config);
 
		if (!$this->upload->do_upload($file_element_name))
		{
			$status = 'error';
			$msg = $this->upload->display_errors('', '');
		}
		else
		{
			$data 				= $this->upload->data();
			$image				= new stdClass();
			
			$image->file_name	= $data['file_name'];
			$image->file_type	= $data['image_type'];
			$image->title		= $data['raw_name'];
			$image->width		= $data['image_width'];
			$image->height		= $data['image_height'];
			$image->change_color= 0;
			$image->url			= site_url() .'media/assets/uploaded/'. $year .'/'. $month .'/'. $image->file_name;
			
			$config['image_library'] = 'gd2';
			$config['source_image']	= $root .DS. $image->file_name;
			$config['create_thumb'] = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['width']	= 300;
			$config['height']	= 300;

			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			$thumb 				= str_replace($this->image_lib->dest_folder, '', $this->image_lib->full_dst_path);
			
			$image->thumb 		= site_url() .'media/assets/uploaded/'. $year .'/'. $month .'/'. $thumb;
			
			$msg 				= $image;
		}			
		echo json_encode(array('status' => $status, 'msg' => $msg));
	}
}

?>