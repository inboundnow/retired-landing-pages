<?php

add_filter('lp_js_hook_submit_form_success','lp_lead_collection_js');

function lp_lead_collection_js()
{	
	$current_page = "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
	$post_id = lp_url_to_postid($current_page);
	(isset($_SERVER['HTTP_REFERER'])) ? $referrer = $_SERVER['HTTP_REFERER'] : $referrer ='direct access';	
	(isset($_SERVER['REMOTE_ADDR'])) ? $ip_address = $_SERVER['REMOTE_ADDR'] : $ip_address = '0.0.0.0.0';

	do_action('lp-lead-collection-add-js-pre'); 
	
	?>	
	// Landing Page Lead storage
	var email = jQuery(".lp-email-value input").val();
	var firstname = jQuery(".lp-first-name-value input").val();
	var lastname = jQuery(".lp-last-name-value input").val();
	submit_halt = 1;
	
	//alert('1');
	if (!email)
	{
		 jQuery("#lp_container_form input[type=text]").each(function() {
			if (this.value)
			{
				if (jQuery(this).attr("name").toLowerCase().indexOf('email')>-1) {
					email = this.value;
				}
				else if(jQuery(this).attr("name").toLowerCase().indexOf('name')>-1&&!firstname) {
					 firstname = this.value;
				}
				else if (jQuery(this).attr("name").toLowerCase().indexOf('name')>-1) {
					 lastname = this.value;
				}
			}
		});
	}
	else
	{		
		if (!lastname&&jQuery("input").eq(1).val().indexOf("@") === -1)
		{
			lastname = jQuery("input").eq(1).val();
		}
	}
	
	if (!email)
	{
		jQuery("#lp_container_form input[type=text]").each(function() {
			if (jQuery(this).closest('li').children('label').length>0)
			{
				if (jQuery(this).closest('li').children('label').html().toLowerCase().indexOf('email')>-1) 
				{
					email = this.value;
				}
				else if (jQuery(this).closest('li').children('label').html().toLowerCase().indexOf('name')>-1&&!firstname) {
					firstname = this.value;
				}
				else if (jQuery(this).closest('li').children('label').html().toLowerCase().indexOf('name')>-1) {
					lastname = this.value;
				}
			}
		});
	}
	
	if (!email)
	{
		jQuery("#lp_container_form input[type=text]").each(function() {
			if (jQuery(this).closest('div').children('label').length>0)
			{
				if (jQuery(this).closest('div').children('label').html().toLowerCase().indexOf('email')>-1) 
				{
					email = this.value;
				}
				else if (jQuery(this).closest('div').children('label').html().toLowerCase().indexOf('name')>-1&&!firstname) {
					firstname = this.value;
				}
				else if (jQuery(this).closest('div').children('label').html().toLowerCase().indexOf('name')>-1) {
					lastname = this.value;
				}
			}
		});
	}
	
	
	if (!lastname&&firstname)
	{
		var parts = firstname.split(" ");
		firstname = parts[0];
		lastname = parts[1];
	}
	
	var form_inputs = jQuery('#lp_container_form form').find('input[type=text],textarea,select');

    var post_values = {};
    form_inputs.each(function() {
        post_values[this.name] = jQuery(this).val();
    });	
    var post_values_json = JSON.stringify(post_values);
	var wp_lead_uid = jQuery.cookie("wp_lead_uid");
	var page_views = JSON.stringify(pageviewObj);
	jQuery.cookie("wp_lead_email", email, { path: '/', expires: 365 });
	var current_variation = <?php $variation = (isset($_GET['lp-variation-id'])) ? $_GET['lp-variation-id'] : '0'; echo  $variation ;?>;	
	jQuery.ajax({
		type: 'POST',
		url: '<?php echo admin_url('admin-ajax.php') ?>',
		data: {
			action: 'inbound_store_lead',
			emailTo: email, 
			first_name: firstname, 
			last_name: lastname,
			wp_lead_uid: wp_lead_uid,
			page_views: page_views,
			raw_post_values_json : post_values_json,
			lp_v: current_variation,
			lp_id: '<?php echo $post_id; ?>'<?php 
				do_action('lp-lead-collection-add-ajax-data'); 
			?>
		},
		success: function(user_id){
			jQuery.cookie("wp_lead_id", user_id, { path: '/', expires: 365 });
			jQuery.totalStorage('wp_lead_id', user_id); 
				if (form_id)
				{
					jQuery('form').unbind('submit');
					jQuery('#lp_container_form form').submit();
					//jQuery('#'+form_id+':input[type=submit]').click();
				}
				else
				{
					this_form.unbind('submit');
					this_form.submit();
				}
			   },
		error: function(MLHttpRequest, textStatus, errorThrown){
				//alert(MLHttpRequest+' '+errorThrown+' '+textStatus);
				//die();
				submit_halt =0;
			}

	});
	<?php
}