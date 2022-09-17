#!/usr/bin/php
<?php

define('ROOT_PATH', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);

require __DIR__ . DIRECTORY_SEPARATOR . 'config/bootstrap.php';

use Console\ConsoleApplication;
use Console\Command\CommandLoader;
use Console\Input\InputParser;

$command_loader = new CommandLoader([
    'display_command'=>[
        'class'=>\App\Commands\DisplayCommand::class,
        'name'=>'Display Command',
        'description'=>'Command for displaying input params',
    ]
]);

(new ConsoleApplication($command_loader, new InputParser()))->run();
