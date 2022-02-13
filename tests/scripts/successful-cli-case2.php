<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Mikoweb\CLIExecutor\Writer\WriterBuilder;

$writer = new WriterBuilder();
$writer
    ->setMessage('ok')
    ->printMessageAsSuccess(true)
    ->write()
;

exit(0);
