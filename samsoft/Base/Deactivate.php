<?php 

    namespace Samsoft\Base;

    class Deactivate
    {  
        public function deactivate(){
            flush_rewrite_rules();
        }


    }
    