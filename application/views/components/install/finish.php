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
							<div class="col-sm-9">
								<div class="panel panel-default">
									<div class="panel-heading"><strong class="text-success">Success!</strong></div>
									<div class="panel-body">
										<p>Your site has been installed.</p>
										
										<br />
										<br />
										<div class="form-group row">
											<label class="col-sm-2 control-label">Username</label>
											<div class="col-sm-10">
												<i>admin</i>
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 control-label">Password</label>
											<div class="col-sm-10">
												<i>Your chosen password</i>
											</div>
										</div>										
									</div>
								</div>							
							</div>
							
							<div class="col-sm-3">
								<div class="list-group">
									<a href="#" class="list-group-item">
										1. Check server
									</a>
									<a href="#" class="list-group-item">
										2. Database
									</a>
									<a href="#" class="list-group-item">
										3. Configuration
									</a>
									<a href="#" class="list-group-item active">
										4. Finish
									</a>
								</div>
							</div>
						</div>
						
						<div class="row">
							<hr />
							<div class="col-sm-6 text-left">
								<a class="btn btn-primary" href="<?php echo site_url(); ?>">Go to site</a>
							</div>
							<div class="col-sm-6 text-right">
								<a class="btn btn-primary" href="<?php echo site_url('admin'); ?>">Go to admin</a>
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