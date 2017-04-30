<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Facade\Builders;

use Tightenco\Collect\Support\Collection;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\MetadataIdFactory;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\Parsers\JsonMetadataParser;
use Jimenezmaximiliano\Suchadummy\Content\Parsers\CommonMarkAdapter;
use Jimenezmaximiliano\Suchadummy\Content\Variables\CurlyVariableParser;
use League\CommonMark\CommonMarkConverter;

class DefaultBuilder extends AbstractCmsBuilder
{
    public function setContentParsers(): void
    {
        $this->contentParsers = new Collection([
            new CommonMarkAdapter(new CommonMarkConverter),
        ]);
    }

    public function setVariableParser(): void
    {
        $this->variableParser = new CurlyVariableParser;
    }

    function setMetadataParser(): void
    {
        $this->metadataParser = new JsonMetadataParser;
    }

    public function setContentFence(): void
    {
        $this->contentFence = '========================';
    }

    public function setDateFormat(): void
    {
        $this->dateFormat = 'Y-m-d';
    }
}
