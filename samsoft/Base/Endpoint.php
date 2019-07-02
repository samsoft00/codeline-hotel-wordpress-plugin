<?php
    namespace Samsoft\Base;

    class Endpoint
    {
        public function register(){
            //Register custom endpoint
            add_rewrite_endpoint( 'rooms', EP_ALL );
        }
    }
    