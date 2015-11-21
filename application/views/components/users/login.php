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
<script src="<?php echo site_url();?>assets/plugins/validate/validate.js"></script>	

<form id="fr-login" method="POST" action="<?php echo site_url().'users/login';?>" class="horizontal">
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<h2><?php echo lang('user_login_title');?></h2>
				<span><?php echo lang('user_login_already_a_member');?></span>
			</div>
			<?php if($this->session->flashdata('msg') != ''){  ?>
				<div class="alert alert-success"><?php echo $this->session->flashdata('msg'); ?></div>
			<?php }  ?>

			<?php if($this->session->flashdata('error') != ''){  ?>
				<div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
			<?php }  ?>
			<div class="form-group">
				<label><?php echo lang('user_email_label');?></label>
				<?php $data_fields = $this->session->flashdata('data_fields'); ?>
				<input class="form-control validate required" type="text" data-msg="<?php echo lang('user_validate_email');?>" data-type="email" placeholder="<?php echo lang('user_email_place');?>" name="data[email]" value="<?php if(isset($data_fields['email'])) echo $data_fields['email'];?>"/>
			</div>
			
			<div class="form-group">
				<label><?php echo lang('user_password_label');?></label>
				<input class="form-control validate required" type="password" data-msg="<?php echo lang('user_validate_password');?>" data-maxlength="128" data-minlength="6" placeholder="<?php echo lang('user_password_place');?>" name="data[password]" />
			</div>
			
			<div class="form-group">					
				<a href="<?php echo site_url('user/forgotpassword'); ?>" title=""><?php echo lang('user_login_forget_password_title');?></a> <span style="color: #428bca;">|</span> <a href="<?php echo site_url('user/register'); ?>" title=""><?php echo lang('user_login_create_acount_title');?></a>
			</div>
			<?php echo $this->auth->getToken(); ?>
			<div class="form-group">					
				<button class="btn btn-primary" type="submit"><?php echo lang('login'); ?></button>
			</div>
		</div>
		
		<div class="col-sm-6">
			<div class="form-group">
				<h2><?php echo lang('user_login_join_facebook'); ?></h2>
				<span><?php echo lang('user_login_facebook_title'); ?></span>
			</div>
			
			<div class="form-group">
				<a class="btn btn-facebook" title="<?php echo lang('login_with_facebook'); ?>" onclick="login_facebook();" href="javascript:void(0);">
					<i class="fa fa-facebook"></i>
					| <?php echo lang('login_with_facebook'); ?>
				</a>
			</div>
		</div>
	</div>
</form>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
	<?php $settings = getSettings(); ?>
	window.fbAsyncInit = function() {
		FB.init({
		  appId      : '<?php if(isset($settings->app_id))echo $settings->app_id;?>', // App ID
		  status     : true, // check login status
		  cookie     : true, // enable cookies to allow the server to access the session
		  xfbml      : true  // parse XFBML
		});
	}
	
	function login_facebook()
	{
		FB.login(function(response) {
		   if (response.authResponse) 
		   {
				FB.api('/me', function(response) {
					var email = response.email;
					if(email != '')
					{
						window.location.replace('<?php echo site_url('users/login'); ?>');
					}
				});
			} else 
			{
			 console.log('User cancelled login or did not fully authorize.');
			}
		},{scope: 'email,user_photos'});
	}
	  
	jQuery('#fr-login').validate();
</script>
