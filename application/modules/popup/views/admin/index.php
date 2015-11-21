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
<div class="form-group"></div>
<div class="form-group col-md-12 text-right">
	<p class="help-block pull-left"><?php echo lang('popup_list_element_title'); ?></p>
	<a class="btn btn-primary" href="javascript:void(0)" onclick="grid.module.setting('popup', '')">
		<i class="glyphicon glyphicon-plus"></i> <?php echo lang('add'); ?>
	</a>	
</div>

<div id="content_popup">
	<div class="col-md-12">
		<table class="table table-bordered table-hover" id="sample-table-1">
			<thead>
				<tr>
					<th class="center" style="width: 10%;"><?php echo lang('popup_list_id_title'); ?></th>
					<th class="center" style="width: 50%;"><?php echo lang('popup_list_module_name_title'); ?></th>
					<th class="center" style="width: 30%;"><?php echo lang('popup_list_key_title'); ?></th>							
					<th class="center" style="width: 10%;"><?php echo lang('popup_list_option_title'); ?></th>
				</tr>
			</thead>
			<tbody>
				
				<?php 
					if(count($popups) > 0)
					{
						foreach($popups as $popup){?>
						<tr>
							<td class="center"><?php echo $popup->id; ?></td>
							<td>
								<a title="Click to choose this module" href="javascript:void(0)" onclick="grid.module.insert('popup', 'index', <?php echo $popup->id; ?>, '<?php echo $popup->key; ?>', '<?php echo $popup->title; ?>')">
									<?php echo $popup->title; ?>
								</a>
							</td>
							<td><?php echo $popup->key; ?></td>
							<td class="center"><i class="fa fa-pencil-square-o" onclick="grid.module.setting('popup', <?php echo $popup->id; ?>)" style="cursor: pointer;"></i><span class="page_ajax"><a href="<?php echo site_url().'popup/admin/setting/remove/'.$popup->id;?>"><i class="glyphicon glyphicon-remove" style="margin-left: 5px; color: #D9534F;"></i></span></td>
						</tr>
					<?php } ?>
				<?php } ?>
				
			</tbody>
		</table>
		<div class="row col-md-12">
			<div class="pull-right page_ajax">
				<?php echo $links; ?>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery(".page_ajax a").click(function(){
				var url = jQuery(this).attr("href");
				var check = true;
				if(url.indexOf('remove') > 0)
				{
					check = confirm('You want remove. Are you sure?');
				}
				
				if(check)
				{
					if(url != '')
					{
						jQuery.ajax({
								type: "POST",
								url: url,
								data: {"type":"ajax"},
								async: true,
								beforeSend: function(){
										jQuery("#content_popup").html("");
								},
								success: function(kq){
										jQuery("#content_popup").html(kq);
								}
						});
					}
				}
				return false;
			});
		})
	</script>
</div>