<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Intracto/src/autoload.php';

$app = new Silex\Application();

$kernel = new Intracto\Kernel(__DIR__ . "/config.php");

$app['debug'] = true;

$kernel->load($app);


$app->mount('/', new Intracto\Controllers\DefaultController());

header('P3P: CP="NOI ADM DEV COM NAV OUR STP"');
$app->run();
