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

class MY_Output extends CI_Output
{
    private $JavascriptFiles = array();
    private $JavascriptTags = "";

    private $CSSFiles = array();
    private $CSSTags = "";

    //Add a javascript file to the array.
    public function js($file = null)
    {
        if($file != null && !in_array($file , $this->JavascriptFiles))
        {
            $this->JavascriptFiles[] = $file;
        }
    }

    //Add a css file to the array.
    public function css($File = null)
    {		
        if($File != null && !in_array($File ,$this->CSSFiles))
        {
            $this->CSSFiles[] = $File;
        }
    }

    //Build the javascript tags
    private function buildtags()
    {
        if(!empty($this->JavascriptFiles))
        {
            foreach($this->JavascriptFiles as $File) {
                $this->JavascriptTags .= "<script type=\"text/javascript\" src=\"$File\"></script>\n";
            }
        }

        if(!empty($this->CSSFiles))
        {
            foreach($this->CSSFiles as $File) {
                $this->CSSTags .= "<link type=\"text/css\" href=\"$File\" rel=\"stylesheet\" media=\"all\" />\n";
            }
        }
    }
	
	public function assets()
	{
		$this->buildtags();
		echo $this->CSSTags;
		echo $this->JavascriptTags;
	}   
}