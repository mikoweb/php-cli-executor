<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\CLIExecutor\Output;

use Symfony\Component\Process\Process;

interface OutputInterface
{
    public function getRawOutput(): string;
    public function getData(): OutputDataInterface;
    public function getProcess(): Process;
    public function getErrorMessage(): ?string;
    public function getStatus(): ?int;
    public function isSuccessful(): bool;
}
