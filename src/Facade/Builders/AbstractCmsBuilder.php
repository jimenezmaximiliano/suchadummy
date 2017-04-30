<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Facade\Builders;

use Jimenezmaximiliano\Suchadummy\Content\ContentRepository;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\MetadataIdFactory;
use Tightenco\Collect\Support\Collection;
use Jimenezmaximiliano\Suchadummy\Containment\FileRepository;
use Jimenezmaximiliano\Suchadummy\Containment\Parsers\FileParser;
use Jimenezmaximiliano\Suchadummy\Containment\Parsers\FileSplitter;
use Jimenezmaximiliano\Suchadummy\Containment\SuchadummyContainerRepository;
use Jimenezmaximiliano\Suchadummy\Content\Category\CategoryFactory;
use Jimenezmaximiliano\Suchadummy\Content\Category\CategoryService;
use Jimenezmaximiliano\Suchadummy\Content\IdFactory;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\Parsers\MetadataParser;
use Jimenezmaximiliano\Suchadummy\Content\Parsers\ContentParser;
use Jimenezmaximiliano\Suchadummy\Content\Publication\PublicationFactory;
use Jimenezmaximiliano\Suchadummy\Content\Publication\PublicationService;
use Jimenezmaximiliano\Suchadummy\Content\Variables\VariableParser;
use Jimenezmaximiliano\Suchadummy\Facade\Cms;
use Symfony\Component\Finder\Finder;

abstract class AbstractCmsBuilder implements CmsBuilder
{
    /** @var ContentParser[] | Collection */
    protected $contentParsers;
    /** @var VariableParser */
    protected $variableParser;
    /** @var MetadataParser */
    protected $metadataParser;
    /** @var IdFactory */
    protected $idFactory;
    /** @var string */
    protected $contentFence;
    /** @var string */
    protected $dateFormat;
    /** @var string */
    private $filesPath;
    /** @var null | Collection */
    private $vars;
    /** @var  FileParser */
    private $fileParser;
    /** @var FileRepository */
    private $fileRepository;
    /** @var CategoryFactory */
    private $categoryFactory;
    /** @var PublicationFactory */
    private $publicationFactory;
    /** @var CategoryService */
    private $categoryService;
    /** @var PublicationService */
    private $publicationService;

    public function setFilesPath(string $filesPath): void
    {
        $this->filesPath = $filesPath;
    }

    /**
     * @param string[] | Collection | null $vars
     */
    public function setVars(Collection $vars = null): void
    {
        $this->vars = $vars;
    }

    public function buildCms(): Cms
    {
        $this->setFileParser();
        $this->setIdFactory();
        $this->setFileRepository();
        $this->setContentFactories();
        $this->setServices();

        return new Cms($this->publicationService, $this->categoryService);
    }

    private function setIdFactory(): void
    {
        $this->idFactory = new MetadataIdFactory;
    }

    private function setFileParser(): void
    {
        $fileSplitter = new FileSplitter($this->contentFence);

        $this->fileParser = new FileParser(
            $this->contentParsers->prepend($this->variableParser),
            $this->metadataParser,
            $fileSplitter,
            $this->vars
        );
    }

    private function setFileRepository(): void
    {
        $this->fileRepository = new FileRepository(
            $this->fileParser,
            new Finder
        );
    }

    private function setContentFactories(): void
    {
        $this->categoryFactory = new CategoryFactory($this->dateFormat, $this->idFactory);
        $this->publicationFactory = new PublicationFactory($this->dateFormat, $this->idFactory);
    }

    private function setServices(): void
    {
        $containerRepository = new SuchadummyContainerRepository($this->filesPath, $this->fileRepository);
        $contentRepository = new ContentRepository(
            $containerRepository,
            $this->publicationFactory,
            $this->categoryFactory
        );
        $this->publicationService = new PublicationService($contentRepository);
        $this->categoryService = new CategoryService($contentRepository);
    }

    abstract public function setContentParsers(): void;
    abstract public function setVariableParser(): void;
    abstract public function setMetadataParser(): void;
    abstract public function setContentFence(): void;
    abstract public function setDateFormat(): void;
}
