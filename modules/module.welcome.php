<?php
/**
 * Weclome Page Class
 *
 * @package     Landing Pages
 * @subpackage  Admin/Welcome
 * @copyright   Copyright (c) 2013, Pippin Williamson
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.4
 * Forked from pippin's WordPress Landing Pages! https://easydigitaldownloads.com/
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * LANDINGPAGES_Welcome Class
 *
 * A general class for About and Credits page.
 *
 * @since 1.4
 */
class LANDINGPAGES_Welcome {

	/**
	 * @var string The capability users should have to view the page
	 */
	public $minimum_capability = 'manage_options';

	/**
	 * Get things started
	 *
	 * @since 1.4
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menus') );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_action( 'admin_init', array( $this, 'welcome'    ) );
	}

	/**
	 * Register the Dashboard Pages which are later hidden but these pages
	 * are used to render the Welcome and Credits pages.
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function admin_menus() {
		// About Page
		add_dashboard_page(
			__( 'Welcome to WordPress Landing Pages', 'edd' ),
			__( 'Welcome to WordPress Landing Pages', 'edd' ),
			$this->minimum_capability,
			'lp-quick-start',
			array( $this, 'quick_start_screen' )
		);
		// About InboundNow Page
		add_dashboard_page(
			__( 'About the Inbound Now Marketing Platform', 'edd' ),
			__( 'About the Inbound Now Marketing Platform', 'edd' ),
			$this->minimum_capability,
			'about-inboundnow',
			array( $this, 'about_inboundnow_screen' )
		);
		// Developer Page
		add_dashboard_page(
			__( 'Developers and Designers', 'edd' ),
			__( 'Developers and Designers', 'edd' ),
			$this->minimum_capability,
			'inbound-developers',
			array( $this, 'dev_designer_screen' )
		);

	}

	/**
	 * Hide Individual Dashboard Pages
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function admin_head() {
		remove_submenu_page( 'index.php', 'lp-quick-start' );
		remove_submenu_page( 'index.php', 'about-inboundnow' );
		remove_submenu_page( 'index.php', 'inbound-developers' );

		// Badge for welcome page
		$badge_url = WP_PLUGIN_DIR . 'assets/images/edd-badge.png';
		?>
		<style type="text/css" media="screen">
		/*<![CDATA[*/
		.edd-badge {
			padding-top: 130px;
			height: 52px;
			width: 185px;
			color: #666;
			font-weight: bold;
			font-size: 14px;
			text-align: center;
			text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8);
			margin: 0 -5px;
			background: url('<?php echo $badge_url; ?>') no-repeat;
		}

		.about-wrap .edd-badge {
			position: absolute;
			top: 0;
			right: 0;
		}

		.edd-welcome-screenshots {
			float: right;
			margin-left: 10px!important;
		}
		#inbound-plugins .grid.one-third:first-child{
			margin-left: 0px;
			padding-left: 0px;
		}
		#inbound-plugins .grid.one-third {
		width: 31.333333%;
		}
		#inbound-plugins h3 {
			padding-top: 0px;
			font-size: 22px;
			margin-top: 0px;
			text-align: center;
		}
		#inbound-plugins .dl-button {
			text-align: center;

		}
		.inbound-button-holder {

		}

		#inbound-plugins .in-button {
		background: #94BA65;
		border: 1px solid rgba(0, 0, 0, 0.15);
		-webkit-border-radius: 2px;
		-moz-border-radius: 2px;
		border-radius: 2px;
		-webkit-box-shadow: 0 2px 3px rgba(0, 0, 0, 0.15),inset 1px 1px 1px rgba(255, 255, 255, 0.2);
		-moz-box-shadow: 0 2px 3px rgba(0,0,0,.15),inset 1px 1px 1px rgba(255,255,255,.2);
		box-shadow: 0 2px 3px rgba(0, 0, 0, 0.15),inset 1px 1px 1px rgba(255, 255, 255, 0.2);
		color: #FFF;
		cursor: pointer;
		display: inline-block;
		font-family: inherit;
		font-size: 20px;
		font-weight: 500;
		text-align: center;
		padding: 8px 20px;
		text-shadow: -1px -1px 1px rgba(0, 0, 0, 0.15);
		text-decoration: none;
		}
		#inbound-plugins .content-box.default p:first-child {
			margin-top: 10px;
		}
		#inbound-plugins .grid {
		float: left;
		min-height: 1px;
		padding-left: 10px;
		padding-right: 10px;}
		#inbound-plugins .content-box {
		background: #F2F2F2 ;
		border: 1px solid #EBEBEA;
		-webkit-box-shadow: inset 1px 1px 1px rgba(255, 255, 255, 0.5);
		-moz-box-shadow: inset 1px 1px 1px rgba(255,255,255,0.5);
		box-shadow: inset 1px 1px 1px rgba(255, 255, 255, 0.5);
		margin: 0px 0px 20px;
		padding: 20px 15px 20px;
		position: relative;
		text-shadow: 1px 1px 1px rgba(255, 255, 255, 0.5);
		min-height: 245px;
		}
		#in-sub-head {
			margin: 0px 135px 0px 0;
		}
		.grid.one-third p:last-of-type {
			padding-bottom: 24px;
		}
		.grid.one-third:nth-last-of-type(1) p:last-of-type  {
			padding-bottom: 0px;
		}
		#inbound-plugins .grid.one-third:nth-last-of-type(1) {
			padding-right: 0px;
		}
		/*]]>*/
		</style>
		<?php
	}
	/**
	 * Render About InboundNow Nav
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	static function render_nav_menu($active) {
		$current_view = $_GET['page'];
		$page_array = array('lp-quick-start' => "Quick Start Guide",
							'about-inboundnow' => "About the Platform",
							'inbound-developers' => 'Developers & Designers'
							);
		echo '<h2 class="nav-tab-wrapper" style="margin-left: -40px; padding-left: 40px;">';
		foreach ($page_array as $key => $value) {
			$active = ($current_view === $key) ? 'nav-tab-active' : '';

		echo '<a class="nav-tab '.$active.'" href="'.esc_url( admin_url( add_query_arg( array( 'page' => $key ), 'index.php' ) ) ).'">';
		echo _e( $value, 'edd' );
		echo '</a>';

		}
		echo '</h2>';


	}
	/**
	 * Render About Screen
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function quick_start_screen() {
		list( $display_version ) = explode( '-', LANDINGPAGES_CURRENT_VERSION );
		?>
		<style type="text/css">
		.about-text {
		font-size: 19px;
			}</style>
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to WordPress Landing Pages %s', 'edd' ), $display_version ); ?></h1>
			<div class="about-text" id="in-sub-head"><?php printf( __( 'Thank you for updating to the latest version! WordPress Landing Pages %s is help you convert more leads!', 'edd' ), $display_version ); ?></div>
			<div class="edd-badge"><?php printf( __( 'Version %s', 'edd' ), $display_version ); ?></div>

			<?php self::render_nav_menu();?>

			<div id="creating-landing-page">
				<h4><?php _e( 'Create Your First Landing Page', 'edd' );?></h4>
				<iframe width="640" height="360" src="//www.youtube.com/embed/-VuaBUc_yfk" frameborder="0" allowfullscreen></iframe>
			</div>
			<div id="creating-landing-page">
				<h4><?php _e( 'How to Create Forms', 'edd' );?></h4>
				<iframe width="640" height="360" src="//www.youtube.com/embed/Y4M_g9wkRXw" frameborder="0" allowfullscreen></iframe>
			</div>
			<div id="creating-landing-page">
			Running A/B Tests
			</div>
			<div id="creating-landing-page">
			Creating Landing Page with current active Theme
			</div>
			<div id="creating-landing-page">

			</div>

			<div class="changelog">
				<h3><?php _e( 'A Great Checkout Experience', 'edd' );?></h3>

				<div class="feature-section">

					<img src="<?php echo WP_PLUGIN_DIR . 'assets/images/screenshots/17checkout.png'; ?>" class="edd-welcome-screenshots"/>

					<h4><?php _e( 'Simple, Beautiful Checkout', 'edd' );?></h4>
					<p><?php _e( 'We have worked tirelessly to continually improve the checkout experience of WordPress Landing Pages, and with just a few subtle tweaks, we have made the experience in WordPress Landing Pages version 1.8 even better than before.', 'edd' );?></p>

					<h4><?php _e( 'Better Checkout Layout', 'edd' );?></h4>
					<p><?php _e( 'The position of each field on the checkout has been carefully reconsidered to ensure it is in the proper location so as to best create high conversion rates.', 'edd' );?></p>

				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Cart Saving', 'edd' );?></h3>

				<div class="feature-section">

					<img src="<?php echo WP_PLUGIN_DIR . 'assets/images/screenshots/18cart-saving.png'; ?>" class="edd-welcome-screenshots"/>

					<h4><?php _e( 'Allow Customers to Save Their Carts for Later','edd' );?></h4>
					<p><?php _e( 'With Cart Saving, customers can save their shopping carts and then come back and restore them at a later point.', 'edd' );?></p>

					<h4><?php _e( 'Encourage Customers to Come Back', 'edd' );?></h4>
					<p><?php _e( 'By making it easier for customers to save their cart and return later, you can increase the conversion rate of the customers that need time to think about their purchase.', 'edd' );?></p>


				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Better Purchase Button Colors', 'edd' );?></h3>

				<div class="feature-section">

					<img src="<?php echo WP_PLUGIN_DIR . 'assets/images/screenshots/18-button-colors.png'; ?>" class="edd-welcome-screenshots"/>

					<h4><?php _e( 'Eight Button Colors', 'edd' );?></h4>
					<p><?php _e( 'With eight beautifully button colors to choose from, you will almost certainly find the color to match your site.', 'edd' );?></p>

					<h4><?php _e( 'Simpler; Cleaner', 'edd' );?></h4>
					<p><?php _e( 'Purchase buttons are cleaner, simpler, and just all around better with WordPress Landing Pages 1.8.', 'edd' );?></p>
					<p><?php _e( 'By simplifying one of the most important aspects of your digital store, we ensure better compatibility with more themes and easier customization for advanced users and developers.', 'edd' );?></p>

				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Better APIs for Developers', 'edd' );?></h3>

				<div class="feature-section">

					<h4><?php _e( 'EDD_Payment_Stats','edd' );?></h4>
					<p><?php _e( 'The new EDD_Payment_Stats class provides a simple way to retrieve earnings and sales stats for the store, or any specific Download product, for any date range. Get sales or earnings for this month, last month, this year, or even any custom date range.', 'edd' );?></p>

					<h4><?php _e( 'EDD_Payments_Query', 'edd' ); ?></h4>
					<p><?php _e( 'Easily retrieve payment data for any Download product or the entire store. EDD_Payments_Query even allows you to pass in any date range to retrieve payments for a specific period. EDD_Payments_Query works nearly identical to WP_Query, so it is simple and familiar.', 'edd' ); ?></p>

				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Additional Updates', 'edd' );?></h3>

				<div class="feature-section col three-col">
					<div>
						<h4><?php _e( 'Retina Ready Checkout', 'edd' );?></h4>
						<p><?php _e( 'Every icon and image asset used by the WordPress Landing Pages checkout is now fully retina ready to ensure your most important page always looks great.', 'edd' );?></p>

						<h4><?php _e( 'Improved Settings API', 'edd' );?></h4>
						<p><?php _e( 'The EDD settings API has been dramatically simplified to be more performant, provide better filters, and even support custom settings tabs.', 'edd' );?></p>
					</div>

					<div>
						<h4><?php _e( 'Live Dashboard Updates', 'edd' );?></h4>
						<p><?php _e( 'The Dashboard summary widget now updates live with the WP Heartbeat API, meaning you can literally watch your stats update live as sales come in.', 'edd' );?></p>

						<h4><?php _e( 'Category Filters for Downloads Reports', 'edd' );?></h4>
						<p><?php _e( 'The Downloads Reports view now supports filtering Downloads by category, making it easier to see earnings and sales based on product categories.', 'edd' );?></p>
					</div>

					<div class="last-feature">
						<h4><?php _e( 'Tools Menu', 'edd' );?></h4>
						<p><?php _e( 'A new Tools submenu has been added to the main Downloads menu that houses settings import / export, as well as other utilities added by extensions.' ,'edd' );?></p>

						<h4><?php _e( 'Bulk Payment History Update','edd' );?></h4>
						<p><?php _e( 'The bulk update options for Payments have been updated to include all payment status options, making it easier to manage payment updates in bulk.', 'edd' );?></p>
					</div>
				</div>
			</div>

			<div class="return-to-dashboard">
				<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'post_type' => 'download', 'page' => 'edd-settings' ), 'edit.php' ) ) ); ?>"><?php _e( 'Go to WordPress Landing Pages Settings', 'edd' ); ?></a>
			</div>
		</div>
		<?php
	}
	/**
	 * Render About InboundNow Screen
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function about_inboundnow_screen() {
		list( $display_version ) = explode( '-', LANDINGPAGES_CURRENT_VERSION );
		$leads_active_class = "Download For Free";
		$lp_active_class = "Download For Free";
		$cta_active_class = "Download For Free";
		$active_class = "";
		if (is_plugin_active('landing-pages/landing-pages.php')) {
		  $lp_active_class = "Already Installed!";
		  $lpactive = " plugin-active";
		}
		if (is_plugin_active('cta/wordpress-cta.php')) {
		 	$cta_active_class = "Already Installed!";
		 	$ctaactive = " plugin-active";
		}
		if (is_plugin_active('leads/wordpress-leads.php')) {
			$leads_active_class = "Already Installed!";
			$leadactive = " plugin-active";
		}

		?>
		<style type="text/css">
		#inbound-plugins h4 {
			text-align: center;
			font-weight: 200;
			margin-bottom: 0px;
			margin-top: 0px;
		}
		.inbound-check {
		color: #58D37B;
		padding-right: 0px;
		padding-top: 5px;
		display: inline-block;
		clear: both;
		vertical-align: top;
		}
		#inbound-plugins .in-button.plugin-active {
		background: #B9B9B9;}
		.intro-p {
			display: inline-block;
			width: 96%;
			vertical-align: top;
			margin-top: 0px;
			padding-top: 0px;
			margin-right: -20px;
			line-height: 1.4em;
		}
		.circle-wrap {
			float: left;
			margin-right: 0px;
			width: 25px;
			height: 25px;
			margin-left: -5px;
			margin-right: 6px;
			margin-top: 5px;
			border-radius: 50%;
			background: linear-gradient(to bottom, #FFF 0%, #F7F7F7 100%);
			box-shadow: 0 0 3px 0 rgba(0, 0, 0, 0.3), inset 0 2px 0 -1px rgba(98, 98, 98, 0.3), 0 3px 7px -3px rgba(0, 0, 0, 0.4);
			color: #ADADAD;
			text-align: center;
			font-size: 18px;
			line-height: 17px;
			cursor: default;
			transition: color .3s ease;
		}
		.inbound-button-holder {
			text-align: center;
		}
		</style>

		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Turbo Charge Your Marketing', 'edd' ), $display_version ); ?></h1>
			<div class="about-text" id="in-sub-head"><?php printf( __( 'WordPress Landing Pages is only one piece of Inbound Now\'s Marketing Platform', 'edd' ), $display_version ); ?></div>

			<?php self::render_nav_menu();?>


			<p class="about-description"><?php _e( 'To have an effective marketing strategy for your site you need to incorporate a comprehensive conversion strategy to capture visitors attention, get them clicking, and convert them on a web form or landing page.', 'edd' ); ?></p>

		<div class="row" id="inbound-plugins">
		    <div class="grid one-third">
		        <div class="content-box default">
		            <h4>Capture visitor attention with</h4>

		            <h3 style="text-align: center;">WordPress Calls to Action</h3>

		            <div class='circle-wrap'>
		                <span class="inbound-check">✔</span>
		            </div>

		            <p class="intro-p"><b>Convert more website traffic</b> with visually
		            appealing calls to action</p>

		            <div class='circle-wrap'>
		                <span class="inbound-check">✔</span>
		            </div>

		            <p class="intro-p">A/B test your marketing tactics and <b>improve your
		            sites conversion rates</b></p>

		            <div class="inbound-button-holder">
		                <div class='dl-button'>
		                    <a class="in-button<?php echo $ctaactive;?>" href=
		                    "http://wordpress.org/plugins/cta/"><i class=
		                    "icon-download"></i><?php echo $cta_active_class;?></a>
		                </div>
		            </div>
		        </div>
		    </div>

		    <div class="grid one-third">
		        <div class="content-box default">
		            <h4>Convert website visitors with</h4>

		            <h3>WordPress Landing Pages</h3>

		            <div class='circle-wrap'>
		                <span class="inbound-check">✔</span>
		            </div>

		            <p class="intro-p"><b>Generate more web leads</b> with pages specifically designed for conversion</p>

		            <div class='circle-wrap'>
		                <span class="inbound-check">✔</span>
		            </div>

		            <p class="intro-p">A/B Landing Page designs and improve your lead
		            generation.</p>

		            <div class="inbound-button-holder">
		                <div class='dl-button'>
		                    <a class="in-button<?php echo $lpactive;?>" href=
		                    "http://wordpress.org/plugins/landing-pages/"><i class=
		                    "icon-download"></i><?php echo $lp_active_class;?></a>
		                </div>
		            </div>
		        </div>
		    </div>

		    <div class="grid one-third">
		        <div class="content-box default">
		            <h4>Followup &amp; Close the deal with</h4>

		            <h3>WordPress Leads</h3>

		            <div class='circle-wrap'>
		                <span class="inbound-check">✔</span>
		            </div>

		            <p class="intro-p">Gather sophisticated lead intelligence on your
		            website visitors.</p>

		            <div class='circle-wrap'>
		                <span class="inbound-check">✔</span>
		            </div>

		            <p class="intro-p">Track pages viewed, site conversions,
		            demographics, geolocation, social media profiles and more.</p>

		            <div class="inbound-button-holder">
		                <div class='dl-button'>
		                    <a class="in-button<?php echo $leadactive;?>" href=
		                    "http://wordpress.org/plugins/leads/"><i class=
		                    "icon-download"></i><?php echo $leads_active_class;?></a>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>


		</div>
		<?php
	}

	/**
	 * Render Developers/Designer Screen
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function dev_designer_screen() {
		list( $display_version ) = explode( '-', LANDINGPAGES_CURRENT_VERSION );
		?>
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to WordPress Landing Pages %s', 'edd' ), $display_version ); ?></h1>
			<div class="about-text" id="in-sub-head"><?php printf( __( 'Learn How to Build Custom Templates & Add Value to Your Clients', 'edd' ), $display_version ); ?></div>
			<div class="edd-badge"><?php printf( __( 'Version %s', 'edd' ), $display_version ); ?></div>

			<?php self::render_nav_menu();?>


			<p class="about-description"><?php _e( 'WordPress Landing Pages is created by a worldwide team of developers who aim to provide the #1 eCommerce platform for selling digital goods through WordPress.', 'edd' ); ?></p>


		</div>
		<?php
	}

	/**
	 * Sends user to the Welcome page on first activation of EDD as well as each
	 * time EDD is upgraded to a new version
	 *
	 * @access public
	 * @since 1.4
	 * @global $edd_options Array of all the EDD Options
	 * @return void
	 */
	public function welcome() {


		// Bail if no activation redirect
		if ( ! get_transient( '_landing_page_activation_redirect' ) )
			return;

		// Delete the redirect transient
		delete_transient( '_landing_page_activation_redirect' );

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) )
			return;

		wp_safe_redirect( admin_url( 'index.php?page=lp-quick-start' ) ); exit;
	}
}
new LANDINGPAGES_Welcome();
