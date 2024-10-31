<?php
/**
 * Plugin Name: NINJA Workspace
 * Plugin URI: https://worker.nynja.net/v1/Content/NynWidget/manual/samples/wordpress.html
 * Description: Revolutionary workspace will help keep your clients on your site and keep your brand in front of your customers.
 * Version: 1.5
 * Author: NINJAworkspace
 * Author URI: https://www.ninjaworkspace.com/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

define( 'NINJAWORKSPACE_DOMAIN', 'ninjaworkspace' );

// Enqueue your JavaScript file

function ninjaworkspace_enqueue_scripts() {
	
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'plugin-bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array(), '5.3.0', true );
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-resizable');
	wp_enqueue_script('jquery-ui-draggable');
	wp_enqueue_script( 'plugin-cookie-min', plugin_dir_url( __FILE__ ) . 'js/js.cookie.min.js', array(), '3.0.1', true );
	wp_enqueue_script( 'plugin-scripts', plugins_url( 'js/custom.js', __FILE__ ), array(), '1.0', true );
	$plugin_image_url = plugins_url( 'images/ui-icons.png', __FILE__ );
	wp_enqueue_style('plugin-jquery-ui', plugin_dir_url(__FILE__) . 'css/jquery-ui.css', array(), '1.11.3');
	wp_enqueue_style( 'plugin-styles', plugins_url( 'css/custom-styles.css', __FILE__ ), array(), '1.0' );
}

add_action( 'wp_enqueue_scripts', 'ninjaworkspace_enqueue_scripts' );


// Register the widget

if ( class_exists( 'Elementor\Plugin' ) ) {
	function ninjaworkspace_register_elementor_widget() {
		include_once 'elementor-widget.php';
		if ( class_exists( 'FLBuilder' ) ) {
			include_once 'modules/beaver/beaver-widget.php';
		}
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Ninjaworkspace_Elementor_Widget() );
	}
	add_action( 'init', 'ninjaworkspace_register_elementor_widget' );

}

if (!function_exists('ninjaworkspace_gutenberg_block')) { 
	function ninjaworkspace_gutenberg_block() {
		register_block_type( __DIR__ );
	}
}

add_action( 'init', 'ninjaworkspace_gutenberg_block' );

// Add a new submenu under Settings

if (!function_exists('ninjaworkspace_custom_menu_page')) { 
	function ninjaworkspace_custom_menu_page() {

		$plugin_cust_imag = plugins_url( 'images/20-n_new.png', __FILE__ );

		add_menu_page(
			'NINJA Workspace Settings', // Page Title
			'NINJA Workspace', // Menu Title
			'manage_options', // Capability
			'ninjaworkspace', // Menu Slug
			'ninjaworkspace_settings_page_html', // Function that renders the settings page
			$plugin_cust_imag
		);
	}
}

add_action( 'admin_menu', 'ninjaworkspace_custom_menu_page' );

// Enqueue the custom admin CSS

if (!function_exists('ninjaworkspace_enqueue_admin_styles')) { 
	function ninjaworkspace_enqueue_admin_styles() {

		wp_enqueue_media();
		wp_enqueue_style( 'custom-admin-styles', plugins_url( 'css/admin-dashboard-styling.css', __FILE__ ), array(), '1.0' );
		wp_enqueue_script( 'custom-script', plugins_url( 'js/admin.js', __FILE__ ), array(), '1.0', true );
		
	}
}

add_action( 'admin_enqueue_scripts', 'ninjaworkspace_enqueue_admin_styles' );

register_activation_hook( __FILE__, 'ninjaworkspace_activation' );

if (!function_exists('ninjaworkspace_activation')) { 
	function ninjaworkspace_activation() {

		update_option( 'ninjaworkspace_desktop_breakpoint', '1440' );
		update_option( 'ninjaworkspace_desktop_width', '100' );
		update_option( 'ninjaworkspace_desktop_height', '1080' );
		update_option( 'ninjaworkspace_laptop_breakpoint', '1280' );
		update_option( 'ninjaworkspace_laptop_width', '100' );
		update_option( 'ninjaworkspace_laptop_height', '1080' );
		update_option( 'ninjaworkspace_tablet_breakpoint', '1024' );
		update_option( 'ninjaworkspace_tablet_width', '100' );
		update_option( 'ninjaworkspace_tablet_height', '1080' );
		update_option( 'ninjaworkspace_mobile_breakpoint', '768' );
		update_option( 'ninjaworkspace_mobile_width', '100' );
		update_option( 'ninjaworkspace_mobile_height', '1080' );
		update_option( 'ninjaworkspace_popup_width', '75' );
		update_option( 'ninjaworkspace_button_text', 'Open WorkSpace' );
		update_option( 'ninjaworkspace_popup_background', '#fff' );
		update_option( 'ninjaworkspace_popup_close_color', '#000' );
		update_option( 'ninjaworkspace_popup_close_back', '#fff' );
		update_option( 'ninjaworkspace_popup_button_color_hover', '#fff' );
		update_option( 'ninjaworkspace_popup_button_background_hover', '#64cccc' );
		update_option( 'ninjaworkspace_popup_image', plugins_url( 'images/128-n_new.png', __FILE__ ) );
	}
}

if (!function_exists('ninjaworkspace_settings_page_html')) { 
	function ninjaworkspace_settings_page_html() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'ninjaworkspace' ) );
		}
		if ( isset( $_POST['submit'] ) && ! empty( $_POST['ninjaworkspace_settings_nonce'] ) ) {
			$nonce = sanitize_text_field( wp_unslash( $_POST['ninjaworkspace_settings_nonce'] ) );
			if ( ! wp_verify_nonce( $nonce, 'ninjaworkspace_settings_action' ) ) {
				wp_die( esc_html__( 'Nonce verification failed.', 'ninjaworkspace' ) );
			}
			echo '<script>document.getElementById("success-message").style.display = "block";</script>';

			// General Tab Content

			if ( isset( $_POST['ninjaworkspace_desktop_breakpoint'] ) ) {

				$ninjaworkspace_desktop_breakpoint_value = sanitize_text_field( $_POST['ninjaworkspace_desktop_breakpoint'] );

				update_option( 'ninjaworkspace_desktop_breakpoint', $ninjaworkspace_desktop_breakpoint_value );

			}

			if ( isset( $_POST['ninjaworkspace_desktop_width'] ) ) {

				$ninjaworkspace_desktop_width_value = sanitize_text_field( $_POST['ninjaworkspace_desktop_width'] );

				update_option( 'ninjaworkspace_desktop_width', $ninjaworkspace_desktop_width_value );

			}

			if ( isset( $_POST['ninjaworkspace_desktop_height'] ) ) {

				$ninjaworkspace_desktop_height_value = sanitize_text_field( $_POST['ninjaworkspace_desktop_height'] );

				update_option( 'ninjaworkspace_desktop_height', $ninjaworkspace_desktop_height_value );

			}

			if ( isset( $_POST['ninjaworkspace_laptop_breakpoint'] ) ) {

				$ninjaworkspace_laptop_breakpoint_value = sanitize_text_field( $_POST['ninjaworkspace_laptop_breakpoint'] );

				update_option( 'ninjaworkspace_laptop_breakpoint', $ninjaworkspace_laptop_breakpoint_value );

			}

			if ( isset( $_POST['ninjaworkspace_laptop_width'] ) ) {

				$ninjaworkspace_laptop_width_value = sanitize_text_field( $_POST['ninjaworkspace_laptop_width'] );

				update_option( 'ninjaworkspace_laptop_width', $ninjaworkspace_laptop_width_value );

			}

			if ( isset( $_POST['ninjaworkspace_laptop_height'] ) ) {

				$ninjaworkspace_laptop_height_value = sanitize_text_field( $_POST['ninjaworkspace_laptop_height'] );

				update_option( 'ninjaworkspace_laptop_height', $ninjaworkspace_laptop_height_value );

			}

			if ( isset( $_POST['ninjaworkspace_tablet_breakpoint'] ) ) {

				$ninjaworkspace_tablet_breakpoint_value = sanitize_text_field( $_POST['ninjaworkspace_tablet_breakpoint'] );

				update_option( 'ninjaworkspace_tablet_breakpoint', $ninjaworkspace_tablet_breakpoint_value );

			}

			if ( isset( $_POST['ninjaworkspace_tablet_width'] ) ) {

				$ninjaworkspace_tablet_width_value = sanitize_text_field( $_POST['ninjaworkspace_tablet_width'] );

				update_option( 'ninjaworkspace_tablet_width', $ninjaworkspace_tablet_width_value );

			}

			if ( isset( $_POST['ninjaworkspace_tablet_height'] ) ) {

				$ninjaworkspace_tablet_height_value = sanitize_text_field( $_POST['ninjaworkspace_tablet_height'] );

				update_option( 'ninjaworkspace_tablet_height', $ninjaworkspace_tablet_height_value );

			}

			if ( isset( $_POST['ninjaworkspace_mobile_breakpoint'] ) ) {

				$ninjaworkspace_mobile_breakpoint_value = sanitize_text_field( $_POST['ninjaworkspace_mobile_breakpoint'] );

				update_option( 'ninjaworkspace_mobile_breakpoint', $ninjaworkspace_mobile_breakpoint_value );

			}

			if ( isset( $_POST['ninjaworkspace_mobile_width'] ) ) {

				$ninjaworkspace_mobile_width_value = sanitize_text_field( $_POST['ninjaworkspace_mobile_width'] );

				update_option( 'ninjaworkspace_mobile_width', $ninjaworkspace_mobile_width_value );

			}

			if ( isset( $_POST['ninjaworkspace_mobile_height'] ) ) {

				$ninjaworkspace_mobile_height_value = sanitize_text_field( $_POST['ninjaworkspace_mobile_height'] );

				update_option( 'ninjaworkspace_mobile_height', $ninjaworkspace_mobile_height_value );

			}
		}

		// Advance Tab Content

		if ( isset( $_POST['submit-popup'] ) && ! empty( $_POST['ninjaworkspace_popup_settings_nonce'] ) ) {
			
			$nonce = sanitize_text_field( wp_unslash( $_POST['ninjaworkspace_popup_settings_nonce'] ) );
			if ( ! wp_verify_nonce( $nonce, 'ninjaworkspace_popup_settings_action' ) ) {
				// Nonce verification failed, handle accordingly (e.g., show an error message).
				wp_die( esc_html__( 'Nonce verification failed.', 'ninjaworkspace' ) );
			}

			$ninjaworkspace_desktop_checkbox_value = isset( $_POST['ninjaworkspace_desktop_checkbox'] ) ? 1 : 0;

			update_option( 'ninjaworkspace_desktop_checkbox', $ninjaworkspace_desktop_checkbox_value );

			$ninjaworkspace_laptop_checkbox_value = isset( $_POST['ninjaworkspace_laptop_checkbox'] ) ? 1 : 0;

			update_option( 'ninjaworkspace_laptop_checkbox', $ninjaworkspace_laptop_checkbox_value );

			$ninjaworkspace_tablet_checkbox_value = isset( $_POST['ninjaworkspace_tablet_checkbox'] ) ? 1 : 0;

			update_option( 'ninjaworkspace_tablet_checkbox', $ninjaworkspace_tablet_checkbox_value );

			$ninjaworkspace_mobile_checkbox_value = isset( $_POST['ninjaworkspace_mobile_checkbox'] ) ? 1 : 0;
			update_option( 'ninjaworkspace_mobile_checkbox', $ninjaworkspace_mobile_checkbox_value );

			if ( isset( $_POST['ninjaworkspace_popup_width'] ) ) {

				$ninjaworkspace_popup_width_value = sanitize_text_field( $_POST['ninjaworkspace_popup_width'] );
				update_option( 'ninjaworkspace_popup_width', $ninjaworkspace_popup_width_value );

			}

			if ( isset( $_POST['ninjaworkspace_button_text'] ) ) {

				$ninjaworkspace_button_text_value = sanitize_text_field( $_POST['ninjaworkspace_button_text'] );
				update_option( 'ninjaworkspace_button_text', $ninjaworkspace_button_text_value );

			}

			if ( isset( $_POST['ninjaworkspace_popup_background'] ) ) {

				$ninjaworkspace_popup_background_value = sanitize_text_field( $_POST['ninjaworkspace_popup_background'] );
				update_option( 'ninjaworkspace_popup_background', $ninjaworkspace_popup_background_value );

			}

			if ( isset( $_POST['ninjaworkspace_popup_close_color'] ) ) {

				$ninjaworkspace_popup_close_color_value = sanitize_text_field( $_POST['ninjaworkspace_popup_close_color'] );
				update_option( 'ninjaworkspace_popup_close_color', $ninjaworkspace_popup_close_color_value );

			}

			if ( isset( $_POST['ninjaworkspace_popup_close_back'] ) ) {

				$ninjaworkspace_popup_close_back_value = sanitize_text_field( $_POST['ninjaworkspace_popup_close_back'] );
				update_option( 'ninjaworkspace_popup_close_back', $ninjaworkspace_popup_close_back_value );

			}

			if ( isset( $_POST['ninjaworkspace_popup_image'] ) ) {

				$ninjaworkspace_popup_image_value = sanitize_text_field( $_POST['ninjaworkspace_popup_image'] );
				update_option( 'ninjaworkspace_popup_image', $ninjaworkspace_popup_image_value );

			}

			if ( isset( $_POST['ninjaworkspace_popup_button_color_hover'] ) ) {

				$ninjaworkspace_popup_button_color_hover_value = sanitize_text_field( $_POST['ninjaworkspace_popup_button_color_hover'] );
				update_option( 'ninjaworkspace_popup_button_color_hover', $ninjaworkspace_popup_button_color_hover_value );

			}

			if ( isset( $_POST['ninjaworkspace_popup_button_background_hover'] ) ) {

				$ninjaworkspace_popup_button_background_hover_value = sanitize_text_field( $_POST['ninjaworkspace_popup_button_background_hover'] );
				update_option( 'ninjaworkspace_popup_button_background_hover', $ninjaworkspace_popup_button_background_hover_value );

			}
		}

		$ninjaworkspace_desktop_breakpoint_value = get_option( 'ninjaworkspace_desktop_breakpoint' );

		$ninjaworkspace_desktop_width_value = get_option( 'ninjaworkspace_desktop_width' );

		$ninjaworkspace_desktop_height_value = get_option( 'ninjaworkspace_desktop_height' );

		$ninjaworkspace_laptop_breakpoint_value = get_option( 'ninjaworkspace_laptop_breakpoint' );

		$ninjaworkspace_laptop_width_value = get_option( 'ninjaworkspace_laptop_width' );

		$ninjaworkspace_laptop_height_value = get_option( 'ninjaworkspace_laptop_height' );

		$ninjaworkspace_tablet_breakpoint_value = get_option( 'ninjaworkspace_tablet_breakpoint' );

		$ninjaworkspace_tablet_width_value = get_option( 'ninjaworkspace_tablet_width' );

		$ninjaworkspace_tablet_height_value = get_option( 'ninjaworkspace_tablet_height' );

		$ninjaworkspace_mobile_breakpoint_value = get_option( 'ninjaworkspace_mobile_breakpoint' );

		$ninjaworkspace_mobile_width_value = get_option( 'ninjaworkspace_mobile_width' );

		$ninjaworkspace_mobile_height_value = get_option( 'ninjaworkspace_mobile_height' );

		$ninjaworkspace_desktop_checkbox_value = get_option( 'ninjaworkspace_desktop_checkbox' );

		$ninjaworkspace_laptop_checkbox_value = get_option( 'ninjaworkspace_laptop_checkbox' );

		$ninjaworkspace_tablet_checkbox_value = get_option( 'ninjaworkspace_tablet_checkbox' );

		$ninjaworkspace_mobile_checkbox_value = get_option( 'ninjaworkspace_mobile_checkbox' );

		$ninjaworkspace_popup_width_value = get_option( 'ninjaworkspace_popup_width' );

		$ninjaworkspace_button_text_value = get_option( 'ninjaworkspace_button_text' );

		$ninjaworkspace_popup_background_value = get_option( 'ninjaworkspace_popup_background' );

		$ninjaworkspace_popup_close_color_value = get_option( 'ninjaworkspace_popup_close_color' );

		$ninjaworkspace_popup_close_back_value = get_option( 'ninjaworkspace_popup_close_back' );

		$ninjaworkspace_popup_image_value = get_option( 'ninjaworkspace_popup_image' );

		$ninjaworkspace_popup_button_color_hover_value = get_option( 'ninjaworkspace_popup_button_color_hover' );

		$ninjaworkspace_popup_button_background_hover_value = get_option( 'ninjaworkspace_popup_button_background_hover' );

		if ( isset( $_POST['reset-iframe'] ) ) {

			update_option( 'ninjaworkspace_desktop_breakpoint', '1440' );

			$ninjaworkspace_desktop_breakpoint_value = '1440';

			update_option( 'ninjaworkspace_desktop_width', '100' );

			$ninjaworkspace_desktop_width_value = '100';

			update_option( 'ninjaworkspace_desktop_height', '1080' );

			$ninjaworkspace_desktop_height_value = '1080';

			update_option( 'ninjaworkspace_laptop_breakpoint', '1280' );

			$ninjaworkspace_laptop_breakpoint_value = '1280';

			update_option( 'ninjaworkspace_laptop_width', '100' );

			$ninjaworkspace_laptop_width_value = '100';

			update_option( 'ninjaworkspace_laptop_height', '1080' );

			$ninjaworkspace_laptop_height_value = '1080';

			update_option( 'ninjaworkspace_tablet_breakpoint', '1024' );

			$ninjaworkspace_tablet_breakpoint_value = '1024';

			update_option( 'ninjaworkspace_tablet_width', '100' );

			$ninjaworkspace_tablet_width_value = '100';

			update_option( 'ninjaworkspace_tablet_height', '1080' );

			$ninjaworkspace_tablet_height_value = '1080';

			update_option( 'ninjaworkspace_mobile_breakpoint', '768' );

			$ninjaworkspace_mobile_breakpoint_value = '768';

			update_option( 'ninjaworkspace_mobile_width', '100' );

			$ninjaworkspace_mobile_width_value = '100';

			update_option( 'ninjaworkspace_mobile_height', '1080' );

			$ninjaworkspace_mobile_height_value = '1080';

		}

		if ( isset( $_POST['reset-popup'] ) ) {

			update_option( 'ninjaworkspace_desktop_checkbox', '' );

			$ninjaworkspace_desktop_checkbox_value = '';

			update_option( 'ninjaworkspace_laptop_checkbox', '' );

			$ninjaworkspace_laptop_checkbox_value = '';

			update_option( 'ninjaworkspace_tablet_checkbox', '' );

			$ninjaworkspace_tablet_checkbox_value = '';

			update_option( 'ninjaworkspace_mobile_checkbox', '' );

			$ninjaworkspace_mobile_checkbox_value = '';

			update_option( 'ninjaworkspace_popup_width', '75' );

			$ninjaworkspace_popup_width_value = '75';

			update_option( 'ninjaworkspace_button_text', 'Open WorkSpace' );

			$ninjaworkspace_button_text_value = 'Open WorkSpace';

			update_option( 'ninjaworkspace_popup_background', '#fff' );

			$ninjaworkspace_popup_background_value = '#fff';

			update_option( 'ninjaworkspace_popup_close_color', '#000' );

			$ninjaworkspace_popup_close_color_value = '#000';

			update_option( 'ninjaworkspace_popup_close_back', '#fff' );

			$ninjaworkspace_popup_close_back_value = '#fff';

			update_option( 'ninjaworkspace_popup_button_color_hover', '#fff' );

			$ninjaworkspace_popup_button_color_hover_value = '#fff';

			update_option( 'ninjaworkspace_popup_button_background_hover', '#64cccc' );

			$ninjaworkspace_popup_button_background_hover_value = '#64cccc';

			update_option( 'ninjaworkspace_popup_image', plugins_url( 'images/128-n_new.png', __FILE__ ) );
			$ninjaworkspace_popup_image_value = plugins_url( 'images/128-n_new.png', __FILE__ );
		}
		?>
		<div class="wrap">
			<h1><?php esc_html( get_admin_page_title() ); ?></h1>
			<div style="border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; background-color: #fff;">
				<h2><?php echo esc_html__('Instructions', 'ninjaworkspace');?></h2>
				<p><?php echo esc_html__('To embed the NINJA Workspace in a post or page, use the following shortcode:', 'ninjaworkspace');?></p>
				<code><?php echo esc_html( '[Ninjaworkspace]' );?></code>
			</div>
			<div id="success-message" style="display: none;">
				<p><?php echo esc_html__('Your form has been successfully submitted!', 'ninjaworkspace');?></p>
			</div>
			<h2 class="nav-tab-wrapper ninjaworkspace_tabs_section">
				<a href="#tab-general" class="nav-tab nav-tab-active"><?php echo esc_html__('iFrame', 'ninjaworkspace');?></a>
				<a href="#tab-advanced" class="nav-tab"><?php echo esc_html__('PopUp', 'ninjaworkspace');?></a>
			</h2>
			<div id="tab-general" class="tab-content iframe_ninjaworkspace_tab">
				<form method="post" action="">
				<?php wp_nonce_field( 'ninjaworkspace_settings_action', 'ninjaworkspace_settings_nonce' ); ?>
					<h2><?php echo esc_html__('Desktop Settings', 'ninjaworkspace');?></h2>
					<div class="desktop_main_warpper width_content_cust">
						<div class="field_data">
							<label for="ninjaworkspace_desktop_breakpoint"><strong><?php echo esc_html__('Screen Breaking Point', 'ninjaworkspace');?></strong></label>
							<span><input type="text" id="ninjaworkspace_desktop_breakpoint"
									name="ninjaworkspace_desktop_breakpoint"
									value="<?php echo esc_attr( $ninjaworkspace_desktop_breakpoint_value ); ?>"><?php echo esc_html(' px');?></span>
						</div>
						<div class="field_data">
							<label for="ninjaworkspace_desktop_width"><strong><?php echo esc_html__('iFrame Width', 'ninjaworkspace');?></strong></label>
							<span><input type="text" id="ninjaworkspace_desktop_width" name="ninjaworkspace_desktop_width"
									value="<?php echo esc_attr( $ninjaworkspace_desktop_width_value ); ?>"><?php echo esc_html(' %');?></span>
						</div>
						<div class="field_data">
							<label for="ninjaworkspace_desktop_height"><strong><?php echo esc_html__('iFrame Height', 'ninjaworkspace');?></strong></label>
							<span><input type="text" id="ninjaworkspace_desktop_height" name="ninjaworkspace_desktop_height"
									value="<?php echo esc_attr( $ninjaworkspace_desktop_height_value ); ?>"><?php echo esc_html(' px');?></span>
						</div>
					</div>
					<h2><?php echo esc_html__('Laptop Settings', 'ninjaworkspace');?></h2>
					<div class="laptop_main_warpper width_content_cust">
						<div class="field_data">
							<label for="ninjaworkspace_laptop_breakpoint"><strong><?php echo esc_html__('Screen Breaking Point', 'ninjaworkspace');?></strong></label>
							<span><input type="text" id="ninjaworkspace_laptop_breakpoint"
									name="ninjaworkspace_laptop_breakpoint"
									value="<?php echo esc_attr( $ninjaworkspace_laptop_breakpoint_value ); ?>"><?php echo esc_html(' px');?></span>
						</div>
						<div class="field_data">
							<label for="ninjaworkspace_laptop_width"><strong><?php echo esc_html__('iFrame Width', 'ninjaworkspace');?></strong></label>
							<span><input type="text" id="ninjaworkspace_laptop_width" name="ninjaworkspace_laptop_width"
									value="<?php echo esc_attr( $ninjaworkspace_laptop_width_value ); ?>"><?php echo esc_html(' %');?></span>
						</div>
						<div class="field_data">
							<label for="ninjaworkspace_laptop_height"><strong><?php echo esc_html__('iFrame Height', 'ninjaworkspace');?></strong></label>
							<span><input type="text" id="ninjaworkspace_laptop_height" name="ninjaworkspace_laptop_height"
									value="<?php echo esc_attr( $ninjaworkspace_laptop_height_value ); ?>"><?php echo esc_html(' px');?></span>
						</div>
					</div>
					<h2><?php echo esc_html__('Tablet Settings', 'ninjaworkspace');?></h2>
					<div class="tablet_main_warpper width_content_cust">
						<div class="field_data">
							<label for="ninjaworkspace_tablet_breakpoint"><strong><?php echo esc_html__('Screen Breaking Point', 'ninjaworkspace');?></strong></label>
							<span><input type="text" id="ninjaworkspace_tablet_breakpoint"
									name="ninjaworkspace_tablet_breakpoint"
									value="<?php echo esc_attr( $ninjaworkspace_tablet_breakpoint_value ); ?>"><?php echo esc_html(' px');?></span>
						</div>
						<div class="field_data">
							<label for="ninjaworkspace_tablet_width"><strong><?php echo esc_html__('iFrame Width', 'ninjaworkspace');?></strong></label>
							<span><input type="text" id="ninjaworkspace_tablet_width" name="ninjaworkspace_tablet_width"
									value="<?php echo esc_attr( $ninjaworkspace_tablet_width_value ); ?>"><?php echo esc_html(' %');?></span>
						</div>
						<div class="field_data">
							<label for="ninjaworkspace_tablet_height"><strong><?php echo esc_html__('iFrame Height', 'ninjaworkspace');?></strong></label>
							<span><input type="text" id="ninjaworkspace_tablet_height" name="ninjaworkspace_tablet_height"
									value="<?php echo esc_attr( $ninjaworkspace_tablet_height_value ); ?>"><?php echo esc_html(' px');?></span>
						</div>
					</div>
					<h2><?php echo esc_html__('Mobile Settings', 'ninjaworkspace');?></h2>
					<div class="mobile_main_warpper width_content_cust">
						<div class="field_data">
							<label for="ninjaworkspace_mobile_breakpoint"><strong><?php echo esc_html__('Screen Breaking Point', 'ninjaworkspace');?></strong></label>
							<span><input type="text" id="ninjaworkspace_mobile_breakpoint"
									name="ninjaworkspace_mobile_breakpoint"
									value="<?php echo esc_attr( $ninjaworkspace_mobile_breakpoint_value ); ?>"><?php echo esc_html(' px');?></span>
						</div>
						<div class="field_data">
							<label for="ninjaworkspace_mobile_width"><strong><?php echo esc_html__('iFrame Width', 'ninjaworkspace');?></strong></label>
							<span><input type="text" id="ninjaworkspace_mobile_width" name="ninjaworkspace_mobile_width"
									value="<?php echo esc_attr( $ninjaworkspace_mobile_width_value ); ?>"><?php echo esc_html(' %');?></span>
						</div>
						<div class="field_data">
							<label for="ninjaworkspace_mobile_height"><strong><?php echo esc_html__('iFrame Height', 'ninjaworkspace');?></strong></label>
							<span><input type="text" id="ninjaworkspace_mobile_height" name="ninjaworkspace_mobile_height"
									value="<?php echo esc_attr( $ninjaworkspace_mobile_height_value ); ?>"><?php echo esc_html(' px');?></span>
						</div>
					</div>
					<p class="submit">
						<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
						<input type="submit" name="reset-iframe" id="reset-iframe" class="button" value="Reset">
					</p>
				</form>
			</div>
			<div id="tab-advanced" class="tab-content popup_ninjaworkspace_tab" style="display: none;">
				<form method="post" action="">
					<?php wp_nonce_field( 'ninjaworkspace_popup_settings_action', 'ninjaworkspace_popup_settings_nonce' ); ?>
					<h2><?php echo esc_html__('Popup Settings', 'ninjaworkspace');?></h2>
					<div class="popup_main_warpper">
						<div class="popup_data">
							<input type="checkbox" id="ninjaworkspace_desktop_checkbox" name="ninjaworkspace_desktop_checkbox"
								<?php checked( 1, $ninjaworkspace_desktop_checkbox_value ); ?> /> <span
								class="checkbox_headings"><?php echo esc_html__('Enable/Disable Popup ', 'ninjaworkspace');?> <strong><?php echo esc_html__('(Desktop)', 'ninjaworkspace');?></strong></span>
						</div>
						<div class="popup_data">
							<input type="checkbox" id="ninjaworkspace_laptop_checkbox" name="ninjaworkspace_laptop_checkbox"
								<?php checked( 1, $ninjaworkspace_laptop_checkbox_value ); ?> /> <span
								class="checkbox_headings"><?php echo esc_html__('Enable/Disable Popup', 'ninjaworkspace');?> <strong><?php echo esc_html__('(Laptop)', 'ninjaworkspace');?></strong></span>
						</div>
						<div class="popup_data">
							<input type="checkbox" id="ninjaworkspace_tablet_checkbox" name="ninjaworkspace_tablet_checkbox"
								<?php checked( 1, $ninjaworkspace_tablet_checkbox_value ); ?> /> <span
								class="checkbox_headings"><?php echo esc_html__('Enable/Disable Popup', 'ninjaworkspace');?> <strong><?php echo esc_html__('(Tablet)', 'ninjaworkspace');?></strong></span>
						</div>
						<div class="popup_data">
							<input type="checkbox" id="ninjaworkspace_mobile_checkbox" name="ninjaworkspace_mobile_checkbox"
								<?php checked( 1, $ninjaworkspace_mobile_checkbox_value ); ?> /> <span
								class="checkbox_headings"><?php echo esc_html__('Enable/Disable Popup', 'ninjaworkspace');?> <strong><?php echo esc_html__('(Mobile)', 'ninjaworkspace');?></strong></span>
						</div>
						<div class="popup_data">
							<span><input type="number" id="ninjaworkspace_popup_width" name="ninjaworkspace_popup_width"
									min="40" max="100" value="<?php echo esc_attr( $ninjaworkspace_popup_width_value ); ?>">
									<?php echo esc_html('%');?></span> 
									<span class="popup-cust_width"><?php echo esc_html__('Adjust Popup Width', 'ninjaworkspace');?></span>
						</div>
						<div class="popup_data">
							<span><input type="text" id="ninjaworkspace_button_text" name="ninjaworkspace_button_text"
									value="<?php echo esc_attr( $ninjaworkspace_button_text_value ); ?>"></span> <span
								class="popup-cust_width"><?php echo esc_html__('Popup Button Text', 'ninjaworkspace');?></span>

						</div>
						<div class="popup_data">
							<span><input type="text" id="ninjaworkspace_popup_button_color_hover"
									name="ninjaworkspace_popup_button_color_hover"
									value="<?php echo esc_attr( $ninjaworkspace_popup_button_color_hover_value ); ?>"></span>
							<span class="popup-cust_width"><?php echo esc_html__('Popup Button Hover Text Color', 'ninjaworkspace');?></span>
						</div>
						<div class="popup_data">
							<span><input type="text" id="ninjaworkspace_popup_button_background_hover"
									name="ninjaworkspace_popup_button_background_hover"
									value="<?php echo esc_attr( $ninjaworkspace_popup_button_background_hover_value ); ?>"></span>
							<span class="popup-cust_width"><?php echo esc_html__('Popup Button Hover Background Color', 'ninjaworkspace');?></span>

						</div>
						<div class="popup_data">
							<span><input type="text" id="ninjaworkspace_popup_background" name="ninjaworkspace_popup_background"
									value="<?php echo esc_attr( $ninjaworkspace_popup_background_value ); ?>"></span> <span
								class="popup-cust_width"><?php echo esc_html__('Popup Background Color', 'ninjaworkspace');?></span>
						</div>
						<div class="popup_data">
							<span><input type="text" id="ninjaworkspace_popup_close_color"
									name="ninjaworkspace_popup_close_color"
									value="<?php echo esc_attr( $ninjaworkspace_popup_close_color_value ); ?>"></span> <span
								class="popup-cust_width"><?php echo esc_html__('Popup Close Button Color', 'ninjaworkspace');?></span>
						</div>
						<div class="popup_data">
							<span><input type="text" id="ninjaworkspace_popup_close_back" name="ninjaworkspace_popup_close_back"
									value="<?php echo esc_attr( $ninjaworkspace_popup_close_back_value ); ?>"></span> <span
								class="popup-cust_width"><?php echo esc_html__('Popup Close Button Background Color', 'ninjaworkspace');?></span>
						</div>
						<div class="popup_data">
							<span><input type="text" id="ninjaworkspace_popup_image" name="ninjaworkspace_popup_image"
									value="<?php echo esc_attr( $ninjaworkspace_popup_image_value ); ?>"
									placeholder="Upload URL Here"> <input type="button" class="button button-secondary"
									id="upload-image" value="Upload Image" /></span> <span class="popup-cust_width"><?php echo esc_html__('Add Popup
								Button Image', 'ninjaworkspace');?></span>
							<div id="image-preview"></div>
						</div>
					</div>
					<p class="submit">
						<input type="submit" name="submit-popup" id="submit-popup" class="button button-primary"
							value="Save Changes">
						<input type="submit" name="reset-popup" id="reset-popup" class="button btn" value="Reset">
					</p>
				</form>
			</div>
		</div>
		<?php
	}
}

// Add custom script to the header

if (!function_exists('ninjaworkspace_custom_header_script')) { 
	function ninjaworkspace_custom_header_script() { ?>
		<script>
			setTimeout(function () {
				var iframes = document.querySelectorAll("iframe");
				iframes[0].setAttribute("allow", "autoplay *;fullscreen *;microphone *;camera *;display-capture *;clipboard-read *;clipboard-write *");
				var y = iframes[0].parentNode;
				var x = iframes[0];
				x.setAttribute("allow", "autoplay *;fullscreen *;microphone *;camera *;display-capture *;clipboard-read *;clipboard-write *");
				y.appendChild(x);
			}, 3000);
		</script>
		<?php
	}
}

add_action( 'wp_head', 'ninjaworkspace_custom_header_script' );

if (!function_exists('ninjaworkspace_iframe_shortcode')) { 
	function ninjaworkspace_iframe_shortcode() {
		return '<iframe id="nwd_frame" class="cust_iframe"></iframe>';
	}
}

add_shortcode( 'Ninjaworkspace', 'ninjaworkspace_iframe_shortcode' );

if (!function_exists('ninjaworkspace_iframe_style')) { 
	function ninjaworkspace_iframe_style() {
		$ninjaworkspace_desktop_breakpoint_value = get_option( 'ninjaworkspace_desktop_breakpoint' );
		if ( empty( $ninjaworkspace_desktop_breakpoint_value ) ) {
			$ninjaworkspace_desktop_breakpoint_value = '1440';
		}
		$ninjaworkspace_laptop_breakpoint_value = get_option( 'ninjaworkspace_laptop_breakpoint' );
		if ( empty( $ninjaworkspace_laptop_breakpoint_value ) ) {
			$ninjaworkspace_laptop_breakpoint_value = '1280';
		}
		$ninjaworkspace_tablet_breakpoint_value = get_option( 'ninjaworkspace_tablet_breakpoint' );
		if ( empty( $ninjaworkspace_tablet_breakpoint_value ) ) {
			$ninjaworkspace_tablet_breakpoint_value = '1024';
		}
		$ninjaworkspace_mobile_breakpoint_value = get_option( 'ninjaworkspace_mobile_breakpoint' );
		if ( empty( $ninjaworkspace_mobile_breakpoint_value ) ) {
			$ninjaworkspace_mobile_breakpoint_value = '768';
		}
		$desktop_width = get_option( 'ninjaworkspace_desktop_width' );
		if ( empty( $desktop_width ) ) {
			$desktop_width = '100';
		}
		$desktop_height = get_option( 'ninjaworkspace_desktop_height' );
		if ( empty( $desktop_height ) ) {
			$desktop_height = '800';
		}
		$laptop_width = get_option( 'ninjaworkspace_laptop_width' );
		if ( empty( $laptop_width ) ) {
			$laptop_width = '100';
		}
		$laptop_height = get_option( 'ninjaworkspace_laptop_height' );
		if ( empty( $laptop_height ) ) {
			$laptop_height = '800';
		}
		$tablet_width = get_option( 'ninjaworkspace_tablet_width' );
		if ( empty( $tablet_width ) ) {
			$tablet_width = '100';
		}
		$tablet_height = get_option( 'ninjaworkspace_tablet_height' );
		if ( empty( $tablet_height ) ) {
			$tablet_height = '700';
		}
		$mobile_width = get_option( 'ninjaworkspace_mobile_width' );
		if ( empty( $mobile_width ) ) {
			$mobile_width = '100';
		}
		$mobile_height = get_option( 'ninjaworkspace_mobile_height' );
		if ( empty( $mobile_height ) ) {
			$mobile_height = '500';
		}?>
		<style>
			.cust_iframe {
				width: 100% !important;
				height: 1080px !important;
			}
			@media only screen and (min-width:
		<?php echo esc_attr( $ninjaworkspace_desktop_breakpoint_value ); ?>
				px) {
				.cust_iframe {
					width:
						<?php echo esc_attr( $desktop_width ); ?>
						% !important;
					height:
						<?php echo esc_attr( $desktop_height ); ?>
						px !important;
				}
			}
			@media only screen and (max-width:
		<?php echo esc_attr( $ninjaworkspace_desktop_breakpoint_value ); ?>
				px) and (min-width:
		<?php echo esc_attr( $ninjaworkspace_laptop_breakpoint_value ); ?>
				px) {
				.cust_iframe {
					width:
						<?php echo esc_attr( $laptop_width ); ?>
						% !important;
					height:
						<?php echo esc_attr( $laptop_height ); ?>
						px !important;

				}
			}
			@media only screen and (max-width:
		<?php echo esc_attr( $ninjaworkspace_laptop_breakpoint_value ); ?>
				px) and (min-width:
		<?php echo esc_attr( $ninjaworkspace_tablet_breakpoint_value ); ?>
				px) {
				.cust_iframe {
					width:
						<?php echo esc_attr( $tablet_width ); ?>
						% !important;
					height:
						<?php echo esc_attr( $tablet_height ); ?>
						px !important;
				}
			}
			@media only screen and (max-width:
		<?php echo esc_attr( $ninjaworkspace_mobile_breakpoint_value ); ?>
				px) and (min-width: 340px) {
				.cust_iframe {
					width:
						<?php echo esc_attr( $mobile_width ); ?>
						% !important;
					height:
						<?php echo esc_attr( $mobile_height ); ?>
						px !important;
				}
			}
		</style>
		<?php
	}
}

add_action( 'wp_head', 'ninjaworkspace_iframe_style' );

if (!function_exists('ninjaworkspace_button_arrow')) { 
	function ninjaworkspace_button_arrow() {
		echo '<style>';
		echo '.ui-resizable-handle.ui-resizable-sw, .ui-resizable-handle.ui-resizable-nw, .ui-resizable-handle.ui-resizable-ne, .ui-resizable-handle.ui-resizable-se {';
		echo 'background-image: url("' . esc_url( plugins_url( 'images/ui-icons.png', __FILE__ ) ) . '");';
		echo '}';
		echo '</style>';
	}
}

add_action( 'wp_head', 'ninjaworkspace_button_arrow' );

if (!function_exists('ninjaworkspace_button_html')) { 
	function ninjaworkspace_button_html() {
		$ninjaworkspace_desktop_checkbox_value = get_option( 'ninjaworkspace_desktop_checkbox' );
		$ninjaworkspace_laptop_checkbox_value = get_option( 'ninjaworkspace_laptop_checkbox' );
		$ninjaworkspace_tablet_checkbox_value = get_option( 'ninjaworkspace_tablet_checkbox' );
		$ninjaworkspace_mobile_checkbox_value = get_option( 'ninjaworkspace_mobile_checkbox' );
		$ninjaworkspace_button_text_value = get_option( 'ninjaworkspace_button_text' );
		$ninjaworkspace_popup_background_value = get_option( 'ninjaworkspace_popup_background' );
		if ( empty( $ninjaworkspace_popup_background_value ) ) {
			$ninjaworkspace_popup_background_value = '#fff';
		}
		$ninjaworkspace_popup_close_color_value = get_option( 'ninjaworkspace_popup_close_color' );
		if ( empty( $ninjaworkspace_popup_close_color_value ) ) {
			$ninjaworkspace_popup_close_color_value = '#000';
		}
		$ninjaworkspace_popup_close_back_value = get_option( 'ninjaworkspace_popup_close_back' );
		if ( empty( $ninjaworkspace_popup_close_back_value ) ) {
			$ninjaworkspace_popup_close_back_value = '#fff';
		}
		$ninjaworkspace_popup_image_value = get_option( 'ninjaworkspace_popup_image' );
		if ( empty( $ninjaworkspace_popup_image_value ) ) {
			$ninjaworkspace_popup_image_value = plugins_url( 'images/128-n_new.png', __FILE__ );
		}
		$ninjaworkspace_popup_width_value = get_option( 'ninjaworkspace_popup_width' );
		if ( empty( $ninjaworkspace_popup_width_value ) ) {
			$ninjaworkspace_popup_width_value = '75';
		}
		$ninjaworkspace_desktop_breakpoint_value = get_option( 'ninjaworkspace_desktop_breakpoint' );
		if ( empty( $ninjaworkspace_desktop_breakpoint_value ) ) {
			$ninjaworkspace_desktop_breakpoint_value = '1440';
		}
		$ninjaworkspace_laptop_breakpoint_value = get_option( 'ninjaworkspace_laptop_breakpoint' );
		if ( empty( $ninjaworkspace_laptop_breakpoint_value ) ) {
			$ninjaworkspace_laptop_breakpoint_value = '1280';
		}
		$ninjaworkspace_tablet_breakpoint_value = get_option( 'ninjaworkspace_tablet_breakpoint' );
		if ( empty( $ninjaworkspace_tablet_breakpoint_value ) ) {
			$ninjaworkspace_tablet_breakpoint_value = '1024';
		}
		$ninjaworkspace_mobile_breakpoint_value = get_option( 'ninjaworkspace_mobile_breakpoint' );
		if ( empty( $ninjaworkspace_mobile_breakpoint_value ) ) {
			$ninjaworkspace_mobile_breakpoint_value = '768';
		}
		
		if ( $ninjaworkspace_desktop_checkbox_value == 1 ) { ?>
			<a href="#" class="custom-button desktop_screen_pop" id="open-popup-button-desktop" data-toggle="modal"
				data-target="#myModal_desktop">
			<?php echo esc_html( $ninjaworkspace_button_text_value ); ?> <img
					src="<?php echo esc_url( $ninjaworkspace_popup_image_value ); ?>" class="custom_icon_popup_btn" />
			</a>
			<div class="modal bd-example-modal-expand" id="myModal_desktop" role="dialog">
				<div class="modal-dialog modal-expand" style="width:<?php echo esc_attr( $ninjaworkspace_popup_width_value ); ?>%">
					<div class="modal-content"
						style="background-color: <?php echo esc_attr( $ninjaworkspace_popup_background_value ); ?>">
						<button type="button" class="close" data-dismiss="modal"
							style="background-color: <?php echo esc_attr( $ninjaworkspace_popup_close_back_value ); ?>; color:<?php echo esc_attr( $ninjaworkspace_popup_close_color_value ); ?>;">&times;</button>
						<div class="modal-body">
							<div class="custom_modal_dragabled"></div>
							<p>
			<?php
			$desktop_width = get_option( 'ninjaworkspace_desktop_width' );
			if ( empty( $desktop_width ) ) {
				$desktop_width = '100';
			}
			$desktop_height = get_option( 'ninjaworkspace_desktop_height' );
			if ( empty( $desktop_height ) ) {
				$desktop_height = '800';
			}
			?>
			<iframe id="nwd_frame_desktop" src="https://web.nynja.net?wkspid=http%3A%2F%2Flocalhost%2Fai-woocomerce%2Fninja%2F" style="width:<?php echo esc_attr( $desktop_width ); ?>%; height:<?php echo esc_attr( $desktop_height ); ?>px;"></iframe>
							</p>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		if ( $ninjaworkspace_laptop_checkbox_value == 1 ) { ?>
			<a href="#" class="custom-button laptop_screen_pop" id="open-popup-button-laptop" data-toggle="modal"
				data-target="#myModal_laptop">
			<?php echo esc_html( $ninjaworkspace_button_text_value ); ?> <img
					src="<?php echo esc_url( $ninjaworkspace_popup_image_value ); ?>" class="custom_icon_popup_btn" />
			</a>
			<div class="modal bd-example-modal-expand" id="myModal_laptop" role="dialog">
				<div class="modal-dialog modal-expand" style="width:<?php echo esc_attr( $ninjaworkspace_popup_width_value ); ?>%">
					<div class="modal-content"
						style="background-color: <?php echo esc_attr( $ninjaworkspace_popup_background_value ); ?>">
						<button type="button" class="close" data-dismiss="modal"
							style="background-color: <?php echo esc_attr( $ninjaworkspace_popup_close_back_value ); ?>; color:<?php echo esc_attr( $ninjaworkspace_popup_close_color_value ); ?>;">&times;</button>
						<div class="modal-body">
							<div class="custom_modal_dragabled"></div>
							<p>
				<?php
				$laptop_width = get_option( 'ninjaworkspace_laptop_width' );
				if ( empty( $laptop_width ) ) {
					$laptop_width = '100';
				}
				$laptop_height = get_option( 'ninjaworkspace_laptop_height' );
				if ( empty( $laptop_height ) ) {
					$laptop_height = '800';
				} ?>
			<iframe id="nwd_frame_laptop" src="https://web.nynja.net?wkspid=http%3A%2F%2Flocalhost%2Fai-woocomerce%2Fninja%2F" style="width:<?php echo esc_attr( $laptop_width ); ?>%; height:<?php echo esc_attr( $laptop_height ); ?>px;"></iframe>
							</p>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		if ( $ninjaworkspace_tablet_checkbox_value == 1 ) { ?>
			<a href="#" class="custom-button tablet_screen_pop" id="open-popup-button-tablet" data-toggle="modal"
				data-target="#myModal_tablet">
			<?php echo esc_html( $ninjaworkspace_button_text_value ); ?> <img
					src="<?php echo esc_url( $ninjaworkspace_popup_image_value ); ?>" class="custom_icon_popup_btn" />
			</a>
			<div class="modal bd-example-modal-expand" id="myModal_tablet" role="dialog">
				<div class="modal-dialog modal-expand" style="width:<?php echo esc_attr( $ninjaworkspace_popup_width_value ); ?>%">
					<div class="modal-content"
						style="background-color: <?php echo esc_attr( $ninjaworkspace_popup_background_value ); ?>">
						<button type="button" class="close" data-dismiss="modal"
							style="background-color: <?php echo esc_attr( $ninjaworkspace_popup_close_back_value ); ?>; color:<?php echo esc_attr( $ninjaworkspace_popup_close_color_value ); ?>;">&times;</button>
						<div class="modal-body">
							<div class="custom_modal_dragabled"></div>
							<p>
				<?php
				$tablet_width = get_option( 'ninjaworkspace_tablet_width' );
				if ( empty( $tablet_width ) ) {
					$tablet_width = '100';
				}
				$tablet_height = get_option( 'ninjaworkspace_tablet_height' );
				if ( empty( $tablet_height ) ) {
					$tablet_height = '700';
				}
				?>
			<iframe id="nwd_frame_tablet" src="https://web.nynja.net?wkspid=http%3A%2F%2Flocalhost%2Fai-woocomerce%2Fninja%2F" style="width:<?php echo esc_attr( $tablet_width ); ?>%; height:<?php echo esc_attr( $tablet_height ); ?>px;"></iframe>
							</p>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		if ( $ninjaworkspace_mobile_checkbox_value == 1 ) { ?>
			<a href="#" class="custom-button mobile_screen_pop" id="open-popup-button-mobile" data-toggle="modal"
				data-target="#myModal_mobile">
			<?php echo esc_html( $ninjaworkspace_button_text_value ); ?> <img
					src="<?php echo esc_url( $ninjaworkspace_popup_image_value ); ?>" class="custom_icon_popup_btn" />
			</a>
			<div class="modal bd-example-modal-expand" id="myModal_mobile" role="dialog">
				<div class="modal-dialog modal-expand" style="width:<?php echo esc_attr( $ninjaworkspace_popup_width_value ); ?>%">
					<div class="modal-content"
						style="background-color: <?php echo esc_attr( $ninjaworkspace_popup_background_value ); ?>">
						<button type="button" class="close" data-dismiss="modal"
							style="background-color: <?php echo esc_attr( $ninjaworkspace_popup_close_back_value ); ?>; color:<?php echo esc_attr( $ninjaworkspace_popup_close_color_value ); ?>;">&times;</button>
						<div class="modal-body">
							<div class="custom_modal_dragabled"></div>
							<p>
				<?php
				$mobile_width = get_option( 'ninjaworkspace_mobile_width' );
				if ( empty( $mobile_width ) ) {
					$mobile_width = '100';
				}
				$mobile_height = get_option( 'ninjaworkspace_mobile_height' );
				if ( empty( $mobile_height ) ) {
					$mobile_height = '500';
				}
				?>
			<iframe id="nwd_frame_mobile" src="https://web.nynja.net?wkspid=http%3A%2F%2Flocalhost%2Fai-woocomerce%2Fninja%2F" style="width:<?php echo esc_attr( $mobile_width ); ?>%; height:<?php echo esc_attr( $mobile_height ); ?>px;"></iframe>
							</p>
						</div>
					</div>
				</div>
			</div>
		<?php } 


		$ninjaworkspace_popup_button_color_hover_value = get_option( 'ninjaworkspace_popup_button_color_hover' );
		if ( empty( $ninjaworkspace_popup_button_color_hover_value ) ) {
			$ninjaworkspace_popup_button_color_hover_value = '#fff';
		}
		$ninjaworkspace_popup_button_background_hover_value = get_option( 'ninjaworkspace_popup_button_background_hover' );
		if ( empty( $ninjaworkspace_popup_button_background_hover_value ) ) {
			$ninjaworkspace_popup_button_background_hover_value = '#64cccc';
		}
		?>

		<style>
			.custom-button:hover {
				color:
					<?php echo esc_attr( $ninjaworkspace_popup_button_color_hover_value ); ?>;
				background:
					<?php echo esc_attr( $ninjaworkspace_popup_button_background_hover_value ); ?>;
			}
			@media only screen and (min-width:
		<?php echo esc_attr( $ninjaworkspace_desktop_breakpoint_value ); ?>px) {
				.desktop_screen_pop {
					display: block;
				}
				.laptop_screen_pop,
				.tablet_screen_pop,
				.mobile_screen_pop {
					display: none;
				}
			}
			@media only screen and (max-width:
		<?php echo esc_attr( $ninjaworkspace_desktop_breakpoint_value ); ?>px) and (min-width:
		<?php echo esc_attr( $ninjaworkspace_laptop_breakpoint_value ); ?>px) {
				.laptop_screen_pop {
					display: block;
				}
				.desktop_screen_pop,
				.tablet_screen_pop,
				.mobile_screen_pop {
					display: none;
				}
			}
			@media only screen and (max-width:
		<?php echo esc_attr( $ninjaworkspace_laptop_breakpoint_value ); ?>px) and (min-width:
		<?php echo esc_attr( $ninjaworkspace_tablet_breakpoint_value ); ?>px) {
				.tablet_screen_pop {
					display: block;
				}
				.desktop_screen_pop,
				.laptop_screen_pop,
				.mobile_screen_pop {
					display: none;
				}
			}
			@media only screen and (max-width:
		<?php echo esc_attr( $ninjaworkspace_mobile_breakpoint_value ); ?>px) and (min-width: 340px) {
				.mobile_screen_pop {
					display: block;
				}
				.desktop_screen_pop,
				.laptop_screen_pop,
				.tablet_screen_pop {
					display: none;
				}
			}
		</style>
		<script id="nynwidget_script_exe">
			var nynWidgetOptions = {
				start_timeout: 100,
				default_url: "", // -- here inside brackets should be User Profile Embedded link
				frame_id: "nwd_frame",
				view_mode: "static",
				to_create_html: true,
				to_show_widget_button: false,
				to_show_frame_onstart: true,
				to_load_ninjaworkspace_onstart: true
			};
		</script>
		<script id="nynwidget_script_src" src="https://worker.nynja.net/v1/Content/NynWidget/nynwidget.js"
			type="text/javascript"></script>
		<?php
	}
}
add_action( 'wp_footer', 'ninjaworkspace_button_html' );