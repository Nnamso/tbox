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
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<link href="<?php echo base_url('assets/css/lightbox.css'); ?>" rel="stylesheet" type="text/css"/>

<?php echo $css = ''; ?>
<script type="text/javascript">
    jQuery(document).on('click change', 'input[name="check_all"]', function() {
        var checkboxes = $(this).closest('table').find(':checkbox').not($(this));
        if ($(this).prop('checked')) {
            checkboxes.prop('checked', true);
        } else {
            checkboxes.prop('checked', false);
        }
    });
    jQuery(document).ready(function() {
        dgUI.ajax.ini('fonts');
		
		jQuery("#per_page").change(function(){ 
			var per_page = jQuery('#per_page').val();
			var category = jQuery('#search_cate').val();
			var search = jQuery('#font_search').val();
			jQuery('#in_per_page').val(per_page);
			jQuery('#in_search_cate').val(category);
			jQuery('#in_font_search').val(search);
			dgUI.ajax.submit('#panel-form',true,load,update);
        });

        jQuery('form').submit(function() {
            return false;
        });

        jQuery(".txt_search").keyup(function(e){ 
			if(e.keyCode == 13)
			{
				var per_page = jQuery('#per_page').val();
				var category = jQuery('#search_cate').val();
				var search = jQuery('#font_search').val();
				jQuery('#in_per_page').val(per_page);
				jQuery('#in_search_cate').val(category);
				jQuery('#in_font_search').val(search);
				dgUI.ajax.submit('#panel-form',true,load,update);
			}
        });
    });
	
	function submit_fr_fonts()
	{ 
		var per_page = jQuery('#per_page').val();
		var category = jQuery('#search_cate').val();
		var search = jQuery('#font_search').val();
		jQuery('#in_per_page').val(per_page);
		jQuery('#in_search_cate').val(category);
		jQuery('#in_font_search').val(search);
		dgUI.ajax.submit('#panel-form',true,load,update);
	};
	
    var loadingImage = '<?php echo base_url('assets/images/loading.gif'); ?>'; 
    var closeButton = '<?php echo base_url('assets/images/close.gif'); ?>';
    var url = '<?php echo site_url(); ?>';
</script>
    <?php if($msg != ''){ ?> 
		<div class="alert alert-success">
			<button class="close" data-dismiss="alert"> × </button>
				<i class="fa fa-check-circle"></i>
			<?php echo $msg;?>
		</div>
	<?php }?>
	 <div class="row">
		<div class="col-md-6">
			<form>
				<div class="row">
					<div class="col-md-2">
						<?php $option = array('5'=>5, '10'=>10, '15'=>15, '20'=>20, '25'=>25, '100'=>100,'all'=>  lang('all'));
						if(!in_array($per_page, $option)){ $per_page = 'all';}?>
						<?php echo form_dropdown('per_page', $option, $per_page, 'class="form-control option_fonts" id="per_page"'); ?>
					</div>
					<div class="col-md-4">
						<?php 
							$search_font = array('name' => 'search_font', 'id' => 'font_search', 'class' => 'form-control txt_search', 'placeholder' => lang('fonts_search_place'), 'value'=>$this->session->userdata('search_font'));
							echo form_input($search_font);
						?>
					</div>
					<div class="col-md-4">
						<?php 
							$option_font[''] = lang('all');
							foreach ($list_cate as $cate){
								$option_font[$cate->id] = $cate->title;
							}
							echo form_dropdown('option_font', $option_font, $this->session->userdata('option_font'), 'class="form-control option_fonts" id="search_cate"'); 
						?>
					</div>
					<div class="col-md-2">
						<button class="btn btn-primary" type="button" onclick="submit_fr_fonts()"><?php echo lang('search');?></button>
					</div>
				</div>
			</form>
		</div>
		<div class="col-md-6">
			<p style="text-align:right;">
				<a class="btn btn-primary tooltips" href="<?php echo site_url()?>admin/settings/fontgoogle" data-placement="top" title="<?php echo lang('fonts_add_fonts_google_tooltips');?>">
					<i class="glyphicon glyphicon-plus"></i>
					<i class="fa fa-google"></i>
				</a>
				<a class="btn btn-primary tooltips" href="<?php echo site_url()?>admin/settings/fonts/add_fonts" data-placement="top" title="<?php echo lang('add');?>">
					<i class="glyphicon glyphicon-plus"></i>
				</a>
				<a class="btn btn-green action tooltips" href="javascript:void(0);" rel="publish-all" data-flag="0" data-placement="top" title="<?php echo lang('publish');?>">
					<i class="glyphicon glyphicon-ok-sign"></i>					
				</a>
				<a class="btn btn-danger action tooltips" href="javascript:void(0);" rel="unpublish-all" data-flag="1" data-placement="top" title="<?php echo lang('unpublish');?>">
					<i class="clip-radio-checked"></i>					
				</a>
				<a class="btn btn-bricky action tooltips" href="javascript:void(0);" rel="del-all" data-placement="top" title="<?php echo lang('delete');?>"> 
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
					<?php echo lang('fonts_list'); ?>
				</div>
				<?php echo validation_errors(); ?>
				<?php
				$attribute = array('class' => 'form-fonts', 'id' => 'panel-form');
				echo form_open('', $attribute);
				?>
				<div class="panel-body modal-body">
					<div id="refresh">
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
					</div>
				</div>     
			</div>           
		</div>
	</div>

<div id="ajax-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;"></div>
	
<script type="text/javascript">
	
	function changeCate(e)
	{
		var id = jQuery(e).attr('data-id');
		jQuery('#font-change-cate').val(id);
		
		var text = jQuery(e).parent('div').parent('td').parent('tr').children('.cate_font').text();
		if(text != 'Default')
			jQuery("select option").filter(function() {
				return jQuery(this).text() == text; 
			}).prop('selected', true);
		else
			jQuery("select option").filter(function() {
				return jQuery(this).val() == 0; 
			}).prop('selected', true);
	}
	
	function subCate()
	{
		var cate = jQuery('#list-cate-font').val();
		jQuery('#change-cate-font').val(cate);
		if(cate != '')
		{	
			dgUI.ajax.submit('#fr-change-cate', true, load, update);
		}else
		{
			alert('<?php echo lang('fonts_change_cate_error_msg');?>');
		}
	}
	
    function update() {
        jQuery('#panel-form,.modal-body').unblock();
        jQuery('.close').click();
        jQuery.post("<?php echo site_url()?>admin/settings/font", function(data) {
            document.getElementById('refresh').innerHTML = data;
            jQuery('.tooltips').tooltip();
            jQuery('#panel-form').attr('action', "<?php echo site_url()?>admin/settings/fonts");
			initLightbox();
        });
    }
    function load() {
        var pathArray = window.location.href.split('/');
        jQuery('#panel-form,.modal-body').block({
            overlayCSS: {
                backgroundColor: '#fff'
            },
            message: '<img src="<?php echo base_url()?>assets/images/loading.gif" /> <?php echo lang('load_text'); ?>',
            css: {
                border: 'none',
                color: '#333',
                background: 'none'
            }
        });
    }
    var conf = '<?php echo lang('fonts_delete_font_confirm'); ?>';
</script>