var grid = {
	wapper: '',
	config: '',
	rowElment: {},
	bModule: '',
	jsControlR: '',
	jsControlC: '',
	htmlRow: '',
	row:{
		add: function(e){
			grid.wapper 	= jQuery('#main-app');
			grid.htmlRow 	= '<div class="row-elment col-md-12">'+grid.jsControlR+grid.config+'</div>';
			if (typeof e == 'undefined')
			{
				grid.wapper.append(grid.htmlRow);
			}
			else
			{
				jQuery(grid.htmlRow).insertAfter(jQuery(e).parents('.row-elment'));
			}
		},
		remove: function(e){
			var check = confirm('Press Ok to delete section, Cancel to leave');
			if (check == true)
			{				
				if (jQuery(e).parents('.elment-rows').length == 0)
				{
					var elm = jQuery(e).parents('.col-elment');
					if (elm.length > 0)
						elm.remove();
					else
						jQuery(e).parents('.row-elment').remove();
				}
				else
				{
					jQuery(e).parents('.elment-rows').parent().remove();
				}
			}
		},
		config: function(e, type){
			var title = jQuery('#module-setting h4.modal-title');
			if (title.length > 0)
			{
				if(title.find('small').length > 0)
					title.find('small').html(' - config '+type);
				else
					title.append('<small> - config'+type+'</small>')
			}
			jQuery('#list-modules').modal('hide');
			jQuery('#module-setting').modal({
				backdrop:false,
				keyboard: false
			});
			jQuery("#module-setting").draggable({ handle: ".modal-header" });
			
			if (type == 'row')
			{
				var elm = jQuery(e).parents('.row-elment');
				var module = 'row';
			}
			else
			{
				var elm = jQuery(e).parents('.col-elment');
				var module = 'col';
			}
			grid.module.elment = elm;
			if (typeof jQuery(elm).data('id') == 'undefined')
				var id = 0;
			else
				var id = jQuery(elm).data('id');
				
			
			var body = jQuery('#module-setting .modal-body');
			body.addClass('g-loading');
			var url = base_url + module + '/admin/setting/edit/'+id;
			jQuery('#module-setting .btn_back').hide();
			jQuery('#module-setting .btn_save').show();
			
			jQuery.ajax({
				url: url
			}).done(function( html ) {			
				body.html(html);
				grid.color();
				body.removeClass('g-loading');
			});
		},
		layout: function(e){
			grid.rowElment = e;
			jQuery('#layout-row').modal({
				backdrop:false,
				keyboard: false
			}).draggable({ handle: ".modal-header" });
			
			/* load row */
			var elm = jQuery(e).parents('.row-elment').children('.container').children('.row-content').children('.col-elment');
			var col = 0, html = '';
			if (elm.length > 0) 
			{			
				elm.each(function(){
					col++;
					var number = jQuery(this).attr('class').replace('col-elment col-md-', '');
					
					html = html + '<div class="col-md-2 col-sm-4">'
								+ 	'<label>Col '+col+'</label>'
								+ 	'<select class="form-control input-sm layout-number-col">';
					
					 for (j=1; j<13; j++){
						if (j == number)
							html = html + '<option value="'+j+'" selected="selected"> '+j+' </option>';
						else
							html = html + '<option value="'+j+'"> '+j+' </option>';
					 }				
					html = html + 	'</select></div>';
				});
			}
			jQuery( ".number-row" ).html(col + ' rows');
			jQuery('.layout-col-list').html(html);
			
			/* slider and setup layout*/
			jQuery( "#slider-number-row" ).slider({
				range: "max",
				min: 0,
				max: 6,
				value: col,
				slide: function( event, ui ) {
					jQuery( ".number-row" ).html( ui.value + ' rows');
					var html = '', col = 12/ui.value;
					for(i=1; i<=ui.value; i++)
					{
						html = html + '<div class="col-md-2 col-sm-4">'
							 + 	'<label>Col '+i+'</label>'
							 + 	'<select class="form-control input-sm layout-number-col">';
							 
							 for (j=1; j<13; j++){
								if (j == col)
									html = html + '<option value="'+j+'" selected="selected"> '+j+' </option>';
								else
									html = html + '<option value="'+j+'"> '+j+' </option>';
							 }
							
						html = html + 	'</select>'
							 + '</div>';
					}
					jQuery('.layout-col-list').html(html);
					jQuery('#layout-row #layout-save').attr('onclick', "grid.row.save(this)");
				}
			});
			jQuery('#layout-row #layout-save').bind('click', function(event){						
				grid.row.save(e, this);				
			});
		},
		save: function(button, e){
			var e = grid.rowElment;
			var $btn = jQuery(button).button('loading');
			var elm = jQuery(e).parents('.row-elment');
			elm.find('.js-button').remove();
			
			var count = 0, i=0, cols = [];
			
			if (elm.find('.row-content').length == 0)
			{
				if(elm.children('.container').length == 0)
					elm.append('<div class="container"><div class="row-content row"></div></div>');
				else
					elm.children('.container').append('<div class="row-content row"></div>');
			}
			else
			{
				elm.find('.row-content').html('');
			}
			jQuery('.layout-col-list').find('.layout-number-col').each(function(){
				var col = jQuery(this).val();
				count = count + parseInt(col);
				cols[i] = col;
				i++;
			});
			if (count > 12)
			{ 
				alert('Wrong row layout format! Total grid of all column <= 12.');
			}
			else
			{
				for(j=0; j<i; j++)
				{
					var column = '<div class="col-elment col-md-'+cols[j]+'">'+grid.jsControlC+grid.bGModule+'</div>';
					elm.find('.row-content').append(column);
				}
			}
			jQuery('#layout-row').modal('hide');
			$btn.button('reset');			
		},		
	},
	col:{
		colElment: {},
		remove: function(e){
			var check = confirm('Press Ok to delete section, Cancel to leave');
			if (check == true)
			{
				jQuery(e).parents('.col-elment').remove();
			}
		},
		addRow: function(e){
			var elment = jQuery(e).parents('.col-elment');
			if (elment.children('.module-margin').length > 0)
			{
				var m = elment.children('.module-margin');
				var attrClass = m.attr('class');
				var content = m.html();
				m.remove();
				elment.append('<div class="row-content row"><div class="col-elment col-md-12 elment-rows"><div class="'+attrClass+'">'+content+'</div></div></div>');
			}
			var html 	= '<div class="row-content row"><div class="col-elment col-md-12 elment-rows">'+grid.bGModule+'</div></div>';
			elment.append(html);
			
			if(elment.children('.js-button').length > 0)
			{
				elment.children('.js-button').remove();
				this.addRow(e);
			}
		},
		config: function(e){
			var elm = jQuery(e).parents('.col-elment'),
			devices = {xs:0, sm:0, md:0},
			string = elm.attr('class');
			string	= string.replace('col-elment', '');
			this.colElment = elm;
			
			var classs = string.split(' ');
			for(i=0; i<classs.length; i++)
			{
				if (classs[i].indexOf('col-md-') != -1)
				{
					devices.md	= classs[i].replace('col-md-', '');
				}
				
				if (classs[i].indexOf('col-sm-') != -1)
				{
					devices.sm	= classs[i].replace('col-sm-', '');
				}
				
				if (classs[i].indexOf('col-xs-') != -1)
				{
					devices.xs	= classs[i].replace('col-xs-', '');
				}
			}
			
			var tbody = jQuery('#col-setting tbody');
			tbody.html('');
			var tr = document.createElement('tr');
			for(x in devices)
			{
				var td = document.createElement('td');
					td.className = 'col-device-'+x;
				var select = '<select class="form-control input-sm"><option value="0"> - Select value - </option>';
				for(i=1; i<13; i++)
				{
					if (devices[x] == i)
						var selected = 'selected="selected"';
					else
						var selected = '';
						
					select = select + '<option '+selected+' value="'+i+'">'+i+'</option>';
				}
				select	= select + '</select>';
				td.innerHTML = select;
				tr.appendChild(td);
			}
			tbody.append(tr);
			jQuery('#col-setting').modal('show');
		},
		save: function(e){
			var string = 'col-elment';
			
			var xs = jQuery('.col-device-xs select').val();
			if (xs > 0)
			{
				string = string + ' col-xs-'+xs;
			}
			
			var sm = jQuery('.col-device-sm select').val();
			if (sm > 0)
			{
				string = string + ' col-sm-'+sm;
			}
			
			var md = jQuery('.col-device-md select').val();
			if (md > 0)
			{
				string = string + ' col-md-'+md;
			}
			
			this.colElment.attr('class', string);
			jQuery('#col-setting').modal('hide');
		}
	},
	module:{
		elment: {},
		view: function(e){
			jQuery('#module-setting .btn_back').bind('click', function(){
				jQuery('#module-setting').modal('hide');
				grid.module.view(e);
			});
			this.elment = jQuery(e).parents('.col-elment');
			jQuery('#list-modules').modal();
			var body = jQuery('#list-modules .modal-body');
			if (body.html() == '')
			{
				body.addClass('g-loading');
				
				jQuery.ajax({
					url: base_url + 'admin/module'
				})
				.done(function( html ) {
					body.html(html);
					body.removeClass('g-loading');
				});
			}
			else
			{
				body.removeClass('g-loading');
			}
		},
		setting: function(module, id, e){
			if (typeof e != 'undefined')
				grid.module.elment = jQuery(e).parents('.col-elment');
				
			var title = jQuery('#module-setting h4.modal-title');
			if (title.length > 0)
			{
				if(title.find('small').length > 0)
					title.find('small').html(' - ' + module);
				else
					title.append('<small> - '+module+'</small>')
			}
			
			jQuery('#list-modules').modal('hide');
			jQuery('#module-setting').modal({
				backdrop:false,
				keyboard: false
			});
			jQuery("#module-setting").draggable({ handle: ".modal-header" });
			
			var body = jQuery('#module-setting .modal-body');
			body.addClass('g-loading');
			
			if(typeof id == 'undefined')
			{
				var url = base_url + module + '/admin/setting';
				jQuery('#module-setting .btn_save').hide();
			}
			else
			{
				var url = base_url + module + '/admin/setting/edit/'+id;
				jQuery('#module-setting .btn_save').show();
			}
			jQuery.ajax({
				url: url
			}).done(function( html ) {				
				body.html(html);
				grid.color();
				body.removeClass('g-loading');
				jQuery('#module-setting .btn_back').bind('click', function(){
					jQuery('#module-setting').modal('hide');
					grid.module.view(e);
				});
			});
		},
		save: function(e){			
			var $btn = jQuery(e).button('loading');
			var fr = jQuery('#module-setting .setting-save');
			
			if (fr.find('.text-edittor').length > 0)
				tinyMCE.triggerSave();
			
			var url = fr.attr('action');
			
			var formData = $(fr).serialize();
			jQuery.ajax({
				type:'post',
				url: url,
				data:formData,				
				complete:function(){					
					$btn.button('reset');
				},
				success:function(result){
					$btn.button('reset');
					var check = true;
					if (result == '')
					{
						check = false;
					}
					else
					{
						var obj = jQuery.parseJSON(result);
						if (typeof obj.id == 'undefined' || typeof obj.key == 'undefined') check = false;
						
						if (obj.error == 1)
						{
							alert(obj.content);
							return false;
						}
					}
					
					if (check == false)
					{
						alert('Sorry, module errors and can not save!');
					}
					else
					{
						if (typeof obj.element != 'undefined')
						{
							// config row, col
							if (obj.element == 'row')
							{
								grid.module.row(obj);
							}
							else
							{
								grid.module.col(obj);
							}
						}
						else
						{
							// add shortcode to module
							jQuery(grid.module.elment[0]).find('.js-button').remove();
							if (jQuery(grid.module.elment[0]).find('.module-content').length == 0)
							{
								jQuery(grid.module.elment[0]).append('<div class="module-margin"><div class="module-border"><div class="module-padding"><div class="module-content"></div></div></div></div>');							
							}
							var html = '<div class="module-main">'
										+ 		obj.content
										+  '</div>'
										+  '<div class="js-elment module-info">'
										+  		'<strong>'+obj.module+': '+obj.title+'</strong>'
										+  '</div>';
							jQuery(grid.module.elment[0]).find('.module-content').html(grid.bAModule + html);
							jQuery(grid.module.elment[0]).find('.js-control-edit').attr('onclick', 'grid.module.setting("'+obj.module+'", '+obj.id+', this)');
							
							jQuery(grid.module.elment[0]).children('.module-margin').attr('class', 'module-margin module-'+obj.key);
							
						}
						jQuery('#module-setting').modal('hide');
					}
				}
			});			
		},
		row: function(obj){
			var elm = jQuery(grid.module.elment[0]);
			elm.attr('class', 'row-elment col-md-12 module-' +obj.key+ ' '+obj.class_sfx);
			if (elm.children('style').length == 0)
			{
				elm.append('<style>'+obj.content+'</style>');
			}
			else
			{
				elm.children('style').html(obj.content);
			}
			elm.attr('data-id', obj.id);
		},
		insert: function(module, method, id, key, title){
			var content = '{module:'+module+'/'+method+','+id+'}';
			jQuery(grid.module.elment[0]).find('.js-button').remove();
			if (jQuery(grid.module.elment[0]).find('.module-content').length == 0)
			{
				jQuery(grid.module.elment[0]).append('<div class="module-margin"><div class="module-border"><div class="module-padding"><div class="module-content"></div></div></div></div>');							
			}
			var html = '<div class="module-main">'
					+ 		content
					+  '</div>'
					+  '<div class="js-elment module-info">'
					+  		'<strong>'+module+': '+title+'</strong>'
					+  '</div>';
			jQuery(grid.module.elment[0]).find('.module-content').html(grid.bAModule + html);
			jQuery(grid.module.elment[0]).find('.js-control-edit').attr('onclick', 'grid.module.setting("'+module+'", '+id+', this)');
			
			jQuery(grid.module.elment[0]).children('.module-margin').attr('class', 'module-margin module-'+key);
			jQuery('#module-setting').modal('hide');			
		},
		load: function(module, method, id, e){
			jQuery.ajax({
				url: base_url + module + '/' + method + '/' + id
			})
			.done(function( html ) {
				e.html(html);				
			});
		},
		page: function(name, title){
			var content = '{page:'+name+'}';
			jQuery(grid.module.elment[0]).find('.js-button').remove();
			if (jQuery(grid.module.elment[0]).find('.module-content').length == 0)
			{
				jQuery(grid.module.elment[0]).append('<div class="module-margin"><div class="module-border"><div class="module-padding"><div class="module-content"></div></div></div></div>');							
			}
			var html = '<div class="module-main">'
					+ 		content
					+  '</div>'
					+  '<div class="js-elment module-info">'
					+  		'<strong>Page: '+name+' - '+title+'</strong>'
					+  '</div>';
			jQuery(grid.module.elment[0]).find('.module-content').html(grid.bAModule + html);
			jQuery(grid.module.elment[0]).find('.js-control-edit').attr('onclick', 'grid.module.view(this)');
			
			jQuery(grid.module.elment[0]).children('.module-margin').attr('class', 'module-margin module-'+name);
			jQuery('#module-setting').modal('hide');			
			jQuery('#list-modules').modal('hide');			
		
		}
	},
	color: function(){
		jscolor.init();
		jQuery('.pick-color .pick-color-btn').click(function(){
			var e = jQuery(this).parent().children('input');
			e[0].color.showPicker();
		});
		jQuery('.pick-color-clear').click(function(){
			var input = jQuery(this).parent().find('.color');
			input.val('').css({'background': '#FFFFFF'});
		});
	},
	page: {
		view: function(e){
			var html = jQuery('#main-app').html();
			jQuery('#page_content').val(html);			
			var page = jQuery("<div/>").append(jQuery('.js-elment', html).remove().end()).html();			
			jQuery('#page_file').val(page);
			
			jQuery('#page-setting').modal({
				backdrop:false				
			});
		},
		setLayout: function(e){
			var layout = jQuery(e).data('group') +'/'+ jQuery(e).data('file');
			var title = jQuery(e).find('strong').html();
			jQuery('.page_layout').val(layout);
			jQuery(e).parents('.btn-group-full').find('button').html(title + ' <span class="caret"></span>');
		},
		save: function(e){
			jQuery('.page-save').submit();
		}
	},
	menu:{
		elm: {},
		add: function(e){
			var $btn = jQuery(e).button('loading');
			var panel 	= jQuery(e).parents('.panel-body');
			var url 	= panel.data('link');
			var type 	= panel.data('type');
			
			var items	= jQuery('.menu-items');
			panel.find('input').each(function(){
				if (jQuery(this).is(':checked') == true)
				{
					jQuery(this).prop('checked', false);
					var title 	= jQuery(this).data('title');
					var link 	= jQuery(this).data('link');
					var li = '<li class="menu-item" data-link="'+url+link+'" data-id="0">'
							+ '<input type="hidden" class="hiden-items-title" value="'+title+'" name="items[title][]">'
							+ '<input type="hidden" class="hiden-items-url" value="'+url+link+'" name="items[url][]">'
							+ '<input type="hidden" class="hiden-items-id" value="0" name="items[id][]">'
							+ '<input type="hidden" class="hiden-items-attribute" value="'+title+'" name="items[attribute][]">'
							+ '<input type="hidden" class="hiden-items-type" value="'+type+'" name="items[options][type][]">'
							+ '<input type="hidden" class="hiden-items-options-responsive" value="r" name="items[options][responsive][]">'
							+ '<textarea name="items[subitem][]" class="hiden-items-subitem" style="display:none;"></textarea>'
							+ '<textarea name="items[html][]" class="hiden-items-html" style="display:none;"></textarea>'
							+ '<label class="menu-title">'+title+'</label> <span class="pull-right item-config">'+type+' <i class="fa fa-caret-down"></i></span></li>';
					items.append(li);
				}
			});
			items.sortable();
			$btn.button('reset');
			this.ini();
		},
		addCustom: function(e){
			var $btn = jQuery(e).button('loading');
			var panel 	= jQuery(e).parents('.panel-body');			
			var type 	= 'custom';
			
			var url 	= panel.find('input.custom-url').val();
			var title 	= panel.find('input.custom-title').val();
			var items	= jQuery('.menu-items');
			
			if (title != '' && url != '')
			{				
				var li = '<li class="menu-item" data-link="'+url+'" data-id="0">'
							+ '<input type="hidden" class="hiden-items-title" value="'+title+'" name="items[title][]">'
							+ '<input type="hidden" class="hiden-items-url" value="'+url+'" name="items[url][]">'
							+ '<input type="hidden" class="hiden-items-id" value="0" name="items[id][]">'
							+ '<input type="hidden" class="hiden-items-attribute" value="'+title+'" name="items[attribute][]">'
							+ '<input type="hidden" class="hiden-items-options-responsive" value="r" name="items[options][responsive][]">'
							+ '<input type="hidden" class="hiden-items-type" value="'+type+'" name="items[options][type][]">'
							+ '<textarea name="items[subitem][]" class="hiden-items-subitem" style="display:none;"></textarea>'
							+ '<textarea name="items[html][]" class="hiden-items-html" style="display:none;"></textarea>'
						+ '<label class="menu-title">'+title+'</label> <span class="pull-right item-config">'+type+' <i class="fa fa-caret-down"></i></span></li>';
				items.append(li);
				panel.find('input.custom-url').val('');
				panel.find('input.custom-title').val('');
			}
			items.sortable();
			$btn.button('reset');
			this.ini();
		},
		remove: function(){
			this.elm.remove();
			jQuery('.menu-items-config').hide('show');
		},
		sumenu: function(e){			
			if (grid.module.elment.children('ul.list-menu').length == 0)
			{				
				grid.module.elment.append('<ul class="list-menu"></ul>');
			}
			
			var ul = grid.module.elment.children('ul.list-menu');			
			
			jQuery('#list-modules input[type=checkbox]').each(function(){
				if (jQuery(this).is(':checked') == true)
				{
					jQuery(this).prop('checked', false);
					var title 	= jQuery(this).data('title');
					var link 	= jQuery(this).data('link');
					var li = '<li class="menu-item">'
							+ 	'<div class="text-editline"><a href="'+site_url+link+'" title="'+title+'">'+title+'</a></div>'						
							+ 	'<div class="js-elment js-menu">'							
							+ 		'<button class="btn btn-default btn-xs" onclick="grid.menu.edit(this)" type="button" title="Click to edit"><i class="glyphicon glyphicon-pencil"></i></button>'
							+ 		'<button class="btn btn-default btn-xs" onclick="jQuery(this).parents(\'.menu-item\').remove()" type="button" title="Click to remove"><i class="glyphicon glyphicon-trash"></i></button>'
							+ 	'</div>'
							+ 	'<div class="js-elment js-handle btn btn-default btn-xs">'							
							+ 		'<i class="fa fa-arrows-alt"></i>'
							+ 	'</div>'
							+ '</li>';
					ul.append(li);
				}
			});
			
			var title = jQuery('#sub-tab-links .custom-title').val();
			var link = jQuery('#sub-tab-links .custom-url').val();
			if (title != '' && url != '')
			{
				var li = '<li class="menu-item">'
						+ 	'<div class="text-editline"><a href="'+link+'" title="'+title+'">'+title+'</a></div>'
						+ 	'<div class="js-elment js-menu">'							
						+ 		'<button class="btn btn-default btn-xs" onclick="grid.menu.edit(this)" type="button" title="Click to edit"><i class="glyphicon glyphicon-pencil"></i></button>'
						+ 		'<button class="btn btn-default btn-xs" onclick="jQuery(this).parents(\'.menu-item\').remove()" type="button" title="Click to remove"><i class="glyphicon glyphicon-trash"></i></button>'
						+ 	'</div>'
						+ 	'<div class="js-elment js-handle btn btn-default btn-xs">'							
						+ 		'<i class="fa fa-arrows-alt"></i>'
						+ 	'</div>'
						+ '</li>';
				ul.append(li);
				jQuery('#sub-tab-links .custom-title').val('');
				jQuery('#sub-tab-links .custom-url').val('');
			}
			
			tinyMCE.triggerSave();
			var html = jQuery('.text-edittor').html();
			
			if (html != '')
			{
				var li = '<li class="menu-item">'
						+ 	'<div class="text-editline">'+html+'</div>'
						+ 	'<div class="js-elment js-menu">'							
						+ 		'<button class="btn btn-default btn-xs" onclick="grid.menu.edit(this)" type="button" title="Click to edit"><i class="glyphicon glyphicon-pencil"></i></button>'
						+ 		'<button class="btn btn-default btn-xs" onclick="jQuery(this).parents(\'.menu-item\').remove()" type="button" title="Click to remove"><i class="glyphicon glyphicon-trash"></i></button>'
						+ 	'</div>'
						+ 	'<div class="js-elment js-handle btn btn-default btn-xs">'							
						+ 		'<i class="fa fa-arrows-alt"></i>'
						+ 	'</div>'
						+ '</li>';
				ul.append(li);
				jQuery('.text-edittor').html('');
				tinyMCE.activeEditor.setContent('');
			}
			jQuery('#list-modules').modal('hide');
			jQuery( "ul.list-menu" ).sortable({handle: ".js-handle"});
		},
		edit: function(e){
			if (typeof tinymce != 'undefined' && tinymce.activeEditor != null)
			{
				tinymce.activeEditor.destroy();
			}
			
			
			var elm = jQuery(e).parents('.menu-item').children('.text-editline');
			if (elm.attr('id') == null)
			{
				var id 	= 'editline-' + Math.random().toString(36).substring(7);
				elm.attr('id', id);
			}
			else
			{
				var id = elm.attr('id');
			}
			tinymce.init({
				selector: '#'+id,
				toolbar_items_size: 'small',
				inline: true,
				forced_root_block : "", 
				force_br_newlines : true,
				force_p_newlines : false,
				convert_urls: false,
				setup: function(editor) {
					editor.addButton('iniSave', {
						text: 'Save',
						icon: false,
						onclick: function() {
							tinymce.editors[id].remove();
						}
					});
				 },				
				 plugins: [
					"advlist autolink lists link image charmap print preview anchor",
					"searchreplace visualblocks",
					"insertdatetime media table contextmenu paste textcolor dgmedia"
				],
				toolbar: "undo redo | forecolor backcolor | bold italic | alignleft aligncenter alignright | link image dgmedia | iniSave",
				menubar: false
			});
			if (typeof tinymce.editors[id] != 'undefined')
			{
				tinymce.editors[id].execCommand('mceAddControl', true, id);
			}			
		},
		save: function(){
			if (typeof tinymce != 'undefined' && tinymce.activeEditor != null)
			{
				tinymce.activeEditor.destroy();
			}
			var title 		= jQuery('.config-item-title').val();
			var url			= jQuery('.config-item-url').val();
			var attribute	= jQuery('.config-item-attribute').val();
			this.elm.data('title', title);
			this.elm.children('.menu-title').html(title);
			this.elm.data('link', url);
			this.elm.data('attribute', attribute);
			
			this.elm.find('.hiden-items-title').val(title);
			this.elm.find('.hiden-items-url').val(url);
			this.elm.find('.hiden-items-attribute').val(attribute);
			
			this.elm.find('.hiden-items-options-responsive').val(jQuery('.option-menu-responsive').val());
			
			var html 	= jQuery('#main-app').html();				
			var content = jQuery("<div/>").append(jQuery('.js-elment', html).remove().end()).html();			
			
			if (this.elm.children('.hiden-items-subitem').length == 0)
			{
				this.elm.append('<textarea name="items[subitem][]" class="hiden-items-subitem" style="display:none;">'+content+'</textarea>');
			}
			else
			{
				this.elm.children('.hiden-items-subitem').val(content);
			}
			
			if (this.elm.children('.hiden-items-html').length == 0)
			{
				this.elm.append('<textarea name="items[html][]" class="hiden-items-html" style="display:none;">'+html+'</textarea>');
			}
			else
			{
				this.elm.children('.hiden-items-html').val(html);
			}
			jQuery('.text-success').show('show');
		},
		config: function(e){
			this.elm 		= e;
			var id 			= e.data('id');
			var link 		= e.data('link');
			var attribute 	= e.data('attribute');
			var title 		= e.children('.menu-title').html();
			var html 		= e.children('.hiden-items-html').val();
			var responsive 	= e.children('.hiden-items-options-responsive').val();
			
			jQuery('#main-app').html(jQuery.parseHTML(html));
			jQuery('.config-item-title').val(title);
			jQuery('.config-item-url').val(link);
			jQuery('.config-item-attribute').val(attribute);
			jQuery('.option-menu-responsive').val(responsive);
			
			jQuery('.text-success').hide();
			jQuery( "ul.list-menu" ).sortable();				
		},
		col: function(e){
			var number = e.value;
			var cols = Math.round(12/number);
			
			if ( (cols * number) != 12 )
				var n = number - 1;
			else
				var n = number;
			
			var div = jQuery('#submenu-list');
			div.html('');
			for(i=0; i<n; i++)
			{
				var row = '<div class="col-sm-'+cols+' col-md-'+cols+'">'
						+ 	'<div class="submenu-head"></div>';
						+ 	'<ul class="submenu-footer"></ul>';
						+ 	'<div class="submenu-footer"></div>';
						+ '</div>'
				div.append(row);
			}
			
			if (number != n)
			{
				cols = 12- (cols * n);
				var row = '<div class="col-sm-'+cols+' col-md-'+cols+'">Submenu</div>';
				div.append(row);
			}
		},
		ini: function(){
			jQuery('.item-config').click(function(){
				jQuery('.menu-items-config').show('show');
				var elm = jQuery(this).parent();
				grid.menu.config(elm);
			});
			jQuery('.items-sidebar .close').click(function(){
				jQuery('.menu-items-config').hide('show');
			});
			jQuery('.items-menu > li').click(function(){
				jQuery('.items-menu > li').removeClass('active');
				jQuery(this).addClass('active');
				
				jQuery('.items-right .config-tabs').removeClass('active');
				
				var tab = jQuery(this).data('tab');
				jQuery('.items-right .config-tab-'+tab).addClass('active');
			});
		}		
	}
}
// button add module
grid.bModule 	= '<div class="js-elment js-button"><center>'
				+ 	'<a class="btn btn-primary btn-sm" onclick="grid.module.view(this)" href="javascript:void(0)">'
				+ 		'<i class="glyphicon glyphicon-plus"></i>'
				+ 	'</a>'
				+ '</center></div>';
// button group add, remove row
grid.bGModule 	= '<div class="js-elment js-button"><center><div class="btn-group">'
				+ 	'<button class="btn btn btn-teal btn-xs" onclick="grid.module.view(this)">'
				+ 		'<i class="fa fa-plus"></i>'
				+ 	'</button>'
				+ 	'<button class="btn btn btn-teal btn-xs" onclick="grid.row.remove(this)">'
				+ 		'<i class="fa fa-trash-o"></i>'
				+ 	'</button>'
				+ '</div></center></div>';
// button group active add, edit, remove row
grid.bAModule 	= '<div class="js-elment js-button"><center><div class="btn-group">'
				+ 	'<button class="btn btn btn-teal btn-xs js-control-edit">'
				+ 		'<i class="fa fa-pencil"></i>'
				+ 	'</button>'
				+ 	'<button class="btn btn btn-teal btn-xs" onclick="grid.module.view(this)">'
				+ 		'<i class="fa fa-plus"></i>'
				+ 	'</button>'
				+ 	'<button class="btn btn btn-teal btn-xs" onclick="grid.row.remove(this)">'
				+ 		'<i class="fa fa-trash-o"></i>'
				+ 	'</button>'
				+ '</div></center></div>';
grid.config 	= '<div class="js-elment js-button"><center>'
				+ 	'<a class="btn btn-default btn-sm" onclick="grid.row.layout(this)" href="javascript:void(0)">'
				+ 		'<i class="glyphicon glyphicon-cog"></i>'
				+ 	'</a>'
				+ '</center></div>';
grid.jsControlR	= '<div class="js-elment js-control">'
				+	'<div class="js-control-col btn-group">'
				+ 		'<button type="button" class="btn-xs btn-elment-row btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'
				+ 			'<span class="js-control-text">Row</span> <span class="caret"></span>'
				+ 		'</button>'
				+ 		'<ul class="dropdown-menu" role="menu">'
				+ 			'<li><a href="javascript:void(0)" onclick="grid.row.config(this, \'row\')"><i class="fa fa-wrench"></i> Settings</a></li>'
				+ 			'<li><a href="javascript:void(0)" onclick="grid.row.layout(this)"><i class="clip-grid"></i> Change layout</a></li>'
				+ 			'<li><a href="javascript:void(0)" onclick="grid.row.add(this)"><i class="glyphicon glyphicon-plus"></i> Add new row</a></li>'
				+ 			'<li><a href="javascript:void(0)" onclick="grid.row.remove(this)"><i class="glyphicon glyphicon-trash"></i> Delete row</a></li>'
				+ 		'</ul>'
				+ 	'</div>'
				+ '</div>';
				
grid.jsControlC	= '<div class="js-elment js-control">'
				+ 	'<div class="js-control-col btn-group">'
				+ 		'<button type="button" class="btn-xs btn-elment-col btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">'
				+ 			'<span class="js-control-text">Column</span> <span class="caret"></span>'
				+ 		'</button>'
				+ 		'<ul class="dropdown-menu" role="menu">'				
				+ 			'<li><a href="javascript:void(0)" onclick="grid.col.config(this)"><i class="fa fa-wrench"></i> Settings</a></li>'
				+ 			'<li><a href="javascript:void(0)" onclick="grid.col.addRow(this)"><i class="clip-list-5"></i> Add new row</a></li>'
				+ 			'<li><a href="javascript:void(0)" onclick="grid.col.remove(this)"><i class="glyphicon glyphicon-trash"></i> Delete column</a></li>'
				+ 		'</ul>'
				+ 	'</div>'							
				+ '</div>';