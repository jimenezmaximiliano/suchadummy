<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content\Metadata\Parsers;

use Tightenco\Collect\Support\Collection;

class JsonMetadataParser implements MetadataParser
{
    public function parseMetadata(string $rawMetadata): Collection
    {
        if (empty($rawMetadata)) {
            return new Collection();
        }

        return new Collection(json_decode($rawMetadata, true));
    }
}
