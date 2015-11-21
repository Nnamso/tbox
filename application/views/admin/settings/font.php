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
<?php echo $css = ''; ?>
<table id="sample-table-1" class="table table-bordered table-hover">
	<thead>
		<tr>
			<th class="center">
	<div class="checkbox-table">
		<label>
			<input id="select_all" type="checkbox" name='check_all'>
		</label>
	</div>
	</th>
	<th class="center"><?php echo lang('fonts_name_title'); ?></th>
	<th class="center"><?php echo lang('file_name_title'); ?></th>
	<th class="center"><?php echo lang('thumb'); ?></th>
	<th class="center"><?php echo lang('categories'); ?></th>
	<th class="center"><?php echo lang('published'); ?></th>
	<th class="center"><?php echo lang('action'); ?></th>
	</tr>
	</thead>
	<tbody>
		<?php foreach ($fonts as $font) { ?>
		<tr>
			<td class="center">
				<div class="checkbox-table">
					<label>
						<input type="checkbox" name="checkb[]" class="checkb" name="check" value="<?php echo $font->id; ?>">
					</label>
				</div>
			</td>
			<td><a href="<?php echo site_url()?>admin/settings/fonts/edit_fonts/<?php echo $font->id;?>"><?php echo $font->title; ?></a></td>
			<td>
				<?php
					if ($font->type == '')
					{
						$fonts_name = json_decode($font->filename, true);
						if(is_array($fonts_name)){
								foreach ($fonts_name as $k=>$v){
										if($k != 'ttf'){
												echo $v;
										}else{
												echo '/'.$v;
										}
								}
						}
						else
						{
							echo $font->filename;
						}
					}
					else
					{
						if ($css == '')
						{
							$css = str_replace(' ', '+', $font->title);
						}
						else
						{
							$css = $css .'|'. str_replace(' ', '+', $font->title);
						}
						echo 'Google font';
					}
				?>
			</td>
			<td class="center">
				<?php if ($font->type == '') { ?>
				<a href="<?php echo site_url().'media/fonts/'.$font->thumb; ?>" rel="lightbox" class="tooltips" data-original-title="<?php echo $font->thumb; ?>">
					<img style="height: 30px; width: 65px;" src="<?php echo site_url().'media/fonts/'.$font->thumb; ?>" alt="<?php echo $font->thumb; ?>">
				</a>
				<?php }else{ ?>
				<span style="font-family:'<?php echo $font->title; ?>'"><?php echo $font->title; ?></span>
				<?php } ?>
			</td>
			<td class="cate_font"><?php echo $font->catename; ?></td>
			<td class="center"><?php if ($font->published == 1) { ?>					   
					<a class="btn btn-success btn-xs tooltips action" data-original-title="<?php echo lang('click_publish');?>" data-placement="top" rel="unpublish" data-id="<?php echo $font->id; ?>" data-flag="1"><?php echo lang('publish'); ?></a>
				<?php } else { ?>
					<a class="btn btn-danger btn-xs tooltips action" data-original-title="<?php echo lang('click_publish');?>" data-placement="top" rel="publish" data-id="<?php echo $font->id; ?>" data-flag="0"><?php echo lang('unpublish'); ?></a>
				<?php } ?>
			</td>
			<td class="center">
				<div class="visible-md visible-lg hidden-sm hidden-xs">
					<a href="<?php echo site_url().'admin/settings/fonts/edit_fonts/'.$font->id;?>" class="btn btn-primary tooltips" data-original-title="<?php echo lang('edit');?>" data-placement="top">
						<i class="fa fa-edit"></i>
					</a>
					<a rel="del" class="remove btn btn-bricky tooltips action" data-placement="top" data-original-title="<?php echo lang('remove');?>" href="javascript:void(0);" data-id="<?php echo $font->id; ?>">
						<i class="fa fa-times"></i>
					</a>
				</div>
			</td>
		</tr>
		<?php } ?>    
	</tbody>
</table>
<?php if ($css != '') { ?>
<link href='http://fonts.googleapis.com/css?family=<?php echo $css; ?>' rel='stylesheet' type='text/css'>
<?php } ?>
<div class="row">
	<div class="dataTables_paginate paging_bootstrap" style="float: right;">
		<div class="col-md-12">
		<?php echo $links;?>
		</div>
   </div>
</div>
<input type="hidden" id="flag" name="action">
<input type="hidden" id="in_per_page" name="per_page">
<input type="hidden" id="in_search_cate" name="option_font">
<input type="hidden" id="in_font_search" name="search_font">
<?php echo form_close(); ?>  