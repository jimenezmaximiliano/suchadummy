<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content\Metadata\Parsers;

use Tightenco\Collect\Support\Collection;

interface MetadataParser
{
    public function parseMetadata(string $rawMetadata): Collection;
}
