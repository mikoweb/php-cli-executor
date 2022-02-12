<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\CLIExecutor\Validator;

use Mikoweb\CLIExecutor\Output\OutputInterface;

interface ValidationResultInterface
{
    public function isValid(): bool;
    public function getMessage(): ?string;
    public function getStatus(): ?int;
}
