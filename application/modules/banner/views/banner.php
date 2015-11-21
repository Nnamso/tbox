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
<link rel="stylesheet" type="text/css" href="<?php echo base_url('media/modules/banner/jquery.bxslider.css'); ?>"/>
<script src="<?php echo base_url('media/modules/banner/jquery.bxslider.js'); ?>"></script>
<?php echo $css; ?>
<ul class="bxslider">
	<?php 
		$images = json_decode($banner->images);
		$captions = json_decode($banner->captions);
		$html = '';
		for($i=0; $i<count($images); $i++)
		{
			if(isset($captions[$i]))
				echo '<li><img src="'.base_url($images[$i]).'" alt="image"/><div class="bx-caption">'.$captions[$i].'</div></li>';
			else
				echo '<li><img src="'.base_url($images[$i]).'" alt="image"/></li>';
		}
	?>
</ul>
<script type="text/javascript">
	jQuery('.bxslider').bxSlider({
		<?php 
			$settings = json_decode($banner->settings);
			foreach($settings as $key=>$val)
			{
				if($key == 'slideWidth' && $val == '')
				{
					echo '';
				}else if($val === 'true' || $val === 'false')
					echo $key.': '.$val.',';
				else
					echo $key.': "'.$val.'",';
			}
		?>
		auto: false,
		speed: 400
	});
</script>