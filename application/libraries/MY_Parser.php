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
 
 
class MY_Parser extends CI_Parser {
        
    /**
     *  Parse a template
     *
     * Parses pseudo-variables contained in the specified template,
     * replacing them with the data in the second param
     *
     * @access    public
     * @param    string
     * @param    array
     * @param    bool
     * @return    string
     */
    function parse($template, $data, $return = FALSE)
    {
        $CI =& get_instance();
        $template = $CI->load->view($template, $data, TRUE);
        
        // parse the template for module partials call
        $template = $this->_parse_modules($template);
       
        if ($template == '')
        {
            return FALSE;
        }
        
        foreach ($data as $key => $val)
        {
            if (is_array($val) || is_object($val))
            {
                $template = $this->_parse_pair($key, $val, $template);        
            }
            else
            {
                $template = $this->_parse_single($key, (string)$val, $template);
            }
        }
        
        
        if ($return == FALSE)
        {
            $CI->output->append_output($template);
        }
        
        return $template;
    }
        
    // --------------------------------------------------------------------
    
    /**
     *  Parse for modules
     *
     * @access    private
     * @param    string
     */
    function _parse_modules($template)
    {
		
		preg_match_all("|{(.*):(.*)}|U", $template, $modules);
		//echo '<pre>'; print_r($modules); echo '</pre>'; exit;
		
		$html	= $template;
		if(isset($modules[0][0]))
		{
			for($i=0; $i<count($modules[0]); $i++)
			{
				if ($modules[1][$i] != 'module') continue;
				
				$matches = array();
				$matches[0]	= $modules[0][$i];
				$matches[1]	= $modules[1][$i];
				$matches[2]	= $modules[2][$i];
				$html = str_replace($modules[0][$i], $this->_insert_module($matches), $html);										
			}			
		}
		
        //$template = preg_replace_callback("/{(.*):(.*)}/", array( &$this, '_insert_module'), $template);       
        return $html;
    }
    
    /**
     *  inserts modules
     *
     * @access    private
     * @param    string
     */

    function _insert_module($matches)
	{		
		$parts = explode(',', $matches[2]); //given params divided by ,
		$load = '';
		if($matches[1] === 'module')
		{
			$load = $parts[0];
		}
		else
		{
			$load = $matches[1].'/'.$parts[0];
		}
		$parts[0] = $load;
		
		return call_user_func_array('modules::run', $parts);		
	}

}
