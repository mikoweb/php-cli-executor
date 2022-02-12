<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\CLIExecutor\Output;

interface OutputDataInterface
{
    public function getData(): array;
    public function get(string $key);
    public function has(string $key): bool;
}
