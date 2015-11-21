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

class Tweet extends Frontend_Controller{ 

	public function __construct(){ 
		parent::__construct();		
		$this->load->helper('url');
	} 
	
	public function index($id = ''){
		$this->tweet_m = $this->load->model('tweet/tweet_m');		
		$tweet = $this->tweet_m->gettweet($id);
		if(count($tweet) > 0)
		{
			$css = getCss($tweet, 'module');
			$this->data['css']	= $css;	
			$this->data['tweet'] = $tweet;	
			$this->load->view('tweet', $this->data);
		}
	}
}