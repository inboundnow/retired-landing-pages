(function($) {

	// Row add function
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
				jQuery('.child-clone-row').last().find('input').first().focus(); // focus on new input
				//InboundShortcodes.updatePreview();
			}

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
				
				//console.log('updated iframe');
				// update the height
				//$('#inbound-shortcodes-preview').height( $('#inbound-shortcodes-popup').outerHeight()-72 );
				
				
			}
			
		},
		
		resizeTB : function() {
			
			var	ajaxCont = $('#TB_ajaxContent'),
				tbWindow = $('#TB_window'),
				freshthemesPopup = $('#inbound-shortcodes-popup'),
				no_preview = ($('#_fresh_shortcodes_preview').text() == 'false') ? true : false;
			var width = $(window).width();
			var H = $(window).height();
			var W = ( 1720 < width ) ? 1720 : width;
			var this_height = ajaxCont.height();
			console.log(this_height);	
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
				// full screen fix
				if ( tbWindow.size() ) {
				tbWindow.width( W - 150 ).height( H - 75 );
				ajaxCont.width( W - 150 ).height( H - 95 );
				tbWindow.css({'margin-left': '-' + parseInt((( W - 150 ) / 2),10) + 'px'});
				
				if ( typeof document.body.style.maxWidth != 'undefined' )
					tbWindow.css({'top':'40px','margin-top':'0'});
				//$('#TB_title').css({'background-color':'#fff','color':'#cfcfcf'});
				}; 
				// Old css
				/*tbWindow.css({
					width: ajaxCont.outerWidth(),
					height: (ajaxCont.outerHeight() + 30),
					marginLeft: -(ajaxCont.outerWidth()/2),
					marginTop: -((ajaxCont.outerHeight() + 47)/2),
					top: '50%'
				}); */
			}
			
		},
		
		load : function() {
			
			var	InboundShortcodes = this,
				popup = $('#inbound-shortcodes-popup'),
				form = $('#inbound-shortcodes-form', popup),
				output = $('#_fresh_shortcodes_output', form).text(),
				popupType = $('#_fresh_shortcodes_popup', form).text(),
				shortcode_name = jQuery("#inbound_current_shortcode").val(),
				newoutput = '';
				
			InboundShortcodes.resizeTB();
			$(window).resize(function() {
				InboundShortcodes.resizeTB();
			});
			
			InboundShortcodes.generate();
			InboundShortcodes.children();
			InboundShortcodes.generateChild();
			
			// Conditional Form Only extras 
			if ( shortcode_name === "insert_inbound_form_shortcode") {
				jQuery(".inbound_shortcode_child_tbody, .main-design-settings").hide();
				$("#inbound_save_form").show();

				$('.step-item').on('click', function() {
				  $(this).addClass('active').siblings().removeClass('active');
				  var show = $(this).attr('data-display-options');
				  jQuery('.inbound_tbody').hide();
				  jQuery(show).show();
				});	
				// Insert default forms
				$('body').on('change', '#inbound_shortcode_insert_default', function () {
					var insert_form = $(this).val();
					var form_insert = window[insert_form];
					if ($('.child-clone-row').length != "1") {
						if (confirm('Are you sure you want to overwrite the current form you are building? Selecting another form template will clear your current fields/settings')) {
	            			jQuery(".child-clone-rows.ui-sortable").html(form_insert);
	        			} else {
	        				$(this).val($.data(this, 'current')); // added parenthesis (edit)
            				return false;
	        			}
        			} else {
        				jQuery(".child-clone-rows.ui-sortable").html(form_insert);
        			}
					
					$.data(this, 'current', $(this).val());
					// After change run
					/* setTimeout(function() {
	                //InboundShortcodes.generate(); // runs refresh
					//InboundShortcodes.generateChild();
					 $('.child-clone-rows').appendo({
					subSelect: '> div.child-clone-row:last-child',
					allowDelete: false,
					focusFirst: false,
					onAdd: row_add_callback
					});
					$('.child-clone-rows').sortable({
					placeholder: 'sortable-placeholder',
					items: '.child-clone-row',
					stop: row_add_callback
					});
	        		}, 500); */
				});
			}
			// Save Shortcode Function
			var shortcode_nonce_val = inbound_shortcodes.inbound_shortcode_nonce; // NEED CORRECT NONCE
			$("body").on('click', '#inbound_save_form', function () {
			  		console.log('Save clicked');
			        // if data exists save it
			        //var this_meta_id = jQuery(this).attr("id");
			        var post_id = jQuery("#post_ID").val();
			      	var form_settings = jQuery(".child-clone-rows.ui-sortable").html();
			        var shortcode_name = jQuery("#inbound_current_shortcode").val();
			        var shortcode_value = jQuery('#_fresh_shortcodes_newoutput').html();
					var form_name = jQuery("#inbound_shortcode_form_name").val();
					if ( shortcode_name === "insert_inbound_form_shortcode" && form_name == "") {
						jQuery(".step-item.first").click();
						alert("Please Insert a Form Name!");
						jQuery("#inbound_shortcode_form_name").addClass('need-value').focus();
					} else {
			        jQuery.ajax({
			            type: 'POST',
			            url: ajaxurl,
			            context: this,
			            data: {
			                action: 'inbound_form_save',
			                name: form_name,
			                shortcode: shortcode_value,
			               	form_settings: form_settings,
			                post_id: post_id,
			                nonce: shortcode_nonce_val
			            },

			            success: function (data) {
			                var self = this;

						    console.log(data);
			                var str = data;
			                var new_post = str.substring(0, str.length - 1);
			                console.log(new_post);
			                var post_id_final = new_post.replace('"', '');
			                var site_base = window.location.origin + '/wp-admin/post.php?post=' + post_id_final + '&action=edit';
			                // jQuery('.lp-form').unbind('submit').submit();
			                //var worked = '<span class="success-message-map">Success! ' + this_meta_id + ' set to ' + meta_to_save + '</span>';
			                var worked = '<span class="lp-success-message">Form Created & Saved</span><a style="padding-left:10px;" target="_blank" href="' + site_base  +'" class="event-view-post">View/Edit Form</a>';
			                var s_message = jQuery(self).parent();
			                jQuery(worked).appendTo(s_message);
			                jQuery(self).hide();
			                //alert("Event Created");
			            },

			            error: function (MLHttpRequest, textStatus, errorThrown) {
			                alert("Ajax not enabled");
			            }
			        });
			     }
			        return false;
			});
		
			$('body').on('change, keyup', '.inbound-shortcodes-child-input', function() {
				InboundShortcodes.generateChild(); // runs refresh for children
				var update_dom = $(this).val();
				$(this).attr('value', update_dom);
			});

			$('.inbound-shortcodes-input', form).on('change, keyup', function () {
				InboundShortcodes.generate(); // runs refresh
				InboundShortcodes.generateChild();
				var update_dom = $(this).val();
				$(this).attr('value', update_dom);
			});

			$('body').on('change', 'input[type="checkbox"], input[type="radio"], select', function () {
				InboundShortcodes.generateChild(); // runs refresh for fields
				var input_type = jQuery(this).attr('type');
				var update_dom = jQuery(this).val();
				if (input_type === "checkbox") {
					var checked = $(this).is(":checked");
					if (checked === true){
					  $(this).attr('checked',true);
					} else {
						$(this).removeAttr( "checked" );
					}
					
				} else if (input_type === "radio") {

				} else {
					$(this).find("option").removeAttr( "selected" );
					$(this).find("option[value='"+update_dom+"']").attr('selected', update_dom);

				}
				
			});

			$("body").on('click', '.show-advanced-fields', function () {
			
					$(this).parent().parent().parent().parent().find(".inbound-tab-class-advanced").show();
					$(this).removeClass("show-advanced-fields");
					$(this).addClass("hide-advanced-options");
					$(this).text("Hide advanced options");
					
    		});
    		$("body").on('click', '.hide-advanced-options', function () {
			
					$(this).parent().parent().parent().parent().find(".inbound-tab-class-advanced").hide();
					$(this).removeClass("hide-advanced-options");
					$(this).text("Show advanced options");
					$(this).addClass("show-advanced-fields");	
	
    		});


			$('body').on('change', 'select', function () {
				var find_this = jQuery(this).attr('data-field-name'),
				this_val = jQuery(this).val();
				jQuery(".dynamic-visable-on").hide();
				jQuery('.reveal-' + this_val).removeClass('inbound-hidden-row').show().addClass('dynamic-visable-on');
			});
			jQuery("body").on('click', '.inbound-shortcodes-insert-two', function () {
				$('.inbound-shortcodes-insert').click();
    		});
    		jQuery("body").on('click', '.inbound-shortcodes-insert-cancel', function () {
    			window.tb_remove();
    		});
			$('.inbound-shortcodes-insert', form).click(function() {    
				var shortcode_name = jQuery("#inbound_current_shortcode").val();
				var form_name = jQuery("#inbound_shortcode_form_name").val();
				if ( shortcode_name === "insert_inbound_form_shortcode" && form_name == "") {
					jQuery(".step-item.first").click();
					alert("Please Insert a Form Name!");
					jQuery("#inbound_shortcode_form_name").addClass('need-value').focus();
				} else {	 			
					if(window.tinyMCE) {
							var insert_val = $('#_fresh_shortcodes_newoutput', form).html();

							if ( shortcode_name === "insert_inbound_form_shortcode") {
							//var fixed_insert_val = insert_val.replace(/\[.*?(.*?)\]/g, "[$1]<br class='inbr'/>"); // for linebreaks in editor
							var fixed_insert_val = insert_val.replace(/\[.*?(.*?)\]/g, "<p>[$1]</p>"); // cleans output in editor
							output_cleaned = fixed_insert_val.replace(/[a-zA-Z0-9_]*=""/g, ""); // remove empty shortcode fields
							//output_cleaned = "<!-- Beginning of Form Embed -->" + output_cleaned + "<!-- End of Form Embed -->";
							} else {
							var fixed_insert_val = insert_val;
							output_cleaned = fixed_insert_val.replace(/[a-zA-Z0-9_]*=""/g, ""); // remove empty shortcode fields
							}
							window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, output_cleaned);
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