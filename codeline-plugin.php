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
 if ( ! defined( 'CL_PLUGIN_URI' ) ) { define( 'CL_PLUGIN_URI', plugin_dir_url( __FILE__ ) ); }

 class CodelinePlugin
 {
   function __construct(){
            
      add_action( 'init', [ $this, 'custom_endpoint' ] );

      add_filter( 'template_include', [$this, 'include_custom_template'] );            
      
  }

   public function custom_endpoint() {

      add_rewrite_endpoint( 'rooms', EP_ALL );

   }        

  public function include_custom_template( $template ) {
      global $wp_query;

      if( isset($wp_query->query['rooms']) ){

          if ( get_query_var( 'rooms' ) ) {
              return CL_PLUGIN_DIR . 'templates/view-room.php';
          } else {
              return CL_PLUGIN_DIR . 'templates/all-rooms.php';
          }

      }

      return $template;

   }

 }

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
 if( class_exists( 'Samsoft\\Init' ) && class_exists( 'CodelinePlugin' ) ){
   new CodelinePlugin();
   Samsoft\Init::register_services();
 }