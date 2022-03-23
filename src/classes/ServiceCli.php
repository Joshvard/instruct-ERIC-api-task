<?php
    namespace Classes;

    class ServiceCli {
        // Check if the script is being run via cli
        public function isCli(){
            if(php_sapi_name() === 'cli'){
                return true;
            }

            exit(http_response_code(404));
        }

        // We will simply try to figure out what command has been entered 
        // and provide a rendering method to draw the information to the console
        public function invoke($args){
            $feedback = $this->argSwitch($args);
            $this->render($feedback);
        }

        // Available commands and their functionality goes here
        // Default should prompt the user to use a help command
        private function argSwitch($args){
            require_once $_SERVER['DOCUMENT_ROOT'] . 'autoloader.php';

            // First 2 elements of the $argv variable are defined for the base command + secondary command
            switch($args[1]){
                case '--help':
                case '-h':
                    $dialogue = "Usage:\n   ";
                    $dialogue .= "service-cli --get  | -g <country>                               For a list of records of services under the specified country code \n   ";
                    $dialogue .= "service-cli --post | -p <ref> <centre> <service> <country>      To insert/update the service records (use an existing reference code to update that specific record)\n";
                    
                    return $dialogue;
                    break;
                case '--get':
                case '-g':
                    if(empty($args[2])){
                        return "\nYou need to supply an argument <country> for service-cli --get|-g\n\n";
                    }

                    $this->get($args[2]);
                    break;
                case '--post':
                case '-p':
                    // Minimum parameter count to be checked here
                    if(count($args) < 6){
                        return "\nYou need to supply more arguments <ref> <centre> <service> <country> for service-cli --post|-p\n\n";
                    }

                    $this->post($args);
                    break;
                default:
                    return "\nIncorrect syntax, use service-cli --help|-h for guidance.\n\n";
            }
        }

        // Setup the controller to process the commands as if they were regular api requests
        private function get($referenceCode){
            require_once $_SERVER['DOCUMENT_ROOT'] . 'classes/ServiceController.php';
            
            $controller = new \Classes\ServiceController('GET');
            $controller->processCliInput($referenceCode);
        }

        private function post($postData){
            require_once $_SERVER['DOCUMENT_ROOT'] . 'classes/ServiceController.php';

            $controller = new \Classes\ServiceController('POST');
            $controller->processCliInput($postData);
        }

        // Draw input to the console
        private function render($feedback){
            echo $feedback;
        }
    }
?>