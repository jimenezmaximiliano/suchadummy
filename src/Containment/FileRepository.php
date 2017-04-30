<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Containment;

use Tightenco\Collect\Support\Collection;
use Jimenezmaximiliano\Suchadummy\Containment\Parsers\FileParser;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class FileRepository
{
    /** @var FileParser */
    private $fileParser;
    /** @var Finder */
    private $finder;

    public function __construct(FileParser $fileParser, Finder $finder)
    {
        $this->fileParser = $fileParser;
        $this->finder = $finder;
    }

    /**
     * @param string $path
     * @param string $pattern
     * @return Collection | SuchadummyContainer[]
     */
    public function getByPath(string $path, string $pattern = '*.md'): Collection
    {
        $fileCollection = new Collection(
            $this->finder->files()->in($path)->name($pattern)
        );

        return $fileCollection->map(function (SplFileInfo $file) {
            return $this->fileParser->parseFile($file);
        });
    }
}
