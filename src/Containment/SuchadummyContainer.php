<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Containment;

use Tightenco\Collect\Support\Collection;
use Jimenezmaximiliano\Suchadummy\Content\AbstractContent;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\Metadata;

class SuchadummyContainer
{
    /** @var Collection */
    private $metadata;
    /** @var string */
    private $content;
    /** @var string */
    private $filePath;

    public function __construct(Collection $metadata, string $content, string $filePath)
    {
        $this->metadata = $metadata;
        $this->content = $content;
        $this->filePath = $filePath;
    }

    public function getMetadata(): Collection
    {
        return $this->metadata;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function isPublication(): bool
    {
        return $this->metadata->get(Metadata::CONTENT_TYPE)
                    === AbstractContent::TYPE_PUBLICATION;
    }

    public function isCategory(): bool
    {
        return $this->metadata->get(Metadata::CONTENT_TYPE)
            === AbstractContent::TYPE_CATEGORY;
    }
}
