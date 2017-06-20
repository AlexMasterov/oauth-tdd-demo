<?php
declare(strict_types=1);

use josegonzalez\Dotenv\Loader;

$rootDir = \dirname(__DIR__, 1);

$loader = new Loader("{$rootDir}/.env");
$loader->parse()->putEnv(false);
