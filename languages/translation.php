<?php
defined( 'ABSPATH' ) or	die( 'No !' );


if ( ! class_exists( '_WP_Editors' ) )
    require( ABSPATH . WPINC . '/class-wp-editor.php' );

	
function jm_ds_tinymce_plugin_translation() {

	$strings = array(
		'popup_title' 	=> esc_js( __('Insert Dashicons Shortcode', 'jm-ds' ) ) ,
		'color_input' => esc_js( __('Which color do you want?', 'jm-ds' ) ) ,
		'size_input' 	=> esc_js( __('Which size (em) ?', 'jm-ds' ) ) ,
		'access_input'	=> esc_js( __('Text for screen reader', 'jm-ds' ) ) ,
		'css_class_input' 	=> esc_js( __('Custom css class name', 'jm-ds' ) ) ,
	
	);

	$locale = _WP_Editors::$mce_locale;
    $translated = 'tinyMCE.addI18n("' . $locale . '.jm_ds_tinymce_plugin", ' . json_encode( $strings ) . ");\n";

    return $translated;
}

$strings = jm_ds_tinymce_plugin_translation();