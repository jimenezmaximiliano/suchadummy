<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Containment\Parsers;

use Jimenezmaximiliano\Suchadummy\Containment\SuchadummyContainer;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\Parsers\MetadataParser;
use Jimenezmaximiliano\Suchadummy\Content\Parsers\ContentParser;
use Jimenezmaximiliano\Suchadummy\Content\Variables\VariableParser;
use Tightenco\Collect\Support\Collection;
use Symfony\Component\Finder\SplFileInfo;

class FileParser
{
    /** @var ContentParser[] | Collection */
    private $contentParsers;
    /** @var  MetadataParser */
    private $metadataParser;
    /** @var FileSplitter */
    private $fileSplitter;
    /** @var Collection */
    private $vars;

    /**
     * @param Collection|ContentParser[] $contentParsers
     * @param MetadataParser $metadataParser
     * @param FileSplitter $fileSplitter
     * @param Collection|null $vars
     */
    public function __construct(
        Collection $contentParsers,
        MetadataParser $metadataParser,
        FileSplitter $fileSplitter,
        Collection $vars = null
    )
    {
        $this->contentParsers = $contentParsers;
        $this->metadataParser = $metadataParser;
        $this->fileSplitter = $fileSplitter;
        $this->vars = $vars ?? new Collection;
    }

    public function parseFile(SplFileInfo $file): SuchadummyContainer
    {
        $splitedFile = $this->fileSplitter->split($file);

        return new SuchadummyContainer(
            $this->getMetadata($splitedFile->getRawMetadata()),
            $this->getContent($splitedFile->getRawContent()),
            $file->getPath()
        );
    }

    private function getMetadata(string $rawMetadata): Collection
    {
        return $this->metadataParser->parseMetadata($rawMetadata);
    }

    private function getContent(string $rawContent): string
    {
        return $this->contentParsers->reduce(function (string $partial, ContentParser $contentParser) {

            if ($contentParser instanceof VariableParser) {
                $contentParser->setVariables($this->vars);
            }

            return $contentParser->parse($partial);
        }, $rawContent);
    }
}
