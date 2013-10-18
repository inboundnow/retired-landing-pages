(function($) {


	var InboundShortcodes = {
		
		generate: function() {
			
			var output = $('#_fresh_shortcodes_output').text(),
				newoutput = output;
				
			$('.inbound-shortcodes-input').each(function() {
				var input = $(this),
					theid = input.attr('id'),
					id = theid.replace('inbound_shortcode_', ''), 
					re = new RegExp('{{'+id+'}}', 'g');
					
				if( input.is(':checkbox') ) {
					var val = ( $(this).is(':checked') ) ? '1' : '0';
					newoutput = newoutput.replace(re, val);
				} 
				else {
					newoutput = newoutput.replace(re, input.val());
				}
				// Add fix to remove empty params. maybe
				//console.log(newoutput);
				 
			});
			
			$('#_fresh_shortcodes_newoutput').remove();
			$('#inbound-shortcodes-form-table').prepend('<div id="_fresh_shortcodes_newoutput" class="hidden">' + newoutput + '</div>');
			
			InboundShortcodes.updatePreview();
			
		},
		
		generateChild : function() {
			
			var output = $('#_fresh_shortcodes_child_output').text(),
				parent_output = '',
				outputs = '';
				
			$('.child-clone-row').each(function() {
				
				var row = $(this),
					row_output = output;
				
				$('.inbound-shortcodes-child-input', this).each(function() {
					var input = $(this),
						theid = input.attr('id'),
						id = theid.replace('inbound_shortcode_', ''), 
						re = new RegExp('{{'+id+'}}', 'g');
					
					if( input.is(':checkbox') ) {
						var val = ( $(this).is(':checked') ) ? '1' : '0';
						row_output = row_output.replace(re, val);
					} 
					else {
						row_output = row_output.replace(re, input.val());
					}
					//console.log(newoutput);
				});
				
				outputs = outputs + row_output + "\n";
			});
			
			$('#_fresh_shortcodes_child_newoutput').remove();
			$('.child-clone-rows').prepend('<div id="_fresh_shortcodes_child_newoutput" class="hidden">' + outputs + '</div>');
			
			this.generate();
			parent_output = $('#_fresh_shortcodes_newoutput').text().replace('{{child}}', outputs);
			
			$('#_fresh_shortcodes_newoutput').remove();
			$('#inbound-shortcodes-form-table').prepend('<div id="_fresh_shortcodes_newoutput" class="hidden">' + parent_output + '</div>');
			
			InboundShortcodes.updatePreview();
			
		},


		children : function() {
			function row_add_callback()
			{
				var length = jQuery('.child-clone-row').length;
				//jQuery('.child-clone-row').last().attr('id', 'row-'+length);
		
				jQuery('.form-field-row-number').each(function(i){
					var addition = i + 1;
					jQuery(this).text(addition);
					jQuery(this).parent().attr('id', 'row-'+addition);
				});
				console.log(length);
				jQuery('.child-clone-row .minimize-class').not( "#row-" + length + " .minimize-class").addClass('tog-hide-it');
				jQuery('.child-clone-row-shrink').not( "#row-" + length + " .child-clone-row-shrink").text("Expand");
				InboundShortcodes.generate(); // runs refresh
				InboundShortcodes.generateChild();
				//InboundShortcodes.updatePreview();
			}
			$('.child-clone-rows').appendo({
				subSelect: '> div.child-clone-row:last-child',
				allowDelete: false,
				focusFirst: false,
				onAdd: row_add_callback
			});
			jQuery("body").on('click', '.child-clone-row', function () {
				var exlcude_id = jQuery(this).attr('id');
				console.log(exlcude_id);
				jQuery('.child-clone-row .minimize-class').not( "#" + exlcude_id + " .minimize-class").addClass('tog-hide-it');
				jQuery(this).find(".minimize-class").removeClass('tog-hide-it');
				jQuery(this).find('.child-clone-row-shrink').text("Minimize");
    		});
    		// Clone Field values
    		jQuery("body").on('click', '.child-clone-row-exact', function () {
    			var	btn = $(this),
    			clone_box = btn.parent();
    			var new_clone = clone_box.clone();
    			jQuery(clone_box).after(new_clone);
    			row_add_callback();
    		});
    		// Shrink Rows
			$("body").on('click', '.child-clone-row-shrink', function () {
				var	btn = $(this),
				btn_class = btn.hasClass('shrunken'),
				row = btn.parent();
				console.log('clicked');
				if (btn_class === false ){
					console.log('nope.');
					btn.addClass('shrunken');
					row.find(".minimize-class").addClass('tog-hide-it');
					btn.text("Expand");
				} else {
					console.log('yep');
					btn.removeClass('shrunken');
					row.find(".minimize-class").removeClass('tog-hide-it');
					btn.text("minimize");
				}
				
				return false;
			});
			
			$('.child-clone-row-remove').live('click', function() {
				var	btn = $(this),
				row = btn.parent();

				
				if( $('.child-clone-row').size() > 1 ){
					row.remove();
					row_add_callback();
				}
				else {
					alert('You need a minimum of one row');
				}
				return false;
			});

			
			$('.child-clone-rows').sortable({
				placeholder: 'sortable-placeholder',
				items: '.child-clone-row',
				stop: row_add_callback
			});
			
		},
		
		updatePreview : function() {
			
			if( $('#inbound-shortcodes-preview').size() > 0 ) {
				
				var	shortcode = $('#_fresh_shortcodes_newoutput').html(),
					iframe = $('#inbound-shortcodes-preview'),
					theiframeSrc = iframe.attr('src'),
					thesiframeSrc = theiframeSrc.split('preview.php'),
					iframeSrc = thesiframeSrc[0] + 'preview.php';
							
				// updates the src value
				iframe.attr( 'src', iframeSrc + '?sc=' + InboundShortcodes.htmlEncode(shortcode) );
				
				console.log('updated iframe');
				// update the height
				$('#inbound-shortcodes-preview').height( $('#inbound-shortcodes-popup').outerHeight()-72 );
				
				
			}
			
		},
		
		resizeTB : function() {
			
			var	ajaxCont = $('#TB_ajaxContent'),
				tbWindow = $('#TB_window'),
				freshthemesPopup = $('#inbound-shortcodes-popup'),
				no_preview = ($('#_fresh_shortcodes_preview').text() == 'false') ? true : false;
				
			if( no_preview ) {
				ajaxCont.css({
					paddingTop: 0,
					paddingLeft: 0,
					height: (tbWindow.outerHeight()-47),
					overflow: 'scroll',
					width: 562
				});
			
				tbWindow.css({
					width: ajaxCont.outerWidth(),
					marginLeft: -(ajaxCont.outerWidth()/2)
				});
			
				$('#inbound-shortcodes-popup').addClass('no_preview');
			} 
			
			else {
				ajaxCont.css({
					padding: 0,
					// height: (tbWindow.outerHeight()-47),
					height: freshthemesPopup.outerHeight()-15,
					overflow: 'scroll' // IMPORTANT
				});
				
				tbWindow.css({
					width: ajaxCont.outerWidth(),
					height: (ajaxCont.outerHeight() + 30),
					marginLeft: -(ajaxCont.outerWidth()/2),
					marginTop: -((ajaxCont.outerHeight() + 47)/2),
					top: '50%'
				});
			}
			
		},
		
		load : function() {
			
			var	InboundShortcodes = this,
				popup = $('#inbound-shortcodes-popup'),
				form = $('#inbound-shortcodes-form', popup),
				output = $('#_fresh_shortcodes_output', form).text(),
				popupType = $('#_fresh_shortcodes_popup', form).text(),
				newoutput = '';
				
			InboundShortcodes.resizeTB();
			$(window).resize(function() {
				InboundShortcodes.resizeTB();
			});
			
			InboundShortcodes.generate();
			InboundShortcodes.children();
			InboundShortcodes.generateChild();
			
			
			$('body').on('change, keyup', '.inbound-shortcodes-child-input', function() {
				InboundShortcodes.generateChild(); // runs refresh for children
			});

			$('.inbound-shortcodes-input', form).on('change, keyup', function () {
				InboundShortcodes.generate(); // runs refresh
				InboundShortcodes.generateChild();
			});

			$('body').on('change', 'input[type="checkbox"], input[type="radio"], select', function () {
				InboundShortcodes.generateChild(); // runs refresh for fields
			});

			$("body").on('click', '.show-advanced-fields', function () {
					var active = $(this).hasClass("hide-advanced-options");
					console.log(active);
					if(active == false) {
					$(this).parent().parent().parent().parent().find(".inbound-tab-class-advanced").show();
					$(this).addClass("hide-advanced-options");
					$(this).text("Hide advanced options");
					} else {
					$(this).parent().parent().parent().parent().find(".inbound-tab-class-advanced").hide();
					$(this).removeClass("hide-advanced-options");
					$(this).text("Show advanced options");	
					}
    		});


			$('body').on('change', 'select', function () {
				var find_this = jQuery(this).attr('data-field-name'),
				this_val = jQuery(this).val();
				jQuery(".dynamic-visable-on").hide();
				jQuery('.reveal-' + this_val).removeClass('inbound-hidden-row').show().addClass('dynamic-visable-on');
			});
			
			$('.inbound-shortcodes-insert', form).click(function() {    
				var shortcode_name = jQuery("#inbound_current_shortcode").val();
				var form_name = jQuery("#inbound_shortcode_form_name").val();
				if ( shortcode_name === "insert_inbound_form_shortcode" && form_name == "") {
					alert("Please Insert a Form Name!");
				} else {	 			
					if(window.tinyMCE) {
							var insert_val = $('#_fresh_shortcodes_newoutput', form).html();
							if ( shortcode_name === "insert_inbound_form_shortcode") {
							var fixed_insert_val = insert_val.replace(/\[.*?(.*?)\]/g, "[$1]<br class='inbr'/>"); // for linebreaks in editor
							} else {
							var fixed_insert_val = insert_val;
							}
							window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, fixed_insert_val);
							tb_remove();
					}
				}
			});
		},

		htmlEncode: function(html) {
			return $('<div/>').text(html).html();
		}
		
	};
	


	$(document).ready( function() {
		$('#inbound-shortcodes-popup').livequery( function() { 
			InboundShortcodes.load();
		});
	});
	
})(jQuery);