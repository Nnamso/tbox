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
 
class Auth  {
	
	function Auth()
	{
		$this->ci =& get_instance();
	}

	// get input of token
	public function getToken()
	{
		$token			= $this->ci->session->userdata('token');
		
		if ($token == false)
		{
			$key			= md5(uniqid() . microtime() . rand());
			$value			= md5(uniqid() . microtime() . rand());
			
			$token[$key]	= $value;
			
			$this->ci->session->set_userdata('token', $token);
		}
		else
		{
			$key 	= key($token);
			$value 	= $token[$key];
		}
		
		$input 			= '<input type="hidden" name="token['.$key.']" value="'.$value.'" class="token">';
		
		return $input;
	}
	
	public function checkToken()
	{
		$posted_token	= $this->ci->input->post('token');
		
		$ajax			= $this->ci->input->post('ajax');
		
		$token			= $this->ci->session->userdata('token');
		if ($posted_token === FALSE || is_array($posted_token) === false)
		{
			if ($ajax === false)
			{
				// Invalid request, send error 400.
				$this->ci->session->set_flashdata('error', 'Request was invalid. Tokens did not match.');
				return false;
			}
			else
			{
				$msg 	= array(
					'error' => 1,
					'msg'	=> 'Request was invalid. Tokens did not match.'
				);
				echo json_encode($msg); exit;
			}			
		}

		$key 	= key($posted_token);		
		
		$value 	= $posted_token[$key];			
		
		if (empty($token[$key]) || $token[$key] != $value)
		{
			if ($ajax === false)
			{
				$this->ci->session->set_flashdata('error', 'Request was invalid. Tokens did not match.');
				return false;
			}
			else
			{
				$msg 	= array(
					'error' => 1,
					'msg'	=> 'Request was invalid. Tokens did not match.'
				);
				echo json_encode($msg); exit;
			}
		}
		
		unset($token[$key]);
		$this->ci->session->set_userdata('token',$token);
		
		return true;
	}
}

?>