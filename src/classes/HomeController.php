<?php
    namespace Classes;

    /**
     * Home
     */
    class HomeController extends \Classes\Controller{
        // Override function for the GET endpoint
        protected function get($data){
            $this->homeMessage();
        }

        protected function post($data){
            $this->homeMessage();
        }

        private function homeMessage(){
            echo "GET -> /service?countryCode={countryCode}<br/>POST -> /service (ref, centre, service, country)";
        }
    }
?>