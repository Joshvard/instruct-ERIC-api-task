<?php
    // Simple autoloader for our classes
    function autoloader($classWithNamespace){
        // Code to handle namespaces
        $parsedClassName = explode('\\', $classWithNamespace);
        $class = end($parsedClassName);
        $classLoadPath = $_SERVER['DOCUMENT_ROOT'] . '/classes/' . __NAMESPACE__ . $class . '.php';

        if(file_exists($classLoadPath)){
            require_once $classLoadPath;
        }
    }

    spl_autoload_register('autoloader');
?>