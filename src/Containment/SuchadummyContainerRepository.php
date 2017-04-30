<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Containment;

use Tightenco\Collect\Support\Collection;

class SuchadummyContainerRepository
{
    /** @var FileRepository */
    private $fileRepository;
    /** @var string */
    private $path;

    public function __construct(
        string $path,
        FileRepository $fileRepository
    )
    {
        $this->fileRepository = $fileRepository;
        $this->path = $path;
    }

    /**
     * @return SuchadummyContainer[] | Collection
     */
    public function getAll(): Collection
    {
        return $this->fileRepository->getByPath($this->path);
    }

    /**
     * @return SuchadummyContainer[] | Collection
     */
    public function getPublicationContainers(): Collection
    {
        return $this->getAll()
            ->filter(function (SuchadummyContainer $container) {
                return $container->isPublication();
            });
    }

    /**
     * @return SuchadummyContainer[] | Collection
     */
    public function getCategoryContainers(): Collection
    {
        return $this->getAll()
            ->filter(function (SuchadummyContainer $container) {
                return $container->isCategory();
            });
    }
}
