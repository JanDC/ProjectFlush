#!/usr/bin/env php
<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/src/autoload.php';
require_once __DIR__ . '/src/Command/command_autoload.php';

use Silex\Application; //using silex app to make use of all those loaders/vendors/classes/debugging/...

$input = new \Symfony\Component\Console\Input\ArgvInput();
$app = new Application();
$app['debug'] = true;
$kernel = new \Intracto\Kernel(__DIR__ . '/../web/config.php');
$kernel->load($app, 'cli');
$commandName = $input->getFirstArgument();
if (isset($commandList[$commandName])) {
    $commandClass = $commandList[$commandName]['class'];
    $commandObject = new $commandClass($app);
    $commandObject->execute($input);
} else {
    if (strlen($commandName) > 0) {
        echo getColoredString("\n Command not found. Is it properly registered? \n", 'red');
    }
    echo getColoredString("\n These are the registered commands \n ", 'brown');
    foreach ($commandList as $commandEntry => $class) {
        echo getColoredString("\n " . $commandEntry . "", 'green');
    }
    echo " \n";
}

function getColoredString($string, $color)
{
    $colors = array(
        'green' => '0;32',
        'red' => '0;31',
        'brown' => '0;33',
    );
    $colored_string = "";
    $colored_string .= "\033[" . $colors[$color] . "m";
    $colored_string .= $string . "\033[0m";
    return $colored_string;
}


