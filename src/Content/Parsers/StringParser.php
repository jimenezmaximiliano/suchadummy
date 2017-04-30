<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content\Parsers;

interface StringParser
{
    public function parse(string $content): string;
}
