<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

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
	),
);

echo '<div class="custom-widget">';
echo wp_kses( $shortcode_content, $allowed_html );
echo '</div>';
