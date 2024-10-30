<?php
defined( 'ABSPATH' ) or	die( 'No !' );

//Enqueue style for Dashicons
add_action('wp_enqueue_scripts', '_jm_ds_dashicons');
function _jm_ds_dashicons() {

		wp_enqueue_style('dashicons');

}

//Dashicons Shortcode
add_shortcode('dashicon', '_jm_ds_dashicons_sc');
function _jm_ds_dashicons_sc($atts) {
    $args = shortcode_atts(array(
    'name'  => '',
	'text'  => '',
	'color' => '000',
    'size'  => 2,
	'class' => ''
    ), $atts, 'dashicons_shortcode');
     
    $naming = ($args['name']) ? 'dashicons-'.$args['name']. '' : 'dashicons-smartphone';
	$text   = ($args['text']) ? $args['text'] : $args['name'];
	$size   = ( is_float($args['size']) ) ? $args['size'] : floatval($args['size']); 
	
	
	$output  = '<!--JM Dashicons Shortcode version ' . JM_DS_VERSION . '-->'. "\n";
    $output .= '<span class="ds-fallback-text '.sanitize_html_class($args['class']).'">'. "\n";
	$output .= '<span class="dashicons '.sanitize_html_class($naming).'" style="color:#'.sanitize_html_class($args['color']).'; font-size:'.$size.'em;" aria-hidden="true"></span>'. "\n";
	$output .= '<span class="screen-reader-text">'.sanitize_text_field($text).'</span>'. "\n";// make use the WordPress class screen-reader-text --> tips ^^
	$output .= '</span>'. "\n";
	$output .= '<!--/JM Dashicons Shortcode version ' . JM_DS_VERSION . '-->'. "\n";
     
	return apply_filters('jmds_markup', $output);
}

//widgetize it!
add_action('init','_jm_ds_widgetize_shortcode');
function _jm_ds_widgetize_shortcode(){
	 add_filter('widget_text', 'do_shortcode'); //shortcode in sidebar
	 add_filter('wp_nav_menu_items', 'do_shortcode'); //shortcode in menu
}

