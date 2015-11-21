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

$filder = array(12, 20, 40, 60, 100);
$sort	= array('id'=>'Default', 'title'=>'Name', 'price'=>'Price', 'created'=>'Date');

$orderby	= $this->input->get('orderby');
if ($orderby == '' || empty($sort[$orderby])) $orderby = 'id';	

$order	= $this->input->get('order');
if ($order == '' || ($order != 'asc' && $order != 'desc')) $order = 'asc';
if ($order == 'asc') $new_order = 'desc';
else $new_order = 'asc';
	

$limit		= $this->input->get('limit');
if ($limit == '') $limit = 12;

$link = site_url('categories/'.$category->id.'-'.$category->slug).'/'.$page;
?>
<div class="col-md-6 pull-right text-right">
	<div class="btn-group" role="group" aria-label="">
		<a href="<?php echo $link . '?orderby='. $orderby .'&order='.$new_order.'&limit='.$limit; ?>" class="btn btn-default btn-sm" title="<?php echo $order; ?>">
			<i class="fa fa-sort-amount-<?php echo $new_order; ?>"></i>
		</a>		
  	
		<div class="btn-group text-left" role="group">
			<button type="button" class="btn btn-default btn-sm"><?php echo lang('sort_by'); ?> <strong><?php echo $sort[$orderby]; ?></strong></button>
			
			<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
				<span class="caret"></span>
				<span class="sr-only"><?php echo lang('categories_filter_toggle_dropdown'); ?></span>
			</button>
			<ul class="dropdown-menu" role="menu">
				
				<?php foreach($sort as $key => $title) { ?>
				<li><a href="<?php echo $link . '?orderby='. $key .'&order='.$order.'&limit='.$limit; ?>"><?php echo lang('sort_by'); ?> <?php echo $title; ?></a></li>
				<?php } ?>
				
			</ul>
		</div>
	</div>
	 <label class="control-label"></label>
	<div class="btn-group text-left">
		<button type="button" class="btn btn-default btn-sm"><?php echo lang('show'); ?> <strong><?php echo $limit; ?> <?php echo lang('product'); ?></strong></button>
		
		<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			<span class="caret"></span>
			<span class="sr-only"><?php echo lang('categories_filter_toggle_dropdown'); ?></span>
		</button>
		<ul class="dropdown-menu" role="menu">
			
			<?php foreach($filder as $key) { ?>
			<li><a href="<?php echo $link . '?orderby='. $orderby .'&order='.$order.'&limit='.$key; ?>"><?php echo lang('show'); ?> <?php echo $key; ?> <?php echo lang('product'); ?></a></li>
			<?php } ?>
			
		</ul>
	</div>
</div>