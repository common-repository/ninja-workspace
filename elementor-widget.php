<?php
class Ninjaworkspace_Elementor_Widget extends \Elementor\Widget_Base {
	// Widget properties and methods here
	public function get_name() {
		return 'ninjaworkspace_elementor_widget';
	}
	public function get_title() {
		return __( 'NINJA Workspace Widget', 'ninjaworkspace' );
	}
	public function get_icon() {
		return 'eicon-shortcode';
	}
	public function get_categories() {
		return array( 'general' );
	}
	protected function _register_controls() {
		// Define your widget controls here
	}
	protected function render() {
		$settings          = $this->get_settings_for_display();
		$shortcode_content = do_shortcode( '[Ninjaworkspace]' );
		$allowed_html = array(
			'div'    => array(
				'class' => array(),
			),
			'iframe' => array(
				'src'             => array(),
				'width'           => array(),
				'height'          => array(),
				'frameborder'     => array(),
				'allowfullscreen' => array(),
				'class'           => array(),
			),
		);

		echo '<div class="custom-widget">';
		echo wp_kses( $shortcode_content, $allowed_html );
		echo '</div>';
	}
}
