<?php
    namespace Classes;

    /**
     * Routing rules and logic here, requests will be processed and further directed to the rest of the system if matched with any registered routes
     */
    class Router
    {
        // Process which api endpoint to direct to
        public static function routeRequest($requestUrl, $requestMethod){
            $routes = Router::getRoutes();

            $parsedUrl = strtok($requestUrl, '?');

            // We will go through each route to see if we have a match
            // If a match is found, we continue processing the request
            foreach($routes as $route){
                if($parsedUrl === $route['url']){
                    Router::processRequest($requestMethod, $route['controller']);
                }
            }

            return http_response_code(404);
        }

        // Routes are registered here, these will be used ideally for matching against requests
        private static function getRoutes(){
            return array(
                [
                    "url" => "/service",
                    "controller" => "Classes\ServiceController"
                ],
                [
                    "url" => "/",
                    "controller" => "Classes\HomeController"
                ]
            );
        }

        // Call the registered controller that was assigned to the recently matched url
        private static function processRequest($requestMethod, $class){
            $controller = new $class($requestMethod);
            $controller->processEndpoint();
        }
    }
?>