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
<div role="tabpanel">
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active">
			<a href="#list_modules" aria-controls="list_modules" role="tab" data-toggle="tab">List Modules</a>
		</li>
		<li role="presentation">
			<a href="#main_page" aria-controls="main_page" role="tab" data-toggle="tab">Main page</a>
		</li>
	</ul>
	
	<div class="tab-content">
		<!-- show list module -->
		<div role="tabpanel" class="tab-pane active" id="list_modules">
			<?php if(count($modules)) { ?>
	
				<?php foreach($modules as $module) { ?>		
					<?php if($module->name != 'row'){ ?>
					<div class="col-md" onclick="grid.module.setting('<?php echo $module->name; ?>')">			
						<div class="col-md-left">
							<img src="<?php echo site_url($module->thumb); ?>" width="32" alt="">
						</div>
						
						<div class="col-md-right">
							<label><?php echo $module->title; ?></label>
							<span><?php echo $module->description; ?></span>
						</div>
					</div>		
					<?php } ?>
				<?php } ?>

			<?php } ?>
		</div>
		
		<div role="tabpanel" class="tab-pane" id="main_page">
			<?php if(count($pages)) { ?>
	
				<?php foreach($pages as $page) { ?>		
					<div class="col-md" onclick="grid.module.page('<?php echo $page->name; ?>', '<?php echo $page->description; ?>')">			
						<div class="col-md-left">
							<img src="<?php echo $page->icon; ?>" width="32" alt="">
						</div>
						
						<div class="col-md-right">
							<label><?php echo $page->name; ?></label>
							<span><?php echo $page->description; ?></span>
						</div>
					</div>		
				<?php } ?>

			<?php } ?>
		</div>
	</div>
</div>