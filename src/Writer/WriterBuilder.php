<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\CLIExecutor\Writer;

use Mikoweb\CLIExecutor\Output\OutputStatus;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class WriterBuilder
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var SymfonyStyle
     */
    protected $io;

    /**
     * @var string|null
     */
    protected $message;

    /**
     * @var bool
     */
    protected $messageAsSuccess;

    /**
     * @var int
     */
    protected $status;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var string|null
     */
    protected $errorMessage;

    /**
     * @var bool
     */
    protected $errorMessageAsError;

    public function __construct(?SerializerInterface $serializer = null, ?OutputInterface $output = null)
    {
        $this->serializer = $serializer ?? new JsonSerializer();
        $this->output = $output ?? new ConsoleOutput();
        $this->io = new SymfonyStyle(new ArrayInput([]), $this->output);

        $this->message = null;
        $this->messageAsSuccess = false;
        $this->status = OutputStatus::STATUS_SUCCESS;
        $this->data = [];
        $this->errorMessage = null;
        $this->errorMessageAsError = false;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function printMessageAsSuccess(bool $print): self
    {
        $this->messageAsSuccess = $print;

        return $this;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function setErrorMessage(string $errorMessage): self
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    public function printErrorMessageAsError(bool $print): self
    {
        $this->errorMessageAsError = $print;

        return $this;
    }

    public function write(): void
    {
        $data = array_merge($this->data, [
            'status' => $this->status,
        ]);

        $data = array_merge($data, $this->data);

        if (!is_null($this->message)) {
            $data['message'] = $this->message;
        }

        if (!is_null($this->errorMessage)) {
            $data['error_message'] = $this->errorMessage;
        }

        $serialized = $this->serializer->serialize($data);
        $this->io->section("<output>$serialized</output>");

        if (!is_null($this->message) && $this->messageAsSuccess) {
            $this->io->success($this->message);
        }

        if (!is_null($this->errorMessage) && $this->errorMessageAsError) {
            $this->io->error($this->errorMessage);
        }
    }
}
