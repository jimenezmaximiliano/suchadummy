<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content\Publication;

use Jimenezmaximiliano\Suchadummy\Content\Category\Category;
use Jimenezmaximiliano\Suchadummy\Content\ContentRepository;
use Tightenco\Collect\Support\Collection;

class PublicationService
{
    /** @var ContentRepository */
    private $contentRepository;

    public function __construct(ContentRepository $contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }

    /**
     * @return Collection | Publication[]
     */
    public function getAll(): Collection
    {
        return $this->contentRepository->getPublications();
    }

    public function getById(string $id): ?Publication
    {
        return $this->contentRepository->getPublications()->get($id);
    }

    /**
     * @param string $categoryId
     * @return Collection | Category[]
     */
    public function getByCategoryId(string $categoryId): Collection
    {
        return $this->contentRepository->getCategories()->get($categoryId)->getPublications();
    }
}
