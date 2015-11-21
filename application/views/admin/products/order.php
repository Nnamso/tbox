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
<section>
	<h2><?php echo lang('product_page');?></h2>
	<p class="alert alert-info"><?php echo lang('product_page_click_save');?></p>
	<div id="orderResult"></div>
	<input type="button" id="save" value="<?php echo lang('save');?>" class="btn btn-primary" />
</section>

<script>
$(function() {
	$.post('<?php echo site_url('admin/page/order_ajax'); ?>', {}, function(data){
		$('#orderResult').html(data);
	});

	$('#save').click(function(){
		oSortable = $('.sortable').nestedSortable('toArray');

		$('#orderResult').slideUp(function(){
			$.post('<?php echo site_url('admin/page/order_ajax'); ?>', { sortable: oSortable }, function(data){
				$('#orderResult').html(data);
				$('#orderResult').slideDown();
			});
		});
		
	});
});
</script>