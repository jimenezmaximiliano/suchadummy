<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content\Category;

use Jimenezmaximiliano\Suchadummy\Containment\SuchadummyContainer;
use Jimenezmaximiliano\Suchadummy\Content\AbstractContentFactory;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\Metadata;
use Tightenco\Collect\Support\Collection;

class CategoryFactory extends AbstractContentFactory
{
    /** @var Category */
    protected $entity;

    public function make(SuchadummyContainer $container): Category
    {
        $this->container = $container;
        $this->rejectMissingMetadata(new Collection([
            Metadata::ID,
            Metadata::CONTENT_TYPE,
            Metadata::TITLE,
        ]));
        $title = $this->container->getMetadata()->get(Metadata::TITLE);
        $this->entity = new Category($this->getId(), $title);
        $this->setString(Metadata::EXCERPT);
        $this->setString(Metadata::SLUG);
        $this->setString(Metadata::AUTHOR);
        $this->setDate();
        $this->setCustomFields();
        $this->entity->setContent($container->getContent());

        return $this->entity;
    }
}
