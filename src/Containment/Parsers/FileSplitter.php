<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Containment\Parsers;

use Jimenezmaximiliano\Suchadummy\Containment\SplitFile;
use Symfony\Component\Finder\SplFileInfo;

class FileSplitter
{
    /** @var string */
    private $rawFileContent;
    /** @var string */
    private $metadataFence;

    public function __construct(string $metadataFence)
    {
        $this->metadataFence = $metadataFence;
    }

    public function split(SplFileInfo $file): SplitFile
    {
        $this->rawFileContent = $file->getContents();

        return new SplitFile(
            $this->getContent(),
            $this->getMetadata()
        );
    }

    private function getContent(): ?string
    {
        $afterFence = $this->getContentStartingPosition();

        return (string) substr($this->rawFileContent, $afterFence);
    }

    private function getContentStartingPosition(): int
    {
        if (empty($this->getFencePosition())) {
            return 0;
        }

        return $this->getFencePosition() + strlen($this->metadataFence);
    }

    private function getMetadata(): string
    {
        return substr($this->rawFileContent, 0, $this->getFencePosition());
    }

    private function getFencePosition(): int
    {
        return (int) strpos($this->rawFileContent, $this->metadataFence);
    }
}
