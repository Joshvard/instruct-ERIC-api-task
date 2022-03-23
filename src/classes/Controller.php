<?php
    namespace Classes;
    
    /**
     * Main controller class which provides the behaviours of the api endpoints.
     */
    class Controller {
        private $method;

        public function __construct($method = 'GET'){
            $this->setMethod($method);
        }

        // Figure out which api method is being used, direct to the appropriate override method
        public function processEndpoint(){
            if($this->fetchMethod() === 'GET'){
                $this->get($_GET);
            }

            if($this->fetchMethod() === 'POST'){
                $post = json_decode(file_get_contents('php://input'), true);
                $this->post($post);
            }

            $this->badMethod();
        }

        public function processCliInput($data){
            if($this->fetchMethod() === 'GET'){
                $preparedData = array();
                $preparedData['countryCode'] = $data;
                $this->get($preparedData);
            }

            if($this->fetchMethod() === 'POST'){
                $preparedData = array();
                $preparedData['ref'] = $data[2];
                $preparedData['centre'] = $data[3];
                $preparedData['service'] = $data[4];
                $preparedData['country'] = $data[5];
                $this->post($preparedData);
            }
        }

        // Override functions
        protected function get($data){
            
        }

        protected function post($data){
            
        }

        // Any unexpected methods are discarded gracefully here
        protected function badMethod(){
            return http_response_code(404);
        }

        // Getter
        private function fetchMethod(){
            return $this->method;
        }

        // Setter
        private function setMethod($method){
            $this->method = $method;
        }
    }
?>