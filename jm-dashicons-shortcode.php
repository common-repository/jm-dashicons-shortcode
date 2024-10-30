<?php
/*
Plugin Name: JM Dashicons Shortcode
Plugin URI: http://www.tweetpress.fr
Description: Meant to add a shortcode with dashicons, require at least WordPress 3.8
Author: Julien Maury
Author URI: http://www.tweetpress.fr
Version: 1.7.2
License: GPL2++
*/


// Sources : http://melchoyce.github.io/dashicons/
//			 https://core.trac.wordpress.org/browser/trunk/wp-includes/js/wp-pointer.dev.js?rev=18707
//           https://core.trac.wordpress.org/changeset/26547/trunk
//			 http://css-tricks.com/examples/PseudoIconTest/
//           http://www.wpexplorer.com/wordpress-tinymce-tweaks


//Add some security, no direct load !
defined( 'ABSPATH' ) or	die( 'No !' );

define( 'JM_DS_VERSION', '1.7.2' );
define( 'JM_DS_DIR', plugin_dir_path( __FILE__ )  );
define( 'JM_DS_INC_DIR', trailingslashit( JM_DS_DIR . 'inc') );
define( 'JM_DS_CSS_URL', trailingslashit( plugin_dir_url( __FILE__ ). '/css' ) );
define( 'JM_DS_JS_URL', trailingslashit( plugin_dir_url( __FILE__ ). '/js' ) );
define( 'JM_DS_LANG_DIR', dirname( plugin_basename(__FILE__) ) . '/languages/');

//Call modules 
add_action('plugins_loaded','_jm_ds_init');
function _jm_ds_init() {

	require( JM_DS_INC_DIR.'main.php' );  

	if( is_admin() ) {

		require( JM_DS_INC_DIR.'tinymce.php' ); 
		require( JM_DS_INC_DIR.'helpers_pointers.php' ); 

	}
}

// Language support
add_action( 'admin_init', 'jm_ds_lang_init' );
function jm_ds_lang_init() {
	load_plugin_textdomain( 'jm-ds', false, JM_DS_LANG_DIR );
}