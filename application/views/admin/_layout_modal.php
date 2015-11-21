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

?>
<?php $this->load->view('admin/components/page_head'); ?>

<?php $this->load->view($subview); // Subview is set in controller ?>

<?php $this->load->view('admin/components/page_footer'); ?>