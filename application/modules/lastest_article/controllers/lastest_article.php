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

class Lastest_Article extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		$this->lastest_article_m = $this->load->model('lastest_article/lastest_article_m');		
		$lastest_article = $this->lastest_article_m->getLastestArticle($id);
		if(count($lastest_article) > 0)
		{
			$this->data['css']	= getCss($lastest_article, 'module');
			$this->data['lastest_article'] = $lastest_article;
			$options = json_decode($lastest_article->options);
			if(isset($options->count) && is_numeric($options->count))
				$count = $options->count;
			else
				$count = 4;
				
			$this->data['articles'] = $this->lastest_article_m->getArticles($count);
				
			$this->load->view('lastest_article', $this->data);
		}
	}
}