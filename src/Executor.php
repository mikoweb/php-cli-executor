<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\CLIExecutor;

use Mikoweb\CLIExecutor\Output\OutputInterface;
use Mikoweb\CLIExecutor\Output\OutputParser;
use Mikoweb\CLIExecutor\Output\OutputParserInterface;

class Executor
{
    /**
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @var PathResolver
     */
    protected $pathResolver;

    /**
     * @var OutputParserInterface
     */
    protected $outputParser;

    public function __construct(ConfigInterface $config, OutputParserInterface $outputParser = null)
    {
        $this->config = $config;
        $this->pathResolver = new PathResolver($config);
        $this->outputParser = $outputParser ?? new OutputParser();
    }

    public function execute(
        array $command,
        string $cwd = null,
        array $env = null,
        $input = null,
        ?float $timeout = 60
    ): OutputInterface
    {
        // TODO
    }

    public function executeAsync(
        array $command,
        string $cwd = null,
        array $env = null,
        $input = null,
        ?float $timeout = 60
    ): OutputInterface
    {
        // TODO
    }
}
