<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\CLIExecutor;

use Symfony\Component\Process\PhpExecutableFinder;

class PathResolver
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var string
     */
    protected $binPath;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->resolveBinPath();
    }

    public function resolve(array $command): array
    {
        return array_merge([$this->binPath, $this->config->getScriptPath()], $command);
    }

    protected function resolveBinPath(): void
    {
        $this->binPath = $this->config->getBinPath() ?? (new PhpExecutableFinder())->find();
    }
}
