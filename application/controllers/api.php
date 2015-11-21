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

class Api extends Frontend_Controller {
	
	public function __construct(){
        parent::__construct();		
    }
	
	// get image design of product
	function image($product_id = 0, $view = 'front', $index = 0)
	{
		
		$product_id	= (int) $product_id;
		$index		= (int) $index;
		
		if ($product_id == 0) return false;
		
		$this->load->driver('cache');
	
		if ($this->cache->file->get('product-img-'.$product_id.'-'.$view.'-'.$index) == false)
		{
			// load product design
			$this->load->model('product_m');
			$product 	= $this->product_m->getProductDesign($product_id);
			if ( count($product) )
			{
				$this->load->helper('product');
				$help_product 	= new helperProduct();
				$design			= $help_product->getDesign($product);
			}
			else
			{
				return false;
			}
			$design	= json_decode(json_encode($design), true);
			
			if (empty($design[$view][$index]))
				return false;
				
			$string = str_replace("'", '"', $design[$view][$index]);
			$string = str_replace('px"', '"', $string);		
			
			$img = new Imagick();
			$img->newImage(500, 500, new ImagickPixel('transparent'));
			$img->setImageFormat('png');
							
			$design 	= json_decode($string, true);
			
			$n = count($design) - 1;
			for($i= $n; $i >= 0; $i--)
			{
				$image = $design[$i];
				
				if ($image['id'] == 'area-design') continue;
				
				$file 	= ROOTPATH .DS. str_replace('/', DS, $image['img']);
				
				$newfile = new Imagick($file);
				$newfile->resizeImage($image['width'], $image['height'], Imagick::FILTER_LANCZOS, 1);
				$img->compositeImage($newfile, Imagick::COMPOSITE_DEFAULT, $image['left'], $image['top']);
			}
			
			$thumbnail = $img->getImageBlob();	
			
			$this->cache->file->save('product-img-'.$product_id.'-'.$view.'-'.$index, base64_encode($thumbnail), 300000);			
		}
		else
		{
			$img = $this->cache->file->get('product-img-'.$product_id.'-'.$view.'-'.$index);
			$thumbnail = base64_decode($img);
		}
			
		header("Content-Type: image/png");
		echo $thumbnail;
	}
}

?>