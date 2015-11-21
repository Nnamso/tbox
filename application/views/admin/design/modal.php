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
<link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" media="screen">
<style>
	body table{font-size:12px}
</style>
<?php
$attribute = array('class' => 'fr-design', 'id' => 'fr-design');				
echo form_open(site_url('admin/design/modal'), $attribute);
?>
		
<!-- head tool -->
<div class="row">
	<div class="col-md-8">
		
					
		<?php 
			$search = array('name' => 'search', 'id' => 'search', 'class' => 'form-control', 'placeholder' => lang('designer_enter_search_place'), 'style'=>'display: inline; width: auto;', 'value'=>$search);
			echo form_input($search);
		?>
		
		<?php 
			$option_s = array('design' => lang('designer_search_design_id_title'), 'user' => lang('designer_search_username_title'), 'product' => lang('designer_search_product_title'));
			echo form_dropdown('option_s', $option_s, $search_o, 'style="display: inline; width: auto;" class="form-control" id="option_s"'); 
		?>
		<button type="submit" class="btn btn-primary"><?php echo lang('search');?></button>
	</div>
</div>
<hr />
<div class="row">
	<div class="col-md-12">
		<table id="sample-table-1" class="table table-bordered table-hover" style="margin-top: 10px;">
			<thead>
				<tr>						
					<th class="center" style="width: 10%;"><?php echo lang('designer_design_key_title'); ?></th>
					<th class="center"><?php echo lang('username'); ?></th>
					<th class="center"><?php echo lang('designer_product_name_title'); ?></th>
					<th class="center" style="width: 6%;"><?php echo lang('color'); ?></th>						
					<th class="center"><?php echo lang('image'); ?></th>
					<th class="center"><?php echo lang('date'); ?></th>						
				</tr>
			</thead>
			<tbody>
				<?php if (count($designs) != '') foreach ($designs as $design) { ?>
						<tr>
						   <td class="center">
								<a href="javascript:void(0)" onclick="window.parent.Insertdesign(<?php echo $design->id; ?>, '<?php echo base_url($design->image); ?>')"><?php echo $design->design_id;?></a>
							</td>
						   
						   <td><a href="<?php echo site_url().'admin/users/edit/'.$design->user_id; ?>"><?php echo $design->name;?></a></td>
						   
						   <td><?php echo $design->title;?></td>
						   
						   <td class="center">
							<span class="box-color" style="width:20px; height:20px; border:1px solid #ccc; display:inline-block;background: #<?php echo $design->product_options;?>;"></span></td>
						   
						   
							<td>
								<a class="tooltips" rel="lightbox" href="<?php echo base_url($design->image); ?>">
									<img style="width: 100px;" src="<?php echo base_url($design->image); ?>" alt=""/>
								</a>
							</td>
							
							<td class="center"><?php $date = new DateTime($design->created); echo $date->format("Y-m-d");; ?></td>								
						</tr>
					<?php } ?>    
			</tbody>
		</table>
	</div>
</div>

<div class="row">
	<div class="col-md-12 text-right">
		<?php echo $links;?>
	</div>
</div>
<?php echo form_close(); ?>