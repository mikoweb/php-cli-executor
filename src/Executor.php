<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\CLIExecutor;

use Mikoweb\CLIExecutor\Output\Output;
use Mikoweb\CLIExecutor\Output\OutputInterface;
use Mikoweb\CLIExecutor\Output\JsonOutputParser;
use Mikoweb\CLIExecutor\Output\OutputParserInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

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
        $this->outputParser = $outputParser ?? new JsonOutputParser();
    }

    public function execute(
        array $command,
        string $cwd = null,
        array $env = null,
        $input = null,
        ?float $timeout = 60
    ): OutputInterface
    {
        $process = new Process($this->pathResolver->resolve($command), $cwd, $env, $input, $timeout);

        try {
            $process->mustRun();
        } catch (ProcessFailedException $exception) {
            $data = json_encode([
                'status' => $exception->getProcess()->getExitCode(),
                'error_message' => $exception->getMessage(),
            ]);

            return new Output($this->outputParser, $process, "<output>$data</output>");
        }

        return new Output($this->outputParser, $process);
    }

    public function executeAsync(
        array $command,
        string $cwd = null,
        array $env = null,
        $input = null,
        ?float $timeout = 60
    ): OutputInterface
    {
        $process = new Process($this->pathResolver->resolve($command), $cwd, $env, $input, $timeout);
        $process->start();

        return new Output($this->outputParser, $process);
    }
}
