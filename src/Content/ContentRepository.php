<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content;

use Jimenezmaximiliano\Suchadummy\Containment\SuchadummyContainer;
use Jimenezmaximiliano\Suchadummy\Containment\SuchadummyContainerRepository;
use Jimenezmaximiliano\Suchadummy\Content\Category\Category;
use Jimenezmaximiliano\Suchadummy\Content\Category\CategoryFactory;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\Metadata;
use Jimenezmaximiliano\Suchadummy\Content\Publication\Publication;
use Jimenezmaximiliano\Suchadummy\Content\Publication\PublicationFactory;
use Tightenco\Collect\Support\Collection;

class ContentRepository
{
    /** @var SuchadummyContainerRepository */
    private $containerRepository;
    /** @var CategoryFactory */
    private $categoryFactory;
    /** @var PublicationFactory */
    private $publicationFactory;
    /** @var Collection | Category[] */
    private $categories;
    /** @var Collection | Publication[] */
    private $publications;

    public function __construct(
        SuchadummyContainerRepository $containerRepository,
        PublicationFactory $publicationFactory,
        CategoryFactory $categoryFactory
    )
    {
        $this->containerRepository = $containerRepository;
        $this->categoryFactory = $categoryFactory;
        $this->publicationFactory = $publicationFactory;
        $this->categories = new Collection;
        $this->publications = new Collection;

        $this->getAll();
    }

    /**
     * @return Collection | Publication[]
     */
    public function getPublications(): Collection
    {
        return $this->publications;
    }

    /**
     * @return Collection | Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    private function getAll(): void
    {
        $this->containerRepository
            ->getCategoryContainers()
            ->map(function (SuchadummyContainer $container) {
                return $this->categoryFactory->make($container);
            })
            ->each(function (Category $category) {
                $this->categories->put($category->getId(), $category);
            });

        $this->containerRepository->getPublicationContainers()
            ->map(function (SuchadummyContainer $container) {
                $publication = $this->publicationFactory->make($container);
                $categoryIds = $container->getMetadata()->get(Metadata::CATEGORIES);

                $this->categories
                    ->filter(function (Category $category) use ($categoryIds) {
                        return in_array($category->getId(), $categoryIds);
                    })
                    ->each(function (Category $category) use ($publication) {
                        $category->addPublication($publication);
                        $publication->addCategory($category);
                    });

                return $publication;
            })
            ->each(function (Publication $publication) {
                $this->publications->put($publication->getId(), $publication);
            });
    }
}
