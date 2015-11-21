<!-- start: HEADER -->
<div class="navbar navbar-inverse">
	<!-- start: TOP NAVIGATION CONTAINER -->
	<div class="container">
		<div class="navbar-header">
			<!-- start: RESPONSIVE MENU TOGGLER -->
			<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
				<span class="clip-list-2"></span>
			</button>
			<!-- end: RESPONSIVE MENU TOGGLER -->
			<!-- start: LOGO -->
			<a class="navbar-brand" href="<?php echo site_url();?>">
				<img src="<?php echo base_url(); ?>assets/images/logo-leng.png" alt="http://tshirtecommerce.com" />
			</a>
			<!-- end: LOGO -->
		</div>
		<div class="navbar-tools">			
			
			<!-- start: TOP NAVIGATION MENU -->
			<ul class="nav navbar-right">				
				<!-- start: USER DROPDOWN -->
				<li>
					<a href="<?php echo site_url().'admin/update'; ?>">						
						<?php echo lang('top_update_title');?> <span class="badge" style="background: #007AFF;"><i class="glyphicon glyphicon-download-alt"></i></span>
					</a>
				</li>
				<li style="margin-top: 11px;">
					<div class="btn-group">
						<button type="button" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-user"></i> <?php echo $this->user['username'];?></button>
						
						<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							<span class="caret"></span>
							<span class="sr-only">Toggle Dropdown</span>
						</button>
						
						<ul class="dropdown-menu">
							<li>
								<a href="<?php echo site_url('admin/dashboard');?>">
									<i class="clip-user-2"></i>
									&nbsp;<?php echo lang('menu_top_profile');?>
								</a>
							</li>						
							<li>
								<a href="<?php echo site_url('admin/users/changepass');?>"><i class="clip-locked"></i>
									&nbsp;<?php echo lang('menu_top_change_pass');?> </a>
							</li>
							<li>
								<?php echo anchor('admin/users/logout', '<i class="clip-exit"></i> '.lang('logout')); ?>							
							</li>
						</ul>
					</div>
				</li>
				<!-- end: USER DROPDOWN -->
			</ul>
			<!-- end: TOP NAVIGATION MENU -->
		</div>
	</div>
	<!-- end: TOP NAVIGATION CONTAINER -->
</div>
<!-- end: HEADER -->