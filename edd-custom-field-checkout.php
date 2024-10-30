<?php
/**
 * Plugin Name: Custom Field Checkout For Easy Digital Downloads
 * Description: Custom field can be add in Easy Digital Downloads like text field , select field
 * Version:     1.0
 * Author:      Gravity Master
 * License:     GPLv2 or later
 * Text Domain: cfcedd
 */

/* Stop immediately if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/* All constants should be defined in this file. */
if ( ! defined( 'CFCEDD_PREFIX' ) ) {
	define( 'CFCEDD_PREFIX', 'cfcedd' );
}
if ( ! defined( 'CFCEDD_PLUGINDIR' ) ) {
	define( 'CFCEDD_PLUGINDIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'CFCEDD_PLUGINBASENAME' ) ) {
	define( 'CFCEDD_PLUGINBASENAME', plugin_basename( __FILE__ ) );
}
if ( ! defined( 'CFCEDD_PLUGINURL' ) ) {
	define( 'CFCEDD_PLUGINURL', plugin_dir_url( __FILE__ ) );
}

/* Auto-load all the necessary classes. */
if( ! function_exists( 'cfcedd_class_auto_loader' ) ) {
	
	function cfcedd_class_auto_loader( $class ) {
		
	 	$includes = CFCEDD_PLUGINDIR . 'includes/' . $class . '.php';
		
		if( is_file( $includes ) && ! class_exists( $class ) ) {
			include_once( $includes );
			return;
		}
		
	}
}
spl_autoload_register('cfcedd_class_auto_loader');

new CFCEDD_Admin();
new CFCEDD_Frontend();
?>