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

$this->load->view('admin/components/page_head'); 
?>
<body>
    <?php $this->load->view('admin/components/page_top'); ?>

	<!-- start: MAIN CONTAINER -->
	<div class="main-container">
		<?php $this->load->view('admin/components/page_left'); ?>
		
		<div class="main-content">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">						
						<!-- start: PAGE TITLE & BREADCRUMB -->
						<ol class="breadcrumb">
							<li>
								<i class="clip-home-3"></i>
								<a href="<?php echo site_url("admin/dashboard"); ?>">
									Home
								</a>
							</li>
							<?php if(isset($breadcrumb)){ ?>
							<li class="active">
								<?php echo $breadcrumb; ?>
							</li>
							<?php } ?>							
							<li class="search-box">
								<a href="http://tshirtecommerce.com/" target="_blank">Help & Support</a>
							</li>
						</ol>
						<div class="page-header">
							<h1>
								<?php echo $meta_title; ?>
								<?php if(isset($sub_title)){ ?>
									<small><?php echo $sub_title; ?> </small>
								<?php } ?>
							</h1>
						</div>
						<!-- end: PAGE TITLE & BREADCRUMB -->
					</div>
				</div>
				
				<div class="row">
					<div class="col-sm-12">	
					</div>
				</div>
				
				<!-- start: CONTENT -->
				<?php $this->load->view($subview); ?>
				<!-- end: CONTENT -->
				
			</div>
		</div>
		<!-- end: PAGE -->
	</div>
	<!-- end: MAIN CONTAINER -->
	<div class="footer clearfix">
		<div class="footer-inner">
			2015 &copy; tshirtecommerce.com
		</div>
		<div class="footer-items">
			<span class="go-top"><i class="clip-chevron-up"></i></span>
		</div>
	</div>
<?php $this->load->view('admin/components/page_footer'); ?>