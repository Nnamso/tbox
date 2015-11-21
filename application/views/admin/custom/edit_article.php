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
<script src="<?php echo base_url('assets/plugins/tinymce/tinymce.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-fancybox/jquery.fancybox.css'); ?>">
<script src="<?php echo base_url('assets/plugins/validate/validate.js'); ?>"></script>

<script type="text/javascript">
var base_url = '<?php echo base_url(); ?>';
var url = '<?php echo base_url(); ?>';
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
			jQuery.fancybox( {href : base_url + 'admin/media/modals/descriptMedia/1', type: 'iframe'} );
        }
    }); 
});
tinymce.init({
    selector: ".text-edittor",
	menubar: false,
	toolbar_items_size: 'small',
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
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste dgmedia"
    ],
    toolbar: "code | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | dgmedia"
});
</script>
<?php if(isset($error)){?>
	<div class="alert alert-danger"><?php echo $error;?></div>
<?php } ?>

<?php echo validation_errors('<p class="alert alert-danger">'); ?>
<?php echo form_open(site_url().'admin/custom/edit/'.$id, 'id="fr-article" class="form-horizontal"'); ?>
<div class="row">
	<div class="col-sm-12">
		<p class="pull-right">
			<button class="btn btn-primary" type="submit"><?php echo lang('save');?></button>
			<a href="<?php echo site_url().'admin/custom/article'; ?>" class="btn btn-danger"><?php echo lang('close');?></a>
		</p>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-external-link-square icon-external-link-sign"></i><?php if($id != '') echo lang('custom_admin_article_edit_title'); else echo lang('custom_admin_article_add_title');?>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<div class="col-md-10">
							<label><?php echo lang('title'); ?><span class="symbol required"></span></label>
							<input type="text" name="data[title]" class="form-control validate required" data-msg="<?php echo lang('custom_admin_article_edit_validate_title');?>" data-minlength="2" data-maxlength="250" placeholder="<?php echo lang('custom_admin_edit_title_place'); ?>" value="<?php echo set_value('data[title]', $article->title); ?>" />
							<span class="help-block"><?php echo lang('custom_edit_category_title_note');?></span>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-10">
							<label><?php echo lang('slug'); ?></label>
							<input type="text" name="data[slug]" class="form-control" placeholder="<?php echo lang('custom_admin_edit_slug_place'); ?>" value="<?php echo set_value('data[slug]', $article->slug); ?>" />
							<span class="help-block"><?php echo lang('custom_edit_category_slug_note');?></span>
						</div>	
					</div>	
					
					<div class="form-group">
						<div class="col-sm-10">
							<label><?php echo lang('custom_admin_created_by_title'); ?></label>
							<input type="text" name="data[created]" class="form-control" placeholder="<?php echo lang('custom_admin_created_by_title'); ?>" value="<?php if(isset($data['created'])) echo $data['created']; else echo $article->created; ?>" />
						</div>	
					</div>	
					
					<div class="form-group">
						<div class="col-sm-4">
							<label><?php echo lang('categories'); ?></label>
							<?php 
								$cate_val = array(
									'0'=>set_value('data[cate_id]', $article->cate_id)
								);
								echo '<select class="form-control" name="data[cate_id]">';
								echo '<option value="">'.lang('custom_admin_article_select_categories').'</option>';
								echo dispayCateTree($categories, 0, $cate_val);
								echo '</select>';
							?>
						</div>
					</div>	
					
					<div class="form-group">
						<div class="col-md-4">
							<label><?php echo lang('published'); ?></label>
							<?php 
								if(isset($data['publish']))
									$publish = $data['publish'];
								else	
									$publish = $article->publish;
								$option = array('1'=>''.lang("publish").'', '0'=>''.lang("unpublish").'');
								echo form_dropdown('data[publish]', $option, $publish, 'class="form-control"'); 
							?>
						</div>	
					</div>

					<div class="form-group">
						<div class="col-md-10">
							<label><?php echo lang('add_image'); ?></label><br/>
							<?php 
								if(isset($data['image']))
								{
									echo '<div id="image-box-img-bg" class="pull-left" style="display:inline;">';
									echo '<img src="'.base_url($data['image']).'" class="pull-left box-image" style="width: 80px;" alt="image" />';
								}elseif($article->image != '')
								{
									echo '<div id="image-box-img-bg" class="pull-left" style="display:inline;">';
									echo '<img src="'.base_url($article->image).'" class="pull-left box-image" style="width: 80px;" alt="image" />';
								}else
								{
									echo '<div id="image-box-img-bg" class="pull-left" style="display:none;">';
								}
							?>
								<a href="javascript:void(0)" class="image-box-bg-remove" onclick="removeImg(this)"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
							</div>
							<input type="hidden" name="data[image]" id="image-box-img-view" value="<?php if(isset($data['image'])) echo $data['image']; else echo $article->image; ?>">
							<a class="image-box-image" href="javascript:void(0)" onclick="jQuery.fancybox( {href : '<?php echo site_url().'admin/media/modals/imageImg/1'; ?>', type: 'iframe'} );"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a>
						</div>
					</div>
				</div>	
				
				<div class="col-md-6">
					<div class="form-group">
						<div class="col-md-10">
							<label><?php echo lang('custom_admin_article_edit_meta_title'); ?></label>
							<textarea name="data[meta_title]" class="form-control" placeholder="<?php echo lang('custom_admin_edit_meta_title_place'); ?>" ><?php if(isset($data['meta_title'])) echo $data['meta_title']; else echo $article->meta_title; ?></textarea>
							<span class="help-block"><?php echo lang('custom_edit_category_meta_title_note');?></span>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-10">
							<label><?php echo lang('custom_admin_article_edit_meta_keyword'); ?></label>
							<textarea name="data[meta_keyword]" class="form-control" placeholder="<?php echo lang('custom_admin_edit_meta_keyword_place'); ?>" ><?php if(isset($data['meta_keyword'])) echo $data['meta_keyword']; else echo $article->meta_keyword; ?></textarea>
							<span class="help-block"><?php echo lang('custom_edit_category_meta_keyword_note');?></span>
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-10">
							<label><?php echo lang('custom_admin_article_edit_meta_des'); ?></label>
							<textarea name="data[meta_description]" class="form-control" placeholder="<?php echo lang('custom_admin_edit_meta_des_place'); ?>" ><?php if(isset($data['meta_description'])) echo $data['meta_description']; else echo $article->meta_description; ?></textarea>
							<span class="help-block"><?php echo lang('custom_edit_category_meta_description_note');?></span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="form-group">
				<div class="col-md-12">	
					<label><?php echo lang('custom_admin_edit_content'); ?></label>
					<textarea name="data[description]" class="text-edittor" rows="15" cols="40"><?php if(isset($data['description'])) echo $data['description']; else echo $article->description; ?></textarea>
					<span class="help-block"><?php echo lang('custom_edit_category_description_note');?></span>
				</div>
			</div>
		</div>
	</div>
</div>
			
<?php echo form_close();?>
<script type="text/javascript">
	jQuery('#fr-article').validate();
	
	jQuery('.btn-close').click(function(){
		window.location = "<?php echo site_url().'/admin/custom/article';?>";
	});
	
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
			str = str.replace("<?php echo site_url();?>", "");
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