<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content\Category;

use Tightenco\Collect\Support\Collection;
use Jimenezmaximiliano\Suchadummy\Content\AbstractContent;
use Jimenezmaximiliano\Suchadummy\Content\Publication\Publication;

class Category extends AbstractContent
{
    /** @var  Publication[] | Collection */
    private $publications;

    public function __construct(string $id, string $title)
    {
        parent::__construct($id);
        $this->title = $title;
        $this->publications = new Collection;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function addPublication(Publication $publication): void
    {
        $this->publications->put($publication->getId(), $publication);
    }

    /** Collection | Publication[] */
    public function getPublications(): Collection
    {
        return $this->publications;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function hasPublication($publicationId): bool
    {
        return $this->publications->has($publicationId);
    }
}
