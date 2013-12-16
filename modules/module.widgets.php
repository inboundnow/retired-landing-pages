<?php

add_action( 'widgets_init', 'lp_load_widgets' );

function lp_load_widgets() {

	register_widget( 'lp_conversion_area_widget' );

}

class lp_conversion_area_widget extends WP_Widget
{

	function lp_conversion_area_widget() {

		/* Widget settings. */
		$widget_ops = array( 'classname' => 'class_lp_conversion_area_widget', 'description' => __('Use this widget on your landing page sidebar. This sidebar replaces the normal sidebar while using your default theme as a template, or other inactive themes as landing page templates.', LANDINGPAGES_TEXT_DOMAIN) );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'id_lp_conversion_area_widget' );

		/* Create the widget. */
		$this->WP_Widget( 'id_lp_conversion_area_widget', __('Landing Pages: Conversion Area Widget', LANDINGPAGES_TEXT_DOMAIN), $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		global $wp_query;
		$this_id = $wp_query->post->ID;
		$this_type = $wp_query->post->post_type;

		if ($this_type=='landing-page')
		{
			extract( $args );

			$position = $_SESSION['lp_conversion_area_position'];

			if ($position=='widget')
			{
				$title = apply_filters('widget_title', $instance['title'] );

				$conversion_area = do_shortcode(get_post_meta($this_id, 'lp-conversion-area', true));

				$conversion_area = "<div id='lp_container' class='inbound-conversion-sidebar'>".$conversion_area."</div>";

				/* Before widget (defined by themes). */
				echo $before_widget;

				/* Display the widget title if one was input (before and after defined by themes). */
				if ($title)
				{
					echo $before_title . $title . $after_title;
				}

				echo $conversion_area;

				/* After widget (defined by themes). */
				echo $after_widget;
			}
		}
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array();
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<?php _e("This box will render the landing page conversion area on the 'default' template." , LANDINGPAGES_TEXT_DOMAIN); ?>
		</p>

	<?php
	}
}

?>