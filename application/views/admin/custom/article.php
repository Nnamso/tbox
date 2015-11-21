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
<script src="<?php echo base_url('assets/plugins/validate/validate.js'); ?>"></script>

<script type="text/javascript">
    jQuery(document).on('click change', 'input[name="check_all"]', function() {
        var checkboxes = $(this).closest('table').find(':checkbox').not($(this));
        if ($(this).prop('checked')) {
            checkboxes.prop('checked', true);
        } else {
            checkboxes.prop('checked', false);
        }
    });
</script>
    <?php if($this->session->flashdata('msg') != ''){ ?> 
		<div class="alert alert-success">
			<button class="close" data-dismiss="alert"> × </button>
				<i class="fa fa-check-circle"></i>
			<?php echo $this->session->flashdata('msg');?>
		</div>
	<?php }?>
	<?php if($this->session->flashdata('error') != ''){ ?> 
		<div class="alert alert-danger">
			<button class="close" data-dismiss="alert"> × </button>
				<i class="fa fa fa-times"></i>
			<?php echo $this->session->flashdata('error');?>
		</div>
	<?php }?>
	<?php
		$attribute = array('class' => 'form-article', 'id' => 'panel-form');
		echo form_open(site_url().'admin/custom/article', $attribute);
	?>
	 <div class="row">
		<div class="col-md-6">
			<div class="row">
				<div class="col-md-2">
					<?php $option = array('all'=>lang('all'), '5'=>5, '10'=>10, '15'=>15, '20'=>20, '25'=>25, '100'=>100); ?>
					<?php echo form_dropdown('per_page', $option, $per_page, 'class="form-control option_perpage" id="per_page"'); ?>
				</div>
				<div class="col-md-4">
					<?php 
						$searchs = array('name' => 'search_article', 'id' => 'search_article', 'class' => 'form-control', 'placeholder' => lang('custom_search_article_place'), 'value'=>$search);
						echo form_input($searchs);
					?>
				</div>
				<div class="col-md-2">
					<button type="submit" class="btn btn-primary"><?php echo lang('search');?></button>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<p style="text-align:right;">
				<a class="btn btn-primary tooltips" href="<?php echo site_url()?>admin/custom/edit" title="<?php echo lang('add');?>">
					<i class="glyphicon glyphicon-plus"></i>
				</a>
				<a id="btn-publish" class="btn btn-green tooltips" href="javascript:void(0);" title="<?php echo lang('publish');?>">
					<i class="glyphicon glyphicon-ok-sign"></i>
				</a>
				<a id="btn-unpublish" class="btn btn-danger tooltips" href="javascript:void(0);" title="<?php echo lang('unpublish');?>">
					<i class="clip-radio-checked"></i>
				</a>
				<a id="btn-delete" class="btn btn-bricky tooltips" href="javascript:void(0);" title="<?php echo lang('delete'); ?>"> 
					<i class="fa fa-trash-o"></i>
				</a>
			</p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-external-link-square icon-external-link-sign"></i>
					<?php echo lang('custom_article_list'); ?>
				</div>
				<div class="panel-body modal-body">
					<div id="refresh">
						<table id="sample-table-1" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th style="width: 6%;" class="center">
										<div class="checkbox-table">
											<label>
												<input id="select_all" type="checkbox" name='check_all'>
											</label>
										</div>
									</th>
									<th class="center"><?php echo lang('custom_article_title'); ?></th>
									<th style="width: 15%;" class="center"><?php echo lang('custom_article_slug'); ?></th>
									<th style="width: 15%;" class="center"><?php echo lang('category'); ?></th>
									<th style="width: 10%;" class="center"><?php echo lang('image'); ?></th>
									<th style="width: 10%;" class="center"><?php echo lang('publish'); ?></th>
									<th style="width: 10%;" class="center"><?php echo lang('date'); ?></th>
									<th style="width: 10%;" class="center"><?php echo lang('action'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($articles as $article) { ?>
										<tr>
											<td class="center">
												<div class="checkbox-table">
													<label>
														<input type="checkbox" name="checkb[]" class="checkb" name="check" value="<?php echo $article->id; ?>">
													</label>
												</div>
											</td>
											<td><a href="<?php echo site_url()?>admin/custom/edit/<?php echo $article->id;?>"><?php echo $article->title; ?></a></td>
											<td><?php echo $article->slug;?></td>
											<td><?php 
													if(isset($article_categories[$article->cate_id]))
														echo $article_categories[$article->cate_id];
												?>
											</td>
											<td style="width: 10%;" class="center"><?php if($article->image != '') echo '<img src="'.base_url($article->image).'" style="height: 70px;"/>'; ?></td>
											<td class="center"><?php if ($article->publish == 1) { ?>					   
													<a class="btn btn-success btn-xs tooltips" title="<?php echo lang('click_unpublish');?>" href="<?php echo site_url().'admin/custom/unpublish/'.$article->id; ?>" data-placement="top"><?php echo lang('publish'); ?></a>
												<?php } else { ?>
													<a class="btn btn-danger btn-xs tooltips" title="<?php echo lang('click_publish');?>" href="<?php echo site_url().'admin/custom/publish/'.$article->id; ?>" data-placement="top"><?php echo lang('unpublish'); ?></a>
												<?php } ?>
											</td>
											<td class="center">
												<?php 
													$date = new DateTime($article->date);
													echo $date->format('Y-m-d'); 
												?>
											</td>
											<td class="center">
												<div class="visible-md visible-lg hidden-sm hidden-xs">
													<a href="<?php echo site_url().'admin/custom/edit/'.$article->id;?>" class="btn btn-primary tooltips" title="<?php echo lang('edit');?>" data-placement="top">
														<i class="fa fa-edit"></i>
													</a>
													<a class="remove btn btn-bricky tooltips" data-placement="top" data-original-title="<?php echo lang('remove');?>" href="<?php echo  site_url().'admin/custom/delete/'.$article->id; ?>" onclick="return confirm('<?php echo lang('custom_admin_confirm_delete_article_msg');?>')">
														<i class="fa fa-times"></i>
													</a>
												</div>
											</td>
										</tr>
									<?php } ?>    
							</tbody>
						</table>
						<div class="row">
							<div class="dataTables_paginate paging_bootstrap" style="float: right;">
								<div class="col-md-12">
								<?php echo $links;?>
								</div>
						   </div>
						</div>
					</div>
				</div>     
			</div>           
		</div>
	</div>
<?php echo form_close(); ?>  

<script type="text/javascript">
	jQuery('#per_page').change(function(){
		jQuery('#panel-form').submit();
	});
	
	jQuery('.tooltips').tooltip();
	
	jQuery('#btn-publish').click(function(){
		if(jQuery('.checkb').is(':checked')){
			jQuery('#panel-form').attr('action', '<?php echo site_url().'admin/custom/publish';?>').submit();
		}else{
			alert('<?php echo lang('custom_admin_checbox_error_msg');?>');
		}
	});
	
	jQuery('#btn-unpublish').click(function(){
		if(jQuery('.checkb').is(':checked')){
			jQuery('#panel-form').attr('action', '<?php echo site_url().'admin/custom/unpublish';?>').submit();
		}else{
			alert('<?php echo lang('custom_admin_checbox_error_msg');?>');
		}
	});
	
	jQuery('#btn-delete').click(function(){
		if(jQuery('.checkb').is(':checked')){
			var cf = confirm('<?php echo lang('custom_admin_confirm_delete_article_msg');?>');
			if(cf)
				jQuery('#panel-form').attr('action', '<?php echo site_url().'admin/custom/delete';?>').submit();
		}else{
			alert('<?php echo lang('custom_admin_checbox_error_msg');?>');
		}
	});
</script>