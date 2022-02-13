<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\CLIExecutor\Validator;

use Mikoweb\CLIExecutor\Output\OutputInterface;
use Mikoweb\CLIExecutor\Validator\Exceptions\InvalidOutputException;

class Validator implements ValidatorInterface
{
    public function validate(OutputInterface $output, bool $throwable = true): ValidationResultInterface
    {
        $result = new ValidationResult($output->isSuccessful(), $output->getErrorMessage(), $output->getStatus());

        if ($throwable && !$result->isValid()) {
            throw new InvalidOutputException((string) $output->getErrorMessage(), $result, (int) $output->getStatus());
        }

        return $result;
    }
}
