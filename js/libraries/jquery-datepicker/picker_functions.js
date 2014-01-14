jQuery(document).ready(function ($) {

	jQuery('.time-picker').timepicker({ 'timeFormat': 'H:i' });

	if ($('.current_lander .new-date').length) { // implies *not* zero
		var current_val = jQuery(".current_lander .new-date").val();
  	} else {
		var current_val = jQuery(".new-date").val();
  	}
  	// if no timepicker in options fix it
  	if (typeof (current_val) == "undefined" || current_val === null || current_val == "") {
  		var current_val = '';
  	}


	var ret = current_val.split(" ");
	var current_date = ret[0];
	var current_time = ret[1];
	jQuery(".jquery-date-picker .date.start").val(current_date);
	jQuery(".jquery-date-picker .time-picker").val(current_time);

	jQuery('.lp_select_template').live('click', function() {
		var template = jQuery(this).attr('id');
		jQuery("#date-picker-"+template).val(current_date).addClass("live_date");
		jQuery("#time-picker-"+template).val(current_time).addClass("live_time");
	});

	jQuery("body").on('change', '.jquery-date-picker .date.start, .jquery-date-picker .time-picker', function () {
		var date_chosen = jQuery(".jquery-date-picker .date.start").val();
		var time_chosen = jQuery(".jquery-date-picker .time-picker").val();
		var total_time = date_chosen + " " + time_chosen;
		jQuery(".new-date").val(total_time);

	});

});