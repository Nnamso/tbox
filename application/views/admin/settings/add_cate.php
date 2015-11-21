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
<div class="modal-body">
	<div style="margin-bottom: 0px;" class="form-group">
		<div class="col-md-10">
			<label for="form-field-select-4">
				<?php echo lang('select_cate')?>
			</label>
		</div>
		<div class="col-md-9">	
			<?php 
				$option = array(
					'0'=>'Choose category'
				);
				foreach($cate as $val)
				{
					$option[$val->id] = $val->title;
				}
				echo form_dropdown('data[cate_id]', $option, $font->cate_id, 'class="form-control" id="list-cate-font"');
			?>
		</div>
		<div class="col-md-3" style="padding: 5px 0px;">
			<a href="javascript:void(0)" onclick="editCateFont()" class="btn btn-primary btn-xs tooltips" data-toggle="modal" data-target="#modal_edit_cate" data-toggle="tooltip" data-placement="top" title="<?php echo lang('fonts_edit_edit_cate_tooltip');?>"><i class="fa fa-pencil-square-o"></i></a>
			<a onclick="removeCateFont()" href="javascript:void(0)" class="btn btn-bricky btn-xs tooltips" data-toggle="tooltip" data-placement="top" title="<?php echo lang('fonts_edit_remove_cate_tooltip');?>"><i class="fa fa-trash-o"></i></a>
		</div>
		<div class="col-md-10">
			<a href="javascript:void(0);" onclick="add()"><?php echo lang('fonts_add_category')?></a>
		</div>
	</div>
</div>