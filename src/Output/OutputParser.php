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
        preg_match("/<output>(.*?)<\/output>/", $output, $matches);

        if (count($matches) === 2) {
            return json_decode($matches[1], true) ?? [];
        }

        return [];
    }
}
