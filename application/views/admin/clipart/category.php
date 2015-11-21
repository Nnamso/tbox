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
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<h4 class="modal-title"><?php echo lang('art_change_category'); ?></h4>
</div>

<div class="modal-body">	
	<select id="art_change_cate_id" class="form-control form-control">					
		<?php echo dispayTree( $categories, 0, array('type'=>'select', 'name'=>''), array($art) ); ?>
	</select>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('close'); ?></button>
	<button type="button" class="btn btn-primary" onclick="dgUI.art.saveCategory(<?php echo $art_id; ?>)"><?php echo lang('save'); ?></button>
</div>