<?php
    namespace Samsoft\Base;

    class Enqueue
    {
        public function register(){
            add_action( 'enqueue_scripts', array( $this, 'enqueue' ) );
        }

        function enqueue(){
            // enqueue all our scripts
            wp_enqueue_style( 'mypluginstyle', CL_PLUGIN_DIR . 'assets/style.css' );
            wp_enqueue_script( 'mypluginscript', CL_PLUGIN_DIR . 'assets/script.js' );
        }
    }
    