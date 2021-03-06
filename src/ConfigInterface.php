<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\CLIExecutor;

interface ConfigInterface
{
    public function getScriptPath(): string;
    public function getBinPath(): ?string;
}
