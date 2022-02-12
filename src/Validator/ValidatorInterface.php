<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\CLIExecutor\Validator;

use Mikoweb\CLIExecutor\Output\OutputInterface;

interface ValidatorInterface
{
    public function validate(OutputInterface $output, bool $throwable = true): ValidationResultInterface;
}
