<?php
    require_once 'autoloader.php';

    // Start the API routing here
    \Classes\Router::routeRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
?>