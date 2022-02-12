<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\CLIExecutor\Validator\Exceptions;

use Exception;
use Mikoweb\CLIExecutor\Validator\ValidationResultInterface;
use Throwable;

class InvalidOutputException extends Exception
{
    /**
     * @var ValidationResultInterface
     */
    protected $validationResult;

    public function __construct(
        string $message,
        ValidationResultInterface $validationResult,
        int $code = 0,
        ?Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);
        $this->validationResult = $validationResult;
    }

    public function getValidationResult(): ValidationResultInterface
    {
        return $this->validationResult;
    }
}
