<?php
    namespace Samsoft\Base;

    class Enqueue
    {
        public function register(){
            add_action( 'wp_enqueue_scripts', [ $this, 'enqueue' ] );
        }

        function enqueue(){
            // enqueue all our scripts
            wp_enqueue_style( 'mypluginstyle', CL_PLUGIN_URI . 'assets/codeline-style.css' );
            wp_enqueue_script( 'mypluginscript', CL_PLUGIN_URI . 'assets/codeline-script.js' );
        }
    }
    