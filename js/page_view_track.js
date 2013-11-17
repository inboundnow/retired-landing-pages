 jQuery(document).ready(function($) {
 	// Saves variation page views
 	var variation_id = landing_path_info.variation;
 	// Save page view count
	jQuery.ajax({
		type: 'POST',
		url: landing_path_info.admin_url,
		data: {
			action: 'lp_record_impression',
			current_url: window.location.href,
			variation_id: variation_id
			// add date?	
		},
		success: function(user_id){
			//console.log('LP Page View Fired');	
			   },
		error: function(MLHttpRequest, textStatus, errorThrown){
				//alert(MLHttpRequest+' '+errorThrown+' '+textStatus);
				//die();
			}

	});

 });	