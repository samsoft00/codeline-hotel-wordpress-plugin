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

//  defined( 'ABSPATH ' ) or die( 'Unknow data attack, try again!' );

 if( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ){
     require_once dirname( __FILE__ ) . '/vendor/autoload.php';
 }

 class CodelinePlugin{

    function __construct(){

        $this->setup_constants();


        add_action( 'init', [ $this, 'custom_endpoint' ] );


        add_filter( 'template_include', [$this, 'sam_include_custom_template'] );


    }

    public function setup_constants() {
        // Plugin Folder Path
        if ( ! defined( 'SAM_CL_PLUGIN_DIR' ) ) {
            define( 'SAM_CL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
        }
    }

    public function custom_endpoint() {

         add_rewrite_endpoint( 'rooms', EP_ALL );

    }


    public function sam_include_custom_template( $template ) {
        global $wp_query;


        if( isset($wp_query->query['rooms']) ){

            if ( get_query_var( 'rooms' ) ) {
                return SAM_CL_PLUGIN_DIR . 'templates/view-room.php';
            } else {
                return SAM_CL_PLUGIN_DIR . 'templates/all-rooms.php';
            }

        }

        return $template;

    }

    function plugin_activation(){
        //flush rewrite rules
        flush_rewrite_rules();
    }

    function plugin_deactivation(){}

    function plugin_uninstall(){
        flush_rewrite_rules();
    }

    function enqueue(){
        //enqueue all our scripts
        wp_enqueue_style( 'mypluginstyle', plugin_url( '/assets/mystyle.css', __FILE__ ) );
    }
 }

 if( class_exists('CodelinePlugin') ){
    $codelinePlugin = new CodelinePlugin();
    // $codelinePlugin->register();
 }

 //Activation hook
 register_activation_hook( __FILE__, array( $codelinePlugin, 'plugin_activation' ) );

 //DeActivation Hook
 register_deactivation_hook( __FILE__, array( $codelinePlugin, 'plugin_deactivation' ) );

 //Uninstall hook
//  register_uninstall_hook( __FILE__, array( $codelinePlugin, 'plugin_uninstall' ) );