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

echo $css;
$content = json_decode($m_cart->content);	
?>
<div id="shopping-cart">
	<a class="cart" href="<?php echo site_url('cart'); ?>">
		<i class="fa fa-shopping-cart"></i>			
		<span class="badge"><?php echo $items; ?></span>
	</a>
</div>
