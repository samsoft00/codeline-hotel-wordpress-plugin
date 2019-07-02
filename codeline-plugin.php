<?php
/**
 * @package CodelinePlugin
 */

/*
 * Plugin Name: Codeline Plugin
 * Plugin URI: http://codeline.io
 * Description: Plugin to manage codeline hotel management system
 * Version: 1.0.0
 * Author: Oyewole Samuel "Samsoft"
 * Author URI: http://oyewoleabayomi.com
 * License: GPLv2
 * Text Domain: Codeline Hotel Management Plugin
 */

 if( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ){
     require_once dirname( __FILE__ ) . '/vendor/autoload.php';
 }

 if ( ! defined( 'CL_PLUGIN_DIR' ) ) { define( 'CL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) ); }

 /**
  * This code activate codeline plugin
  */
 function activate_codeline_plugin() {
    Samsoft\Base\Activate::activate();
 }

 register_activation_hook( __FILE__, 'activate_codeline_plugin' );


 /**
  * This code activate codeline plugine
  */
 function deactivate_codeline_plugin() {
   Samsoft\Base\Deactivate::deactivate();
}

register_deactivation_hook( __FILE__, 'deactivate_codeline_plugin' );


/**
 * Initialize
 */
 if( class_exists( 'Samsoft\\Init' ) ){
    Samsoft\Init::register_services();
 }