<?php 

    namespace Samsoft\Base;

    class Activate
    {
        
        function __construct(){
    
            add_action( 'init', [ $this, 'custom_endpoint' ] );
    
    
            add_filter( 'template_include', [$this, 'sam_include_custom_template'] );

        } 

        public function activate(){
        
            flush_rewrite_rules();
        
        }

        public function custom_endpoint() {

            add_rewrite_endpoint( 'rooms', EP_ALL );
   
       }        

        public function sam_include_custom_template( $template ) {
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
    