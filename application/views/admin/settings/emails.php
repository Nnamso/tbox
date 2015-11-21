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
<script type="text/javascript" src="<?php echo base_url('assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/plugins/tinymce/tinymce.min.js'); ?>"></script>
<style>
	iframe{
		height: 200px !important;
	}
</style>
<?php if(isset($msg) && $msg != ''){?>
	<div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $msg;?></div>
<?php } ?>
<?php if(isset($error) && $error != ''){?>
	<div class="alert alert-danger"><i class="fa fa-times-circle"></i> <?php echo $error;?></div>
<?php } ?>
<form method="post" action="<?php echo site_url(); ?>admin/settings/emails">
<ul class="nav nav-tabs">
  <li class="active"><a href="#register" data-toggle="tab"><?php echo lang('setting_email_tab_register'); ?></a></li>
  <li><a href="#change_pass" data-toggle="tab"><?php echo lang('setting_email_tab_change_pass'); ?></a></li>
  <li><a href="#forget_pass" data-toggle="tab"><?php echo lang('setting_email_tab_forget_pass'); ?></a></li>
  <li><a href="#save_design" data-toggle="tab"><?php echo lang('setting_email_tab_save_design'); ?></a></li>
  <!--<li><a href="#sell_design" data-toggle="tab"><?php echo lang('setting_email_tab_sell_design'); ?></a></li>-->
  <li><a href="#order_detai" data-toggle="tab"><?php echo lang('setting_email_tab_order_detail'); ?></a></li>
  <li><a href="#order_status" data-toggle="tab"><?php echo lang('setting_email_tab_order_status'); ?></a></li>
  <!--<li><a href="#email_ads" data-toggle="tab"><?php echo lang('setting_email_tab_email_ads'); ?></a></li>-->
  <li class="pull-right"><button type="submit" class="btn btn-primary"><?php echo lang('save'); ?></button></li>
</ul>

<!-- Tab panes --> 
<div class="tab-content">
	<!-- begin register -->
	<div class="tab-pane active" id="register">
		<div class="row">
			<div class="col-xs-4">
				<input style="margin-bottom: 10px;" class="form-control" type="text" name="message[sub_register]" value="<?php if(isset($email['sub_register']))echo $email['sub_register'];?>" placeholder="<?php echo lang('setting_email_subject');?>"/>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<textarea class="text-edittor" name="message[register]" aria-hidden="true"><?php if(isset($email['register']))echo $email['register'];?></textarea>
			</div>
			<div class="col-xs-6">
				<span><?php echo lang('setting_email_short_code');?></span>
				<ul>
					<li><code>{username}</code> <?php echo lang('setting_email_username');?></li>
					<li><code>{email}</code> <?php echo lang('setting_email_email_address');?></li>
					<li><code>{password}</code> <?php echo lang('setting_email_password');?></li>
					<li><code>{date}</code> <?php echo lang('setting_email_register_date');?></li>
					<li><code>{confirm_url}</code> <?php echo lang('setting_email_confirm_url');?></li>
				</ul>
				<span><?php echo lang('eg'); ?></span>
				<p><?php echo lang('hi'); ?>, <code>{username}</code>. Please &lt;a target="_blank" href="<code>{confirm_url}</code>"&gt;Click here&lt;/a&gt; to confirm account!</p>
			</div>
		</div>
	</div>
	<!-- end register -->
	
	<!-- start change_pass -->
	<div class="tab-pane" id="change_pass">
		<div class="row">
			<div class="col-xs-4">
				<input style="margin-bottom: 10px;" class="form-control" type="text" name="message[sub_change_pass]" value="<?php if(isset($email['sub_change_pass']))echo $email['sub_change_pass'];?>" placeholder="<?php echo lang('setting_email_subject');?>"/>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<textarea class="text-edittor" name="message[change_pass]" aria-hidden="true"><?php if(isset($email['change_pass']))echo $email['change_pass'];?></textarea>
			</div>
			<div class="col-xs-6">
				<span><?php echo lang('setting_email_short_code');?></span>
				<ul>
					<li><code>{username}</code> <?php echo lang('setting_email_username');?></li>
					<li><code>{email}</code> <?php echo lang('setting_email_email_address');?></li>
					<li><code>{password}</code> <?php echo lang('setting_email_password');?></li>
					<li><code>{date}</code> <?php echo lang('setting_email_register_date');?></li>
				</ul>
				<span><?php echo lang('eg'); ?></span>
				<p>Hi, <code>{username}</code>. Please have change password!</p>
			</div>
		</div>
	</div>
	<!-- end change_pass -->
	
	<!-- start forget_pass -->
	<div class="tab-pane" id="forget_pass">
		<div class="row">
			<div class="col-xs-4">
				<input style="margin-bottom: 10px;" class="form-control" type="text" name="message[sub_forget_pass]" value="<?php if(isset($email['sub_forget_pass']))echo $email['sub_forget_pass'];?>" placeholder="<?php echo lang('setting_email_subject');?>"/>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<textarea class="text-edittor" name="message[forget_pass]" aria-hidden="true"><?php if(isset($email['forget_pass']))echo $email['forget_pass'];?></textarea>
			</div>
			<div class="col-xs-6">
				<span><?php echo lang('setting_email_short_code');?></span>
				<ul>
					<li><code>{username}</code> <?php echo lang('setting_email_username');?></li>
					<li><code>{email}</code> <?php echo lang('setting_email_email_address');?></li>
					<li><code>{confirm_url}</code> <?php echo lang('setting_email_confirm_url');?></li>
					<li><code>{date}</code> <?php echo lang('setting_email_register_date');?></li>
				</ul>
				<span><?php echo lang('eg'); ?></span>
				<p>Please &lt;a target="_blank" href="<code>{confirm_url}</code>"&gt;Click here&lt;/a&gt; to change your password!</p>
			</div>
		</div>
	</div>
	<!-- end forget_pass -->
	
	<!-- start save_design -->
	<div class="tab-pane" id="save_design">
		<div class="row">
			<div class="col-xs-4">
				<input style="margin-bottom: 10px;" class="form-control" type="text" name="message[sub_save_design]" value="<?php if(isset($email['sub_save_design']))echo $email['sub_save_design'];?>" placeholder="<?php echo lang('setting_email_subject');?>"/>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<textarea class="text-edittor" name="message[save_design]" aria-hidden="true"><?php if(isset($email['save_design']))echo $email['save_design'];?></textarea>
			</div>
			<div class="col-xs-6">
				<span><?php echo lang('setting_email_short_code');?></span>
				<ul>
					<li><code>{username}</code> <?php echo lang('setting_email_username');?></li>
					<li><code>{url_design}</code> <?php echo lang('setting_url_design');?></li>
				</ul>
				<span><?php echo lang('eg'); ?></span>
				<p><?php echo lang('hi'); ?>, <code>{username}</code></p>
			</div>
		</div>
	</div>
	<!-- end save_design -->
	
	<!-- start sell_design -->
	<!--
	<div class="tab-pane" id="sell_design">
		<div class="row">
			<div class="col-xs-4">
				<input style="margin-bottom: 10px;" class="form-control" type="text" name="message[sub_sell_design]" value="<?php if(isset($email['sub_sell_design']))echo $email['sub_sell_design'];?>" placeholder="<?php echo lang('setting_email_subject');?>"/>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<textarea class="text-edittor" name="message[sell_design]" aria-hidden="true"><?php if(isset($email['sell_design']))echo $email['sell_design'];?></textarea>
			</div>
			<div class="col-xs-6">
				<span><?php echo lang('setting_email_short_code');?></span>
				<ul>
					<li><code>{username}</code> <?php echo lang('setting_email_username');?></li>
					<li><code>{email}</code> <?php echo lang('setting_email_email_address');?></li>
					<li><code>{password}</code> <?php echo lang('setting_email_password');?></li>
					<li><code>{date}</code> <?php echo lang('setting_email_register_date');?></li>
					<li><code>{shop}</code> <?php echo lang('setting_email_shop_name');?></li>
					<li><code>{shop_url}</code> <?php echo lang('setting_email_shop_url');?></li>
				</ul>
				<span><?php echo lang('eg'); ?></span>
				<p><?php echo lang('hi'); ?>, <code>{username}</code><?php echo lang('setting_email_thank_you_for_register_msg');?></p>
			</div>
		</div>
	</div>
	-->
	<!-- end sell_design -->
	
	<!-- start order_detai -->
	<div class="tab-pane" id="order_detai">
		<div class="row">
			<div class="col-xs-4">
				<input style="margin-bottom: 10px;" class="form-control" type="text" name="message[sub_order_detai]" value="<?php if(isset($email['sub_order_detai']))echo $email['sub_order_detai'];?>" placeholder="<?php echo lang('setting_email_subject');?>"/>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<textarea class="text-edittor" name="message[order_detai]" aria-hidden="true"><?php if(isset($email['order_detai']))echo $email['order_detai'];?></textarea>
			</div>
			<div class="col-xs-6">
				<span><?php echo lang('setting_email_short_code');?></span>
				<ul>
					<li><code>{username}</code> <?php echo lang('setting_email_username');?></li>
					<li><code>{date}</code> <?php echo lang('setting_email_order_date');?></li>
					<li><code>{total}</code> <?php echo lang('setting_email_total');?></li>
					<li><code>{order_number}</code> <?php echo lang('setting_email_order_number');?></li>
					<li><code>{table}</code> <?php echo lang('setting_email_table');?></li>
				</ul>
				<span><?php echo lang('eg'); ?></span>
				<p><?php echo lang('hi'); ?>, <code>{username}</code><?php echo lang('setting_email_thank_you_for_payment_msg');?></p>
			</div>
		</div>
	</div>
	<!-- end order_detai -->
	
	<!-- start order_status -->
	<div class="tab-pane" id="order_status">
		<div class="row">
			<div class="col-xs-4">
				<input style="margin-bottom: 10px;" class="form-control" type="text" name="message[sub_order_status]" value="<?php if(isset($email['sub_order_status']))echo $email['sub_order_status'];?>" placeholder="<?php echo lang('setting_email_subject');?>"/>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<textarea class="text-edittor" name="message[order_status]" aria-hidden="true"><?php if(isset($email['order_status']))echo $email['order_status'];?></textarea>
			</div>
			<div class="col-xs-6">
				<span><?php echo lang('setting_email_short_code');?></span>
				<ul>
					<li><code>{username}</code> <?php echo lang('setting_email_username');?></li>
					<li><code>{email}</code> <?php echo lang('setting_email_email_address');?></li>
					<li><code>{date}</code> <?php echo lang('setting_email_status_date');?></li>
					<li><code>{total}</code> <?php echo lang('setting_email_total');?></li>
					<li><code>{order_number}</code> <?php echo lang('setting_email_order_number');?></li>
					<li><code>{status}</code> <?php echo lang('setting_email_status');?></li>
				</ul>
				<span><?php echo lang('eg'); ?></span>
				<p><?php echo lang('hi'); ?>, <code>{username}</code></p>
			</div>
		</div>
	</div>
	<!-- end order_status -->
	
	<!-- start email_ads -->
	<!--
	<div class="tab-pane" id="email_ads">
		<div class="row">
			<div class="col-xs-4">
				<input style="margin-bottom: 10px;" class="form-control" type="text" name="message[sub_email_ads]" value="<?php if(isset($email['sub_email_ads']))echo $email['sub_email_ads'];?>" placeholder="<?php echo lang('setting_email_subject');?>"/>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6">
				<textarea class="text-edittor" name="message[email_ads]" aria-hidden="true"><?php if(isset($email['email_ads']))echo $email['email_ads'];?></textarea>
			</div>
			<div class="col-xs-6">
				<span><?php echo lang('setting_email_short_code');?></span>
				<ul>
					<li><code>{username}</code> <?php echo lang('setting_email_username');?></li>
					<li><code>{email}</code> <?php echo lang('setting_email_email_address');?></li>
					<li><code>{password}</code> <?php echo lang('setting_email_password');?></li>
					<li><code>{date}</code> <?php echo lang('setting_email_register_date');?></li>
					<li><code>{shop}</code> <?php echo lang('setting_email_shop_name');?></li>
					<li><code>{shop_url}</code> <?php echo lang('setting_email_shop_url');?></li>
				</ul>
				<span><?php echo lang('eg'); ?></span>
				<p><?php echo lang('hi'); ?>, <code>{username}</code><?php echo lang('setting_email_thank_you_for_register_msg');?></p>
			</div>
		</div>
	</div>
	-->
	<!-- end email_ads -->
	
</div>
</form>
<script type="text/javascript">
	
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
    toolbar: "code | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent"
});

</script>