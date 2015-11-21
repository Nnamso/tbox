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
					
					<?php if ($error !== false) { ?>
					<div class="row">
						<div class="col-md-12">
							<div class="alert alert-danger" role="alert">
								<?php echo $error; ?>
							</div>
						</div>
					</div>
					<?php } ?>
					
					<div class="main-body">
					<form action="<?php echo site_url('install/setup') ?>" method="POST" name="setup">
						<div class="row">
							<div class="col-sm-9">
								<div class="panel panel-default">
									<div class="panel-heading"><strong>Database Information</strong></div>
									<div class="panel-body">
										<p>Below you should enter your database connect details. If you're not sure about these, contact your host.</p>
										
										<div class="form-group">
											<label>Database Name</label>
											<div class="row">
												<div class="col-sm-5">
													<input type="text" class="form-control input-sm" value="<?php echo $database; ?>" name="data[database]">
												</div>
												<div class="col-sm-7">
													<small>The name of the database you want to run.</small>
												</div>
											</div>
										</div>
										
										<div class="form-group">
											<label>User Name</label>
											<div class="row">
												<div class="col-sm-5">
													<input type="text" class="form-control input-sm" value="<?php echo $username; ?>" name="data[username]">
												</div>
												<div class="col-sm-7">
													<small>Your MySQL username.</small>
												</div>
											</div>
										</div>
										
										<div class="form-group">
											<label>Password</label>
											<div class="row">
												<div class="col-sm-5">
													<input type="text" class="form-control input-sm" value="<?php echo $password; ?>" name="data[password]">
												</div>
												<div class="col-sm-7">
													<small>and your MySQL password.</small>
												</div>
											</div>
										</div>
										
										<div class="form-group">
											<label>Database Host</label>
											<div class="row">
												<div class="col-sm-5">
													<input type="text" class="form-control input-sm" value="<?php echo $hostname; ?>" name="data[hostname]">
												</div>
												<div class="col-sm-7">
													<small>Your should be able to get this info from your web host, if <i>localhost</i> dose not work.</small>
												</div>
											</div>
										</div>										
									</div>
								</div>							
							</div>
							
							<div class="col-sm-3">
								<div class="list-group">
									<a href="<?php echo site_url('install/index') ?>" class="list-group-item">
										1. Check server
									</a>
									<a href="<?php echo site_url('install/info') ?>" class="list-group-item active">
										2. Database
									</a>
									<a href="#" class="list-group-item">
										3. Configuration
									</a>
									<a href="#" class="list-group-item">
										4. Finish
									</a>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-sm-12 text-right">
								<hr />
								<button type="submit" class="btn btn-primary">Run the Install</button>
							</div>
						</div>
					</form>
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