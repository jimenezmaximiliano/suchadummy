<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content\Category;

use Jimenezmaximiliano\Suchadummy\Content\ContentRepository;
use Tightenco\Collect\Support\Collection;

class CategoryService
{
    /** @var ContentRepository */
    private $contentRepository;

    public function __construct(ContentRepository $contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }

    /**
     * @return Collection | Category[]
     */
    public function getAll(): Collection
    {
        return $this->contentRepository->getCategories();
    }
}
