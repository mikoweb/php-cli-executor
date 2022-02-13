<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\CLIExecutor\Writer;

final class JsonSerializer implements SerializerInterface
{
    public function serialize(array $data): string
    {
        return json_encode($data);
    }
}
