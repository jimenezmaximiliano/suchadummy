<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Facade;

use Jimenezmaximiliano\Suchadummy\Content\Category\CategoryService;
use Jimenezmaximiliano\Suchadummy\Content\Publication\Publication;
use Jimenezmaximiliano\Suchadummy\Content\Publication\PublicationService;
use Tightenco\Collect\Support\Collection;

class Cms
{
    /** @var PublicationService */
    private $publicationService;
    /** @var CategoryService */
    private $categoryService;

    public function __construct(
        PublicationService $publicationService,
        CategoryService $categoryService
    )
    {

        $this->publicationService = $publicationService;
        $this->categoryService = $categoryService;
    }

    public function getAllPublications(): Collection
    {
        return $this->publicationService->getAll();
    }

    public function getAllCategories(): Collection
    {
        return $this->categoryService->getAll();
    }

    public function getPublicationById(string $id): ?Publication
    {
        return $this->publicationService->getById($id);
    }

    public function getPublicationsByCategoryId(string $categoryId): Collection
    {
        return $this->publicationService->getByCategoryId($categoryId);
    }
}
