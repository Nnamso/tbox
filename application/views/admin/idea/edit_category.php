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
<script src="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('assets/plugins/tinymce/tinymce.min.js'); ?>"></script>
<script type="text/javascript">
var base_url = '<?php echo site_url();?>';
var url = '<?php echo site_url();?>';
var areaZoom = 10;
function descriptMedia(images){
	if(images.length > 0)
	{
		var html = '';
		for(i=0; i<images.length; i++)
		{
			html = html + '<img src="'+images[i]+'" alt="" />';
		}
		tinymce.activeEditor.execCommand('mceInsertContent', false, html);
		jQuery.fancybox.close();
	}
}
tinymce.PluginManager.add('dgmedia', function(editor, url) {
    // Add a button that opens a window
    editor.addButton('dgmedia', {
        text: 'Add images',
        icon: false,
        onclick: function() {
			jQuery.fancybox( {href : base_url + 'admin/media/modals/descriptMedia/2', type: 'iframe'} );
        }
    }); 
});

tinymce.init({
    selector: ".text-edittor",
	menubar: false,
	convert_urls: false,
	statusbar: false,
	setup: function(editor) {
		editor.addButton('mybutton', {
			text: 'My button',
			icon: false,
			onclick: function() {
				editor.insertContent('Main button');
			}
		});
	},
	height : 200,
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste dgmedia"
    ],
    toolbar: "code | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | dgmedia"
});
</script>
<link href="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.css'); ?>" rel="stylesheet"/>
    <?php
    $attribute = array('class' => 'fr-category form-horizontal', 'id' => 'fr-category');
    echo form_open(site_url('admin/idea/editcategory/'.$id), $attribute);
    ?>
	 <?php if (isset($error)) { ?> 
		<div class="alert alert-danger">
			<button class="close" data-dismiss="alert"> × </button>
			<i class="fa fa-times-circle"></i>
			<?php echo $error; ?>
		</div>
	<?php } ?>
	<?php echo validation_errors('<p class="alert alert-danger">'); ?>
	<div class="row">
		<div class="col-sm-12">
			<p class="pull-right">
				<button type="submit" class="btn btn-primary"><?php echo lang('save'); ?></button>
				<a class="btn btn-danger" href="<?php echo site_url('admin/idea/categories'); ?>"><?php echo lang('close'); ?></a>
			</p>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-external-link-square icon-external-link-sign"></i>
			<?php if($id == '') echo lang('idea_admin_categories_add_title'); else echo lang('idea_admin_categories_edit_title');?>		   
		</div>
		<div class="modal-body">	
		
			<div class="row">
				<div class="col-sm-6">
					<h4><?php echo lang('idea_admin_categories_category_info_title'); ?></h4>
					<hr/>
					<div class="form-group">
						<div class="col-sm-10">
							<label>
								<?php echo lang('title'); ?><span class="symbol required"></span>
							</label>
							<input type="text" class="form-control validate required" name="data[title]" data-minlength="2" data-maxlength="200" data-msg="<?php echo lang('idea_admin_categories_edit_category_validate_title_msg');?>" placeholder="<?php echo lang('idea_admin_categories_edit_category_title_place');?>" value="<?php echo set_value('data[title]', $category->title); ?>"/>
							<small><i style="color: #858585;"><?php echo lang('idea_admin_categories_edit_category_title_help');?></i></small>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-10">
							<label>
								<?php echo lang('slug'); ?></span>
							</label>
							<input type="text" class="form-control" name="data[slug]" placeholder="<?php echo lang('idea_admin_categories_edit_category_slug_place');?>" value="<?php echo set_value('data[slug]', $category->slug); ?>"/>
							<small><i style="color: #858585;"><?php echo lang('idea_admin_categories_edit_category_slug_help');?></i></small>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-4">
							<label><?php echo lang('publish'); ?></label>
							<?php 
								$publish = array(
									'1'=>lang('publish'),
									'0'=>lang('unpublish'),
								);
								echo form_dropdown('data[published]', $publish,  set_value('data[published]', $category->published), 'class="form-control"');
							?>
						</div>
					</div>
				
					<div class="form-group">
						<div class="col-sm-4">
							<label><?php echo lang('idea_admin_categories_edit_category_parent_category'); ?></label>
							<?php 
								$cate_val = array(
									'0'=>set_value('data[parent_id]', $category->parent_id)
								);
								echo '<select class="form-control" name="data[parent_id]">';
								echo '<option value="0">'.lang('root').'</option>';
								if($category->id != '')
									echo dispayCateTree($categories, 0, $cate_val, $category->id);
								else
									echo dispayCateTree($categories, 0, $cate_val);
								echo '</select>';
							?>
						</div>
					</div>
				
					<div class="form-group" style="display: none;">
						<div class="col-sm-4">
							<label><?php echo lang('language'); ?></label>
							<?php 
								$lang = array(
									'en'=>'English',
									'vn'=>'Vietname',
								);
								echo form_dropdown('data[language]', $lang, 'en', 'class="form-control"');
							?>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-4">
							<label><?php echo lang('add_image'); ?></label><br/>
							<?php 
								if(isset($data['image']))
								{
									echo '<div id="image-box-img-bg" class="pull-left" style="display:inline;">';
									echo '<img src="'.base_url($data['image']).'" class="pull-left box-image" style="width: 80px;" alt="image" />';
								}elseif($category->image != '')
								{
									echo '<div id="image-box-img-bg" class="pull-left" style="display:inline;">';
									echo '<img src="'.base_url($category->image).'" class="pull-left box-image" style="width: 80px;" alt="image" />';
								}else
								{
									echo '<div id="image-box-img-bg" class="pull-left" style="display:none;">';
								}
							?>
								<a href="javascript:void(0)" class="image-box-bg-remove" onclick="removeImg(this)"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
							</div>
							<input type="hidden" name="data[image]" id="image-box-img-view" value="<?php if(isset($data['image'])) echo $data['image']; else echo $category->image; ?>">
							<a class="image-box-image" href="javascript:void(0)" onclick="jQuery.fancybox( {href : '<?php echo site_url('admin/media/modals/imageImg/1'); ?>', type: 'iframe'} );"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
						</div>
					</div>
				</div>
				
				<div class="col-sm-6">
					<h4><?php echo lang('idea_admin_categories_edit_category_meta_info'); ?></h4>
					<hr/>
					<div class="form-group">
						<div class="col-sm-11">	
							<label><?php echo lang('idea_admin_categories_edit_category_meta_title'); ?></label>
							<textarea class="form-control" name="data[meta_title]" placeholder="<?php echo lang('idea_admin_categories_edit_category_meta_title_place');?>" ><?php if(isset($data['image'])) echo $data['meta_title']; else echo $category->meta_title; ?></textarea>
							<small><i style="color: #858585;"><?php echo lang('idea_admin_categories_edit_category_meta_title_help');?></i></small>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-11">	
							<label><?php echo lang('idea_admin_categories_edit_category_meta_keyword'); ?></label>
							<textarea class="form-control" name="data[meta_keyword]" placeholder="<?php echo lang('idea_admin_categories_edit_category_meta_keyword_place');?>" ><?php if(isset($data['image'])) echo $data['meta_keyword']; else echo $category->meta_keyword; ?></textarea>
							<small><i style="color: #858585;"><?php echo lang('idea_admin_categories_edit_category_meta_keyword_help');?></i></small>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-11">	
							<label><?php echo lang('idea_admin_categories_edit_category_meta_description'); ?></label>
							<textarea class="form-control" name="data[meta_description]" placeholder="<?php echo lang('idea_admin_categories_edit_category_meta_description_place');?>" ><?php if(isset($data['image'])) echo $data['meta_description']; else echo $category->meta_description; ?></textarea>
							<small><i style="color: #858585;"><?php echo lang('idea_admin_categories_edit_category_meta_description_help');?></i></small>
						</div>
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-12">
					<label><?php echo lang('description'); ?></label>
					<textarea id="message" class="text-edittor" name="data[description]" rows="5" aria-hidden="true"><?php echo set_value('data[description]', $category->description); ?></textarea>
					<small><i style="color: #858585;"><?php echo lang('idea_admin_categories_edit_category_description_help');?></i></small>
				</div>
			</div>
		</div>
	</div>
	<?php echo form_close(); ?>
<script type="text/javascript">
	jQuery('#fr-category').validate();
	function productImg(images)
	{
		if(images.length > 0)
		{
			var e = jQuery('#products_image');			
			if(e.children('img').length > 0)
				e.children('img').attr('src', images[0]);
			else
				e.append('<img src="'+images[0]+'" class="pull-right" alt="background" style="width:80px;" width="80px" />');
			
			var str = images[0];
			str = str.replace("<?php echo base_url();?>", "");
			jQuery('#cate-image-path').val(str);
			jQuery.fancybox.close();
		}
	}
	
	function imageImg(images)
	{
		if(images.length > 0)
		{
			var e = jQuery('#image-box-img-bg');			
			if(e.children('img').length > 0)
				e.children('img').attr('src', images[0]);
			else
				e.append('<img src="'+images[0]+'" class="pull-left box-image" style="width: 80px;" alt="" width="100" />');
			e.css('display', 'inline');
			var str = images[0];
			str = str.replace("<?php echo base_url();?>", "");
			jQuery('#image-box-img-view').val(str);
			jQuery.fancybox.close();
		}
	}

	function removeImg(e){
		var e = jQuery('#image-box-img-bg');
		e.children('img').remove();
		e.css('display', 'none');
		jQuery('#image-box-img-view').val('');
	}
</script>