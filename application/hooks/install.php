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

class myInstall{
	 var $CI;

    function __construct(){
        $this->CI =& get_instance();
    }
	
	public function install()
	{		
		$this->CI->load->helper('url');	
		
		if ($this->CI->uri->segment(1) != 'install')
		{
			include_once(ROOTPATH .DS. 'application' .DS. 'config' .DS. 'database.php');
			
			$data	= $db['default'];
			$conn 	= mysql_connect($data['hostname'], $data['username'], $data['password']);
						
			if (!$conn) {
				redirect('install/index');
			}
				
			$db_selected = mysql_select_db($data['database'], $conn);
			if (!$db_selected){				
				redirect('install/index');
			}
		}		
	}
}
?>