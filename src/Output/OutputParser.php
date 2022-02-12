<?php
/*
 * Copyright (c) Rafał Mikołajun 2022.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mikoweb\CLIExecutor\Output;

final class OutputParser implements OutputParserInterface
{
    public function parse(string $output): array
    {
        preg_match("/<output>(.*)<\/output>/ms", $output, $matches);

        if (count($matches) === 2) {
            $data = trim($matches[1]);

            if (($pos = strpos($data, '</output>')) !== false) {
                $data = substr($data, 0, $pos);
            }

            return json_decode($data, true) ?? [];
        }

        return [];
    }
}
