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
<script src="<?php echo base_url('assets/plugins/validate/validate.js'); ?>" type="text/javascript"></script>
<?php echo $css; ?>

<?php 
	echo '<h3>'.$contact->title.'</h3>';
?>

<?php if(isset($msg) && $msg != '') echo '<div class="alert alert-success">'.$msg.'</div>'; ?>
<?php if(isset($error) && $error != '') echo '<div class="alert alert-danger">'.$error.'</div>'; ?>

<form id="fr-contact" action="<?php echo site_url().uri_string(); ?>" method="POST">
	
	<div class="form-group">
		<div class="row">
			<div class="col-sm-6">
				<label><?php echo lang('contact_name_title');?></label>
				<input type="text" name="name" class="form-control" placeholder="<?php echo lang('contact_name_place');?>" value="<?php if(isset($data['name'])) echo $data['name']; ?>"/>
			</div>
			
			<div class="col-sm-6">
				<label><?php echo lang('contact_email_title');?></label>
				<input type="text" name="email" class="form-control required validate" value="<?php if(isset($data['email'])) echo $data['email']; ?>" data-type="email" data-msg="<?php echo lang('contact_admin_setting_your_email_validate');?>" placeholder="<?php echo lang('contact_email_place');?>"/>
			</div>
		</div>
	</div>
	
	<div class="form-group">
		<div class="row">
			<div class="col-sm-12">
				<label><?php echo lang('contact_subject_title');?></label>
				<input type="text" name="subject" class="form-control required validate" value="<?php if(isset($data['subject'])) echo $data['subject']; ?>" data-minlength="2" data-maxlength="200" data-msg="<?php echo lang('contact_admin_setting_subject_validate');?>"  placeholder="<?php echo lang('contact_subject_place');?>"/>
			</div>
		</div>
	</div>
	
	<?php 
		if(count($forms) > 0)
		{
		foreach($forms as $form)
		{ 
	?>
			
		<div class="form-group">
			<div class="row">
				<div class="col-md-12">
				<?php 
					if($form->title != '') echo '<label>'.$form->title.'</label>';
					$params = json_decode($form->params);
					if(isset($data['fields'][$form->name])) 
						$field_vl = $data['fields'][$form->name];
					else
						$field_vl = $form->value;
						
					if($form->type == 'text')
					{
						if($form->validate == 1)
							echo '<input class="form-control validate required" type="text" name="fields['.$form->name.']" placeholder="'.$form->title.'" data-minlength="2" data-maxlength="200" data-msg="'.$form->title.' must be at least 2 to 200 characters." value="'.$field_vl.'">';
						else
							echo '<input class="form-control" type="text" name="fields['.$form->name.']" value="'.$field_vl.'" placeholder="'.$form->title.'">';
					}else if($form->type == 'email')
					{
						if($form->validate == 1)
							echo '<input class="form-control validate required" type="text" name="fields['.$form->name.']" placeholder="'.$form->title.'" data-type="email" data-msg="Email format is incorrect">';
						else
							echo '<input class="form-control" type="text" name="fields['.$form->name.']" placeholder="'.$form->title.'">';
					}else if($form->type == 'password')
					{
						if($form->validate == 1)
							echo '<input class="form-control validate required" type="password" name="fields['.$form->name.']" placeholder="'.$form->title.'" data-minlength="2" data-maxlength="32" data-msg="'.$form->title.' must be at least 2 to 32 characters.">';
						else
							echo '<input class="form-control" type="password" name="fields['.$form->name.']" placeholder="'.$form->title.'">';
					}else if($form->type == 'radio')
					{
							$value = json_decode($form->value, true);
							if(is_array($value))
							{
								foreach($value as $key=>$val)
								{
									echo '<input id="'.str_replace(" ", "", $key).'" type="radio" name="fields['.$form->name.']" value="'.$val.'">';
									echo '<label for="'.str_replace(" ", "", $key).'" ></label>';
								}
							}
					}
				?>
				</div>
			</div>
		</div>
		
	<?php } } ?>
	
	<div class="form-group">
		<label><?php echo lang('contact_message_title');?></label>
		<textarea name="message" class="form-control" rows="8" ><?php if(isset($data['message'])) echo $data['message']; ?></textarea>
	</div>
	
	<div class="form-group">
		<button class="btn btn-primary" type="submit"><?php echo lang('send');?></button>
	</div>
</form>
<script type="text/javascript">
	jQuery('#fr-contact').validate();
</script>