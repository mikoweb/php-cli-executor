<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\CLIExecutor\Output;

use Mikoweb\CLIExecutor\Output\Exceptions\StillRunningException;
use Symfony\Component\Process\Process;

class Output implements OutputInterface
{
    /**
     * @var OutputParserInterface
     */
    protected $outputParser;

    /**
     * @var Process
     */
    protected $process;

    /**
     * @var string|null
     */
    protected $rawOutput;

    /**
     * @var OutputDataInterface|null
     */
    protected $data;

    public function __construct(
        OutputParserInterface $outputParser,
        Process $process,
        ?string $forceRawOutput = null
    )
    {
        $this->outputParser = $outputParser;
        $this->process = $process;
        $this->rawOutput = $forceRawOutput;
        $this->data = null;
    }

    public function getRawOutput(): string
    {
        if ($this->process->isRunning()) {
            throw new StillRunningException('Cannot get output when process is still running.');
        }

        if (is_null($this->rawOutput)) {
            $this->rawOutput = $this->process->getOutput();
        }

        return $this->rawOutput;
    }

    public function getData(): OutputDataInterface
    {
        if (is_null($this->data)) {
            $data = new AssocOutputData($this->outputParser->parse($this->getRawOutput()));
            $this->data = $data;
        }

        return $this->data;
    }

    public function getProcess(): Process
    {
        return $this->process;
    }

    public function getErrorMessage(): ?string
    {
        return $this->getData()->has('error_message')
            ? $this->getData()->get('error_message')
            : null;
    }

    public function getStatus(): ?int
    {
        return $this->getData()->has('status')
            ? (int) $this->getData()->get('status')
            : null;
    }

    public function isSuccessful(): bool
    {
        return $this->getStatus() === OutputStatus::STATUS_SUCCESS;
    }
}
