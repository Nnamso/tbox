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
<div class="module-login">
<?php
	echo '<script type="text/javascript">var login_url_post = "'.site_url().'login/index/'.$login->id.'"</script>';
	echo $css;
	$user = $this->session->userdata('user');
	if(isset($user['id']) && $user['id'] != '')
	{
		echo '<div class="dropdown">
				<a id="user_info" class="dropdown-toggle" aria-expanded="false" role="button" aria-haspopup="true" data-toggle="dropdown" href="javascript:void(0);"><i class="glyphicon glyphicon-user"></i> '.lang('login_admin_setting_my_account_title').' <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="user_info">					
					<li><a href="'.site_url().'user/changepass" title="'.lang('login_admin_setting_change_pass_title').'">'.lang('login_admin_setting_change_pass_title').'</a></li>
					<li><a href="'.site_url().'users/logout" title="'.lang('login_admin_setting_logout_title').'">'.lang('login_admin_setting_logout_title').'</a></li>
				</ul>
			</div>';
	}
	else
	{
		echo '<div class="dropdown">
				<a id="user_info" class="dropdown-toggle" aria-expanded="false" role="button" aria-haspopup="true" data-toggle="dropdown" href="javascript:void(0);"><i class="glyphicon glyphicon-user"></i> '.lang('login_admin_setting_login_account_title').' <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu" aria-labelledby="user_info">
					<li><a href="'.site_url().'user/login" title="'.lang('login_admin_setting_login_title').'">'.lang('login_admin_setting_login_title').'</a></li>
					<li><a href="'.site_url().'user/register" title="'.lang('login_admin_setting_register_title').'">'.lang('login_admin_setting_register_title').'</a></li>
					<li><a href="'.site_url().'user/forgotpassword" title="'.lang('login_admin_setting_forgot_password_title').'">'.lang('login_admin_setting_forgot_password_title').'</a></li>
				</ul>
			</div>';
	}
?>
</div>
