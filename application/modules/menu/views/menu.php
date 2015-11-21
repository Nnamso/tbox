<!-- 
*	Add Class: menu-fullwidth -> menu dropdown full width.
*	Class: list-menu -> menu dropdown.
*	Class: list-menu-dropdown -> menu classic dropdown.
-->

<?php
	echo $css;
	$content = json_decode($menu->content);
	$options = json_decode($menu->options);
?>
<div class="module-menu <?php if(isset($options->class_sfx)) echo $options->class_sfx; ?>">
	<div class="navbar <?php if(isset($options->style)) echo $options->style; ?> <?php if(isset($options->display)) echo $options->display; ?>">
		<div class="container-fluid">
		
			<!-- Head menu -->
			<div class="navbar-header">				
				<button type="button" data-toggle="collapse" data-target="#dg-navbar-collapse" class="navbar-toggle"><i class="fa fa-bars"></i></button>
			</div>
			
			<div class="navbar-collapse collapse" id="dg-navbar-collapse">
				<ul class="nav navbar-nav">
				
				<?php if (isset($items)) { ?>
				
					<?php foreach($items as $item) { ?>
						
						<?php 
						if ($item->subitem != '') { 
							
							$option	= json_decode($item->options);
							
							if (empty($option->responsive) || $option->responsive == 'r') $responsive = '';
							else $responsive = 'menu-fullwidth';
						?>
						
						<li class="dropdown <?php echo $responsive; ?>">
							<a href="<?php echo site_url($item->url); ?>" title="<?php echo $item->attribute; ?>" data-toggle="dropdown" class="dropdown-toggle"><?php echo $item->title; ?> <span class="caret"></span></a>
							
							<ul class="dropdown-menu">
								<li>
									<div class="menu-content">
										<?php echo $item->subitem; ?>
									</div>
								</li>
							</ul>
						</li>
						
						<?php } else { ?>
						
						<li>
							<a href="<?php echo site_url($item->url); ?>" title="<?php echo $item->attribute; ?>"><?php echo $item->title; ?></a>
						</li>
						
						<?php } ?>
					
					<?php } ?>
				
				<?php } ?>					
				</ul>
			</div>
			
		</div>
	</div>
</div>
<script type="text/javascript">
jQuery(function() {
	window.prettyPrint && prettyPrint()
	jQuery(document).on('click', '.dropdown-menu', function(e) {
	  e.stopPropagation()
	})
});	
</script>