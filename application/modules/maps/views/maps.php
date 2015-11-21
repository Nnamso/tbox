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

	echo $css;
	$content = json_decode($maps->content);
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
  function initialize() {
	var mapOptions = {
	  center: { lat: <?php if(isset($content->latitude)) echo $content->latitude;?>, lng: <?php if(isset($content->longitude)) echo $content->longitude;?>},
	  zoom: <?php if(isset($content->zoom)) echo $content->zoom; ?>,
	<?php 
		if(isset($content->maptype) && $content->maptype != '') echo 'mapTypeId: google.maps.MapTypeId.'.$content->maptype; 
	?>
	};
	var map = new google.maps.Map(document.getElementById('map-canvas'),
		mapOptions);
  }
  google.maps.event.addDomListener(window, 'load', initialize);
</script>
<div id="map-canvas" style="width: <?php if(isset($content->width) && $content->width != '') echo $content->width.'px'; else echo '100%'; ?>; height: <?php if(isset($content->height) && $content->height != '') echo $content->height.'px'; else echo '100%'; ?>;"></div>
