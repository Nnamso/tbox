<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link href="favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">	
	<title>T-Shirt eCommerce - Online solutions for printing</title>
	<link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/install.css'); ?>" rel="stylesheet">
</head>
<body>
	<div class="container-fluid">		
		<header>
			<div class="head row">
				<div class="container">
					<div class="row">
						<div class="col-md-3 pull-right text-right">
							<img src="<?php echo base_url(); ?>assets/images/logo-leng.png" alt="">
						</div>
						<div class="col-md-5 pull-left">
							<h3>T-Shirt eCommerce installation <small>version 1.1.0</small></h3>
						</div>
					</div>
				</div>
			</div>
		</header>
		
		<section>
			<div class="main">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<br>
							<br>
							<h1 class="text-center">T-Shirt eCommerce - Online solutions for printing</h1>							
							<p>Welcome to T-Shirt eCommerce software. It is great choice of your printing business. This tools support design anything: clothes, cups, hats, phone case, tablet, card...</p>
						</div>
					</div>
										
					<div class="main-body">
						<div class="row">
							<div class="col-sm-6">
								<div class="panel panel-default">
									<div class="panel-heading"><strong>Start installation</strong></div>
									<div class="panel-body">
										<p>Before getting started, we need some information on the database. You will need to know the following items before proceeding.</p>
										<ol>
											<li>Database name</li>
											<li>Database username</li>
											<li>Database password</li>
											<li>Database host</li>
										</ol>
									</div>
								</div>							
							</div>
							
							<div class="col-sm-6">
								<div class="panel panel-default">
									<div class="panel-heading"><strong>Check server supported</strong></div>
									<div class="panel-body">
										<p class="help-block">Please make sure all supported in your server. (<span class="text-success">Yes</span>)</p>
										<table class="table table-hover">
											<tr>
												<td width="50%">PHP version >= 5.2.4</td>
												<td width="30%">
													<?php if ( phpversion() > 5.2) { ?>
														<span class="text-success">Yes</span>
													<?php } else { ?>
														<span class="text-danger">No</span>
													<?php } ?>
												</td>
											</tr>
											
											<tr>
												<td width="50%">PHP Imagick Support</td>
												<td width="30%">
													<?php if ( class_exists("Imagick") ) { ?>
														<span class="text-success">Yes</span>
													<?php } else { ?>
														<span class="text-danger">No</span>
													<?php } ?>
												</td>
											</tr>
											
											<tr>
												<td width="50%">MySQL Support</td>
												<td width="30%">
													<?php if ( function_exists("mysql_connect") ) { ?>
														<span class="text-success">Yes</span>
													<?php } else { ?>
														<span class="text-danger">No</span>
													<?php } ?>
												</td>
											</tr>
											
											<tr>
												<td width="50%">database.php Writeable</td>
												<td width="30%">
													<?php if ( is_writable(APPPATH .DS. 'config' .DS. 'database.php') ) { ?>
														<span class="text-success">Yes</span>
													<?php } else { ?>
														<span class="text-danger">No</span>
													<?php } ?>
												</td>
											</tr>
											
											<tr>
												<td width="50%">Media Writeable</td>
												<td width="30%">
													<?php if ( is_writable(ROOTPATH .DS. 'media') ) { ?>
														<span class="text-success">Yes</span>
													<?php } else { ?>
														<span class="text-danger">No</span>
													<?php } ?>
												</td>
											</tr>
											
											<tr>
												<td width="50%">application/cache Writeable</td>
												<td width="30%">
													<?php if ( is_writable(APPPATH .DS. 'cache') ) { ?>
														<span class="text-success">Yes</span>
													<?php } else { ?>
														<span class="text-danger">No</span>
													<?php } ?>
												</td>
											</tr>
											
											<tr>
												<td width="50%">install.txt Writeable</td>
												<td width="30%">
													<?php if ( is_writable(ROOTPATH .DS. 'install.txt') ) { ?>
														<span class="text-success">Yes</span>
													<?php } else { ?>
														<span class="text-danger">No</span>
													<?php } ?>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12 text-right">
								<hr />
								<a href="<?php echo site_url('install/info'); ?>" class="btn btn-primary">Start Install</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		
		<footer>		
			<div class="container text-center">
				<a href="http://tshirtecommerce.com/" title="T-Shirt eCommerce">tshirtecommerce.com</a> - Online solutions for printing
			</div>
		</footer>
	</div>
</body>
</html>