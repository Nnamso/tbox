<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * Get art of designer
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Art extends Frontend_Controller {
	
	public function __construct(){
        parent::__construct();		
    }
	
	public function categories($system = 0)
	{
		$this->load->model('categories_m');
		$data	= $this->categories_m->getTreeCategories('clipart');
		
		$all 				= array();
		$all[0]				= new stdClass();
		$all[0]->id 		= 0;
		$all[0]->title 		= 'All Art';
		$all[0]->children 	= array();
		$all[0]->parent_id 	= 0;
			
		$categories = array_merge($all, $data);
				
		echo json_encode($categories);	
		exit;
	}
	
	// get all art
	public function arts($cate_id = 0)
	{
		$this->load->model('art_m');			
		$page		= $this->input->post('page');
		$keyword	= $this->input->post('keyword');
		$number		= 24;
		
		$count 		= $this->art_m->getArts($cate_id, true, 0, 0, $keyword);
		$arts		= $this->art_m->getArts($cate_id, false, $page * $number, 0, $keyword);
		
		$clips = array();
		
		if (count($arts)> 0)
		{
			$i = 0;
			$url 	= site_url('media/cliparts') .'/';
			foreach ($arts as $art)
			{
		
				$clips[$i] = new stdClass();
				$clips[$i]->clipart_id 		= $art->clipart_id;
				$clips[$i]->title 			= $art->title;
				$clips[$i]->colors 			= $art->colors;
				$clips[$i]->change_color 	= $art->change_color;
				$clips[$i]->file_type 		= $art->file_type;
				$clips[$i]->file_name 		= $art->file_name;
				
				// thumb
				$image 						= str_replace($art->file_name, '', $art->fle_url);
				$clips[$i]->path 			= $url;
				$clips[$i]->url 			= $url . $image;
				$clips[$i]->thumb 			= $image . 'thumbs/' . md5($art->clipart_id) .'.png';
				$clips[$i]->medium 			= $image .'medium/' . md5($art->clipart_id.'medium') .'.png';
				
				$i++;
			}
		}
		
		$data 			= array();
		
		if (($count % $number) == 0)
			$data['count']	= $count/$number;
		else
			$data['count']	= (int) ($count/$number) + 1;
		$data['arts']		= $clips;

		echo json_encode($data);
		exit;
	}
	
	// get art detail
	public function detail($id = 0)
	{
		$data = new stdClass();
		if ($id > 0)
		{			
			$this->load->model('art_m');
			$art	= $this->art_m->getArt($id);
			
			if (count($art) > 0)
			{
				$this->load->model('settings_m');
				$currency			= $this->settings_m->getCurrency();
				
				$price				= new stdClass();
				$price->currency_symbol 	= $currency->currency_symbol;
				$price->amount 				= '0.00';
				
				$info				= new stdClass();
				$info->title 		= $art->title;
				$info->description 	= $art->description;
				$data->error 		= 0;
				$data->info 		= $info;
				$data->price 		= $price;
			}
			else
			{				
				$data->error = 1;
			}
		}
		else
		{
			$data->error = 1;
			
		}
		
		echo json_encode($data);
		return;
	}
	
	public function getSVG()
	{
		
		$art_id		= $this->input->post('clipart_id');			
		$type		= $this->input->post('file_type');			
		$medium		= $this->input->post('medium');			
		$url		= $this->input->post('url');
		$file_name	= $this->input->post('file_name');
		$colors		= $this->input->post('colors');
		
		$this->load->driver('cache');
		$fileCache = md5($file_name . $art_id);
		if ($data = $this->cache->file->get($fileCache))
		{
			echo $data;
		}
		else
		{
			$file 	= $url . 'print/' . $file_name;			
			$this->load->library('svg');
					
			$data = array();
			$size = array();
			
			$size['height'] = 100;
			$size['width'] = 100;
			
			$xml = new svg($file, true);
			
			// get width, heigh of svg file
			$width = $xml->getWidth();
			$height = $xml->getHeight();
			
			// calculated width, height
			if($width > $height){
				$newHeight = $size['height'];
				$newWidth = ($size['height'] / $height) * $width;
			}else{
				$newWidth = $size['width'];
				$newHeight = ($size['width'] / $width) * $height;
			}
			
			// set width, height
			$xml->setWidth ($newWidth.'px');
			$xml->setHeight ($newHeight.'px');

			$data['content'] 		= svgJs($xml->asXML());
			$data['info']['type'] 	= 'svg';				
			$data['info']['colors'] = json_decode($colors);

			$data['size']['width'] 	= $newWidth . 'px';
			$data['size']['height'] = $newHeight . 'px';
								
			$this->cache->file->save($fileCache, json_encode($data), 3000000);
			echo json_encode($data);			
		}
		exit;
	}
}

?>