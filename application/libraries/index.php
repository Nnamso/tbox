<?php
/**
 * @author tshirtecommerce - www.tshirtecommerce.com
 * @date: 2015-01-10
 * 
 * @copyright  Copyright (C) 2015 tshirtecommerce.com. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 *
 */
	
	require_once('ins.php');
	
	$config = array(
	  'apiKey'      => 'f74999831b91466ab29e54d71facbfe4',
	  'apiSecret'   => 'b3f854ea5ec04b38aadabb783091b38c',
	  'apiCallback' => 'http://projects.phpbuy.org/instagram'
	);
	
	$in = new ins($config);
	
	$login_url = $in->login();
	if($login_url){
		echo "<a href='".$login_url."'>Connect Instagram</a>";
	}else{
		$data = $in->getAllPhoto();
		
		if(is_array($data))
		{
			foreach($data['photo'] as $photo)
			{
				echo "<img src='".$photo."'>";
			}
		}
		else
		{
			echo '<a href="'.$data.'">Connect Instagram</a>';
		}
	}
	
?>