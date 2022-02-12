<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\CLIExecutor\Validator;

final class ValidationResult implements ValidationResultInterface
{
    /**
     * @var bool
     */
    private $valid;

    /**
     * @var string|null
     */
    private $message;

    /**
     * @var int|null
     */
    private $status;

    public function __construct(bool $valid, ?string $message, ?int $status)
    {
        $this->valid = $valid;
        $this->message = $message;
        $this->status = $status;
    }

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }
}
