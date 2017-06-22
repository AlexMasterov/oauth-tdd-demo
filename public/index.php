<?php

use Symfony\Component\HttpFoundation\Request;

$rootDir = dirname(__DIR__);

require "{$rootDir}/vendor/autoload.php";
require "{$rootDir}/app/env.php";
include_once "{$rootDir}/var/bootstrap.php.cache";

$kernel = new AppKernel('prod', false);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);
