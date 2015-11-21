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
<div class="blog-page post-page">
	<?php
		if($article->image != '')
		{
	?>
		<div class="post-image">
			<img class="thumbnail" src="<?php echo base_url($article->image); ?>" alt="<?php echo $article->title; ?>"/>
		</div>
	<?php } ?>
	<h4>
		<a href="<?php echo site_url().'blog/post/'.$article->id.'-'.$article->slug; ?>"> <?php echo $article->title; ?> </a>
	</h4>
	
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
	</div>
	
	<div class="post-content">
		<?php 
			echo $article->description;
		?>
	</div>
	
	<div class="post-connect">
		<?php 
			if(count($list_article))
			{	
				echo '<h4>'.lang('page_blog_list_article_title').'</h4>';
				foreach($list_article as $list)
				{
					echo '<div class="article-show">';
					echo '<div class="row">';
					if($list->image == '')
					{
						echo '<div class="col-xs-12">';
					}else
					{
						echo '<div class="col-xs-4 col-sm-2">';
						echo '<img class="thumbnail" src="'.base_url($list->image).'" alt="'.$list->title.'"/>';
						echo '</div>';
						echo '<div class="col-xs-8 col-sm-10">';
					}
					echo '<h5><a href="'.site_url().'blog/post/'.$list->id.'-'.$list->slug.'" title="'.$list->title.'">'.$list->title.'</a></h5>';
					
					//intro text.
					if(strlen(strip_tags($list->description)) <= 100)
						echo '<p>'.$list->description.'</p>';
					else
						echo '<p>'.substr(strip_tags($list->description), 0, 100).' [...]</p>';
						
					//read more.
					echo '<a class="btn btn-xs btn-primary pull-right" href="'.site_url().'blog/post/'.$list->id.'-'.$list->slug.'" title="'.$list->title.'"> '.lang('page_blog_readmore_title').'</a>';
					
					echo '</div>';
					echo '</div>';
					echo '</div>';
				}
			}
		?>
	</div>
</div>