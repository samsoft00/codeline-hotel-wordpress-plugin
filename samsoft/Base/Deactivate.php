<?php 

    namespace Samsoft\Base;

    class Deactivate
    {  
        public function activate(){

            flush_rewrite_rules();

        }


    }
    