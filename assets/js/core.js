var apps={
	ini: function(){		
	},
	product:{	
	},
	state: function(e, value){
		if (typeof value == 'undefined') value = 0;
		var country_id	= e.value;
		jQuery.ajax({				
			url: baseURL + "ajax/state/"+country_id+"/"+value,				
		}).done(function( data ) {
			jQuery('#field-state').html(data);
		});
	},
	checkout: function(){
		var fr = jQuery('#cartCheckout');
		var check = true;
		fr.find('.required').each(function(){
			if ( jQuery(this).val() == '')
			{
				jQuery(this).css('border-color', '#ff0000');
				check = false;
			}
			else
			{
				jQuery(this).css('border-color', '#CCC');
			}			
		});
		
		if (check == false)
		{
			alert('Please add shipping info.');
			return false;
		}
		
		fr.submit();
	},
	shipping: function(id){
		if (typeof id == 'undefined')
		{
			jQuery('.choose-shipping').each(function(){
				if (jQuery(this).is(':checked') == true)
					id = jQuery(this).val();
			});
		}
		if (id > 0)
		{
			jQuery('.cart_info').css('opacity', '0.3');				
			jQuery.ajax({					
				url: baseURL + "cart/shipping/"+id
			}).done(function( data ){
				jQuery('.cart_info table').html(data);
				jQuery('.cart_info').css('opacity', '1');
				jQuery('.text-success').click(function(event){
					event.preventDefault();
					jQuery(this).parents('.cart-more').find('.cart-more-display').toggle();
				});
			});
		}			
	},
	discount: function(e){
		var value = jQuery('#coupon_code').val();
		if (value == '')
		{
			alert('Please add coupon.');
			return false;
		}
		if (typeof e != 'undefined')
			var $btn = jQuery(e).button('loading');
			
		jQuery('.cart_info').css('opacity', '0.3');
		jQuery.ajax({					
			url: baseURL + "cart/coupon/"+value
		}).done(function( data ){
			
			if (typeof $btn != 'undefined')
				$btn.button('reset');
				
			jQuery('.cart_info table').html(data);
			jQuery('.cart_info').css('opacity', '1');
			
			jQuery('.text-success').click(function(event){
				event.preventDefault();
				jQuery(this).parents('.cart-more').find('.cart-more-display').toggle();
			});
		});
	},
	removeCart: function(id, e){		
		jQuery(e).parents('tr').remove();
		jQuery.ajax({			
			url: baseURL + "cart/remove/"+id					
		}).done(function( data ){
			location.reload();
		})
	},
}
jQuery(function() {
	apps.ini();
});