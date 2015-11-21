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
<script src="<?php echo base_url('assets/js/lightbox.js'); ?>"></script>
<link href="<?php echo base_url('assets/css/lightbox.css'); ?>" rel="stylesheet" type="text/css"/>
<script type="text/javascript">
	var loadingImage = '<?php echo base_url('assets/images/loading.gif'); ?>'; 
    var closeButton = '<?php echo base_url('assets/images/close.gif'); ?>';
	jQuery(document).on('click change', 'input[name="check_all"]', function() {
        var checkboxes = $(this).closest('table').find(':checkbox').not($(this));
        if ($(this).prop('checked')) {
            checkboxes.prop('checked', true);
        } else {
            checkboxes.prop('checked', false);
        }
    });
</script>

<!-- show messenger -->
<?php if($this->session->flashdata('error') != ''){?>
	<div class="alert alert-danger"><?php echo $this->session->flashdata('error');?></div>
<?php } ?>

<?php if($this->session->flashdata('msg') != ''){?>
	<div class="alert alert-success"><?php echo $this->session->flashdata('msg');?></div>
<?php } ?>

<div class="panel panel-default">	
	<div class="panel-heading">
		<i class="fa fa-external-link-square icon-external-link-sign"></i>
		<?php echo lang('designer_list'); ?>          
	</div>
	
	<div class="panel-body" id="panelbody">
		<?php
			$attribute = array('class' => 'fr-design', 'id' => 'fr-design');				
			echo form_open(site_url('admin/design/index'), $attribute);
		?>
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<div class="col-md-2">
						<?php $options = array('all'=> lang('all'), '5'=>5, '10'=>10, '15'=>15, '20'=>20, '25'=>25, '100'=>100);?>
						<?php echo form_dropdown('per_page', $options, $per_page, 'class="form-control" id="per_page"'); ?>
					</div>
					
					<div class="col-md-4">
						<?php 
							$searchs = array('name' => 'search', 'id' => 'search', 'class' => 'form-control', 'placeholder' => lang('designer_enter_search_place'), 'value'=>$search);
							echo form_input($searchs);
						?>
					</div>
					<div class="col-md-4">
						<?php 
							$option_s = array('design' => lang('designer_search_design_id_title'), 'user' => lang('designer_search_username_title'), 'product' => lang('designer_search_product_title'));
							echo form_dropdown('option', $option_s, $option, 'class="form-control" id="option_s"'); 
						?>
					</div>
					<div class="col-md-2">
						<button type="submit" class="btn btn-primary"><?php echo lang('search');?></button>
					</div>
				</div>
			</div>
			
			<div class="col-md-6">
				<a id="btn-delete" href="javascript:void(0);" class="btn btn-bricky tooltips pull-right" title="<?php echo lang('delete');?>" style="margin-bottom: 10px;"><i class="fa fa-trash-o"></i></a>
			</div>
		</div>
		
		<table id="sample-table-1" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th class="center" style="width: 5%;">
						<label>
							<input id="select_all" type="checkbox" name='check_all'>
						</label>
					</th>
					<th class="center" style="width: 10%;"><?php echo lang('designer_design_key_title'); ?></th>
					<th class="center"><?php echo lang('username'); ?></th>
					<th class="center"><?php echo lang('designer_product_name_title'); ?></th>
					<th class="center" style="width: 6%;"><?php echo lang('color'); ?></th>
					<th class="center" style="width: 20%;"><?php echo lang('teams'); ?></th>
					<th class="center"><?php echo lang('image'); ?></th>
					<th class="center"><?php echo lang('date'); ?></th>
					<th class="center"><?php echo lang('delete'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if (count($designs) != '') foreach ($designs as $design) { ?>
						<tr>
							<td class="center" style="width: 5%;">
								<label>
									<input type="checkbox" name="checkb[]" class="checkb" name="check" value="<?php echo $design->id; ?>">
								</label>
							</td>
						   
						   <td class="center">
								<a target="blank" href="<?php echo site_url('design/index/'.$design->product_id.'/'.$design->product_options.'/'.$design->design_id); ?>"><?php echo $design->design_id;?></a>
							</td>
						   
						   <td><a href="<?php echo site_url().'admin/users/edit/'.$design->user_id; ?>"><?php echo $design->name;?></a></td>
						   
						   <td><?php echo $design->title;?></td>
						   
						   <td class="center"><span class="box-color" style="background: #<?php echo $design->product_options;?>;"></span></td>
						   
						   <td>
								<?php 
									$teams = json_decode($design->teams);
									if(is_string($teams))
										$teams = json_decode($teams);
									if(isset($teams->name))
									{
										$label = array();
										$value = array();
										foreach($teams as $key=>$val)
										{
											$label[] = $key;
											foreach($val as $v)
											{
												$value[$key][] = $v;
											}
										}
										$name = '';
										$number = '';
										$zise = '';
										echo '<table class="table table-bordered table-hover">';
										echo '<tr>';
										foreach($label as $val)
										{
											echo '<th class="center">'.$val.'</th>';
										}
										echo "</tr>";
										for($i=0; $i<count($value[$key]); $i++)
										{
											echo "<tr>";
											if(isset($value['name'][$i]))
												$name = $value['name'][$i];
											echo '<td class="center">'.$name.'</td>';
											if(isset($value['number'][$i]))
												$number = $value['number'][$i];
											echo '<td class="center">'.$value['number'][$i].'</td>';
											if(isset($value['size'][$i]))
											{
												$str = strstr($value['size'][$i], '::');
												$zise = trim(str_replace($str, '', $value['size'][$i]));
											}
											echo '<td class="center">'.$zise.'</td>';
											echo "</tr>";
										}
										echo "</table>";
									}
								?>
							</td>
							
							<td>
								<a class="tooltips" rel="lightbox" href="<?php echo base_url($design->image); ?>">
									<img style="width: 100px;" src="<?php echo base_url($design->image); ?>" alt=""/>
								</a>
							</td>
							
							<td class="center"><?php $date = new DateTime($design->created); echo $date->format("Y-m-d");; ?></td>
							
							<td class="center"><a class="btn btn-danger tooltips" href="<?php echo site_url('admin/design/delete/'.$design->id); ?>" onclick="return confirm('<?php echo lang('designer_delete_msg');?>');" title="<?php echo lang('remove');?>"><i class="fa fa-times"></i></a></td>
						</tr>
					<?php } ?>    
			</tbody>
		</table>
		<div class="pull-right">
			<?php echo $links;?>
		</div>
	</div>
	<?php echo form_close(); ?>        
</div>  

<script type="text/javascript">
	jQuery('.tooltips').tooltip();
	jQuery('#per_page').change(function(){
		jQuery('#fr-design').submit();
	});
	
	jQuery('#btn-delete').click(function(){
		if(jQuery('.checkb').is(':checked')){
			var cf = confirm("<?php echo lang('designer_delete_msg');?>");
			if(cf)
				jQuery('#fr-design').attr('action', '<?php echo site_url('admin/design/delete');?>').submit();
		}else{
			alert('<?php echo lang('designer_error_not_checbox');?>');
		}
	});
</script>