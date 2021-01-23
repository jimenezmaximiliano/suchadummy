<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content\Publication;

use Tightenco\Collect\Support\Collection;
use Jimenezmaximiliano\Suchadummy\Content\AbstractContent;
use Jimenezmaximiliano\Suchadummy\Content\Category\Category;

class Publication extends AbstractContent
{
    /** @var Category[] | Collection */
    private $categories;

    public function __construct(string $id, string $content)
    {
        parent::__construct($id);
        $this->categories = new Collection;
        $this->content = $content;
        $this->id = $id;
    }

    public function addCategory(Category $category): void
    {
        $this->categories->put($category->getId(), $category);
    }

    public function hasCategory(string $categoryId): bool
    {
        return $this->categories->has($categoryId);
    }

    /**
     * @return Category[] | Collection
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
}
