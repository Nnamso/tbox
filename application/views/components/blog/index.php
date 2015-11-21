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
<div class="blog-page">
	<h3><?php echo lang('page_blog_blog_categories_title');?></h3>
	<div class="row category-sub clearfix">
		<?php
			foreach($categories as $category)
			{
		?>
				<div class="col-xs-4 col-sm-3 col-md-2 text-center form-group">
					<a href="<?php echo site_url().'blog/category/'.$category->id.'-'.$category->slug; ?>">
						<img class="img-responsive img-thumbnail" src="<?php echo base_url($category->image); ?>" alt="<?php echo $category->title; ?>"/>
					</a>
					<a href="<?php echo site_url().'blog/category/'.$category->id.'-'.$category->slug; ?>" title="<?php echo $category->title; ?>"><?php echo $category->title; ?></a>
				</div>
		<?php
			} 
		?>
	</div>
	
	<hr>
	<?php
		foreach($articles as $article)
		{
	?>
		<div class="article-post">
			<div class="row">
				<?php
					if($article->image == '')
					{
						echo '<div class="col-sm-12">';
					}else
					{
				?>
					<div class="col-sm-5">
						<div class="post-image">
							<img class="thumbnail" src="<?php echo base_url($article->image); ?>" alt="<?php echo $article->title; ?>" />
						</div>
					</div>
					<div class="col-sm-7">
				<?php } ?>
					<div class="post-content">
						<h4>
							<a href="<?php echo site_url().'blog/post/'.$article->id.'-'.$article->slug; ?>" ><?php echo $article->title; ?></a>
						</h4>
						<p>
							<?php 
								if(strlen(strip_tags($article->description)) <= 400)
									echo strip_tags($article->description);
								else
									echo substr(strip_tags($article->description), 0, 400).' [...]';
							?>
						</p>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="post-meta">
						<span>
							<i class="fa fa-calendar"></i>
							<?php 
								$date = date_create($article->date);
								echo date_format($date, 'F d,Y');
							?>
						</span>
						
						<span>
						<i class="fa fa-user"></i>
							<?php echo lang('page_blog_by_title');?>
							<a href="#"> <?php echo $article->created; ?> </a>
						</span>
						<a class="btn btn-xs btn-primary pull-right" href="<?php echo site_url().'blog/post/'.$article->id.'-'.$article->slug; ?>"> <?php echo lang('page_blog_readmore_title');?> </a>
					</div>
				</div>
			</div>
		</div>
	<?php
		} 
	?>
</div>