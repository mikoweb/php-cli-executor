<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\CLIExecutor;

final class Config implements ConfigInterface
{
    /**
     * @var string
     */
    private $scriptPath;

    /**
     * @var string|null
     */
    private $binPath;

    public function __construct(string $scriptPath, ?string $binPath = null)
    {
        $this->scriptPath = $scriptPath;
        $this->binPath = $binPath;
    }

    public function getScriptPath(): string
    {
        return $this->scriptPath;
    }

    public function getBinPath(): ?string
    {
        return $this->binPath;
    }
}
