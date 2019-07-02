<?php

    namespace Samsoft;

use Samsoft\Base\Enqueue;

final class Init
    {
        /**
         * Store all class inside array */   
        public static function get_service(){
            return [
                //base class
                Enqueue::class
            ];
        }

        /**
         * Initialize class and check if register method exists;
         */
        public static function register_services(){

            foreach (self::get_service() as $class) {
                # code...
                $service = self::instantiate($class);

                if( method_exists( $service, 'register' ) ){
                    
                    $service->register();

                }

            }
        }

        //Initialize class 
        public static function instantiate( $class ){

            return new $class();

        }
    }
    
