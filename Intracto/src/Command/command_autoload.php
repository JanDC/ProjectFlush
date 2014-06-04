<?php

require_once 'IntractoCommandInterface.php';

$commandList = array(
    'intracto:doctrine:schema' => array('file' => 'DoctrineSchemaCommand.php', 'class' => 'Intracto\Command\DoctrineSchemaCommand'),);

foreach ($commandList as $commandListEntry) {
    require_once $commandListEntry['file'];
}
