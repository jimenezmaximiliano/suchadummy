<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content\Publication;

use Jimenezmaximiliano\Suchadummy\Content\Category\Category;
use Jimenezmaximiliano\Suchadummy\Content\ContentRepository;
use Jimenezmaximiliano\Suchadummy\Content\Exceptions\CategoryNotFound;
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
     * @return Category[]|Collection
     * @throws CategoryNotFound
     */
    public function getByCategoryId(string $categoryId): Collection
    {
        $categories = $this->contentRepository->getCategories();
        if (!$categories->has($categoryId)) {
            throw new CategoryNotFound($categoryId);
        }

        return $categories->get($categoryId)->getPublications();
    }
}
