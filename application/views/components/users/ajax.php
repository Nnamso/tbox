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
<?php 
	if(count($data) > 0)
	{
?>
	<div class="modal-header">
		<button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
		<h4 id="myModalLabel" class="modal-title"><?php echo lang('user_login_ajax_my_account'); ?></h4>
	</div>
	<div class="modal-body">
		<?php if(isset($msg) && $msg != ''){  ?>
			<div class="alert alert-success" style="margin: 0px;"><?php echo $msg; ?></div>
		<?php }  ?>
		<?php if(isset($error) && $error != ''){  ?>
			<div class="alert alert-danger" style="margin: 0px;"><?php echo $error; ?></div>
		<?php }  ?>
		<div class="row">
			<div class="col-sm-6">
				<ul class="login_info">
					<?php foreach($data as $key=>$val) {
						if($key == 'name')
						{
							echo '<li><strong>'.lang('hi').',</strong> '.$val.'</li>';
						}elseif($key == 'username')
						{
							echo '<li><strong>'.lang('username').':</strong> '.$val.'</li>';
						}elseif($key == 'email')
						{
							echo '<li><strong>'.lang('email').':</strong> '.$val.'</li>';
						}elseif($key == 'admin' && $val != 0)
						{
							echo '<li><strong>'.lang('admin').'</strong></li>';
						}elseif($key == 'id')
						{
							echo '<li><input type="hidden" id="user-id" value="'.$val.'"></li>';
						}
					} ?>
				</ul>
			</div>
			
			<div class="col-sm-6">
				<h4><?php lang('user_change_password'); ?></h4>
				<form id="fr-change-pass" style="margin-bottom: 5px;" role="form">
					<div class="form-group" style="display: table; width: 100%;">
						<label><?php echo lang('user_new_password'); ?></label>
						<input id="change-password" class="form-control input-sm validate required" type="password" placeholder="<?php echo lang('user_new_password'); ?>" data-minlength="6" data-maxlength="128" data-msg="<?php echo lang('user_change_password_validate_new_password'); ?>" name="data[password]">
					</div>
					
					<div class="form-group" style="display: table; width: 100%;">
						<label><?php echo lang('user_confirm_password'); ?></label>
						<input id="change-cfpassword" class="form-control input-sm validate required" type="password" placeholder="<?php echo lang('user_confirm_password'); ?>" data-minlength="6" data-maxlength="128" data-msg="<?php echo lang('user_change_password_validate_confirm_password'); ?>" name="cf_password">
					</div>
					<div class="form-group" style="display: table; width: 100%;">
						<button id="change-button" onclick="login('change_pass')" class="btn btn-default btn-primary" data-loading-text="Loading" type="button"><?php echo lang('save'); ?></button>
					</div>
					<?php echo $this->auth->getToken(); ?>
					<input class="ajax" type="hidden" name="ajax" value="1">
				</form>
			</div>
		</div>
	</div>

<?php }else{ ?>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title" id="myModalLabel"><?php echo $lang['designer_user_login_now_or_sign_up']; ?></h4>
	</div>

	<div class="modal-body">
		<?php if(isset($error)){  ?>
			<div class="alert alert-danger" style="margin: 0px;"><?php echo $error; ?></div>
		<?php }  ?>

		<div class="row">
			<!-- login form -->
			<div class="col-md-6">
				<h3><?php echo $lang['designer_user_login']; ?></h3>
				<form id="fr-login" role="form" style="margin-bottom: 5px;">						  						 
				  <div class="form-group">
					<label><?php echo $lang['designer_user_your_email']; ?>:</label>
					<input type="text" name="data[email]" id="login-email" class="form-control input-sm validate required" data-msg="<?php echo $lang['designer_user_email_validate_msg']; ?>" data-type="email" placeholder="<?php echo $lang['designer_user_your_email']; ?>">
				  </div>
				  <div class="form-group">
					<label><?php echo $lang['designer_user_your_password']; ?>:</label>
					<input type="password" name="data[password]" id="login-password" class="form-control input-sm validate required" data-msg="<?php echo $lang['designer_user_password_validate_msg']; ?>" data-maxlength="32" data-minlength="6" placeholder="<?php echo $lang['designer_user_your_password']; ?>">
				  </div>
				  <a href="javascript:void(0)" title="" class="btn btn-default btn-primary" onclick="facebook_login()">
					<span class="login-facebook"></span>
					<?php echo $lang['designer_user_login_with_facebook']; ?>
				  </a>
				  <button type="button" onclick="login(this)" autocomplete="off" class="btn btn-default btn-warning" data-loading-text="Loading"><?php echo $lang['designer_user_login_btn']; ?></button> 
				  <?php echo $this->auth->getToken(); ?>
				  <input type="hidden" name="ajax" value="1">
				</form>
				
				<a id="click_forgot" href="javascript:void(0)"><?php echo $lang['designer_user_i_forgot_password']; ?></a>
			</div>
			
			<!-- create account -->
			<div class="col-md-6">
				<h3><?php echo $lang['designer_user_create_account']; ?></h3>
				<form id="fr-register" role="form">						 
				  <div class="form-group">
					<label><?php echo $lang['designer_user_username']; ?>:</label>
					<input type="text" name="data[username]" id="create_username" class="form-control input-sm validate required" data-msg="<?php echo $lang['designer_user_username_validate_msg']; ?>" data-maxlength="200" data-minlength="2" placeholder="<?php echo $lang['designer_user_username']; ?>">
				  </div>
				  <div class="form-group">
					<label><?php echo $lang['designer_user_email_address']; ?>:</label>
					<input type="email" name="data[email]" class="form-control input-sm validate required" id="create_email" data-msg="<?php echo $lang['designer_user_email_validate_msg']; ?>" data-type="email" placeholder="<?php echo $lang['designer_user_enter_email']; ?>">
				  </div>
				  <div class="form-group">
					<label><?php echo $lang['designer_user_password']; ?>:</label>
					<input type="password" class="form-control input-sm validate required" name="data[password]" id="create_password" data-msg="<?php echo $lang['designer_user_password_validate_msg']; ?>" data-maxlength="32" data-minlength="6" placeholder="<?php echo $lang['designer_user_password']; ?>">
				  </div>						  						 
				  <button type="button" onclick="login('register')" autocomplete="off" data-loading-text="<?php echo $lang['designer_user_login']; ?>Loading" class="btn btn-default btn-primary"><?php echo $lang['designer_user_register_btn']; ?></button>
					<?php echo $this->auth->getToken(); ?>
					<input type="hidden" name="ajax" value="1">
				</form>
			</div>
		</div>
	</div>
<?php } ?>
