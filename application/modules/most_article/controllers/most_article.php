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


class Most_Article extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		$this->most_article_m = $this->load->model('most_article/most_article_m');		
		$most_article = $this->most_article_m->getMostArticle($id);
		if(count($most_article) > 0)
		{
			$this->data['css']	= getCss($most_article, 'module');
			$this->data['most_article'] = $most_article;
			$options = json_decode($most_article->options);
			if(isset($options->count) && is_numeric($options->count))
				$count = $options->count;
			else
				$count = 4;
				
			$this->data['articles'] = $this->most_article_m->getArticles($count);
				
			$this->load->view('most_article', $this->data);
		}
	}
}