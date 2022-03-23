<?php
    // Set working directory for the cli
    $_SERVER['DOCUMENT_ROOT'] = dirname(__FILE__, 2) . '/';

    require_once $_SERVER['DOCUMENT_ROOT'] . '/classes/ServiceCli.php';

    // Begin setting up our invocation of the cli module
    $cli = new \Classes\ServiceCli();

    // Ensure that the process only runs via CLI
    if(!$cli->isCli()){
        http_response_code(404);
    }

    // Start processing CLI inputs!
    $cli->invoke($argv);
?>