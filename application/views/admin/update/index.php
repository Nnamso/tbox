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
<div class="update_tool">
	<div class="col-sm-12">
		<?php if($this->session->flashdata('error') != ''){ ?>
			<div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
		<?php } ?>
		<?php if($this->session->flashdata('msg') != ''){ ?>
			<div class="alert alert-success"><?php echo $this->session->flashdata('msg'); ?></div>
		<?php } ?>
		<?php 
			$this->load->config('version');
			$version = $this->config->item('version');
			$version_active = $version;
			$active = str_replace('.', '', $version_active);
		?>
		<div class="row">
			<div class="col-sm-12">
				<h3 style="text-align: center;"><?php echo $this->lang->line('admin_update_tool_title');?> <br/><small>(<?php echo $this->lang->line('admin_use_using_version').$version_active;?>)</small></h3>
			</div>
		</div>
		
		<div id="accordion">
			
			<?php foreach($update as $data){ ?>
				<h3 style="background:#fcfcfc;font-weight: bold;overflow:hidden;line-height:26px;">Version <?php echo $data->version; ?> <small style="font-size: 11px;">(<?php echo $data->date; ?>)</small>
					<?php
						$version = str_replace('.', '', $data->version);
						$file 	= str_replace('.zip', '', $data->file);
						if ($version > $active) {
							$last_version = $data;
					?>
					<a href="javascript:void(0);" onclick="updateTool('<?php echo site_url().'admin/update/tool/'.$file?>', 'update')" style="color:#fff; margin-left: 6px;" class="btn btn-primary pull-right btn-sm"><?php echo $this->lang->line('admin_update');?></a> 
					<?php } ?>
					 <a target="_blank" href="javascript:void(0);" onclick="updateTool('http://updates.tshirtecommerce.com/<?php echo $data->file; ?>', 'download')" class="btn btn-default pull-right btn-sm"><?php echo $this->lang->line('admin_download');?></a>
				</h3>
				<iframe src="http://updates.tshirtecommerce.com/<?php echo $data->info; ?>" width="100%" height="100%" marginheight="0" frameborder="0" style="background: #fff;padding:0px;"></iframe>
			<?php } ?>
		</div>
		
		<div class="row" style="margin-top: 10px; text-align: center;">
			<div class="col-sm-12">
				<?php if(isset($last_version)){ $file 	= str_replace('.zip', '', $last_version->file); ?>					
					<a href="<?php echo site_url().'admin/update/tool/'.$file?>" class="btn btn-primary btn-sm" style="font-weight: bold;"><?php echo $this->lang->line('admin_update_last_version_title');?></a>					
					 <a target="_blank" href="http://updates.tshirtecommerce.com/<?php echo $last_version->file; ?>" class="btn btn-primary btn-sm" style="font-weight: bold;"><?php echo $this->lang->line('admin_download_last_version_title');?></a>
				<?php } ?>
			</div>
		</div>
	<br />		
	<br />		
	</div>
</div>
<script type="text/javascript">
	  jQuery(function() {
			jQuery( "#accordion" ).accordion({
				autoHeight: true,
				collapsible: true,
				clearStyle: true,   
			});
	  });
	  
	  function updateTool(url, type)
	  {		
			if(type == 'update')
			{
				var cf = confirm('You want update. Are you sure?');
				if(cf)
					window.location.href = url;
			}
			else
			{
				window.open(url, '_blank');
			}
	  }
  
</script>