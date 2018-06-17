<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content;

use Carbon\Carbon;
use Tightenco\Collect\Support\Collection;

abstract class AbstractContent
{
    public const TYPE_PUBLICATION = 'publication';
    public const TYPE_CATEGORY = 'category';

    /** @var string */
    protected $id;
    /** @var string  */
    protected $content;
    /** @var string */
    protected $title;
    /** @var string */
    protected $excerpt;
    /** @var string */
    protected $slug;
    /** @var Carbon */
    protected $date;
    /** @var Collection */
    protected $customFields;
    /** @var string */
    protected $author;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->customFields = new Collection;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getExcerpt(): ?string
    {
        return $this->excerpt;
    }

    public function getDate(): ?Carbon
    {
        return $this->date;
    }

    public function getCustomField(string $key): ?string
    {
        return $this->customFields->get($key);
    }

    public function setCustomField(string $key, string $value): void
    {
        $this->customFields->put($key, $value);
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function setExcerpt(string $excerpt): void
    {
        $this->excerpt = $excerpt;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function setDate(Carbon $date): void
    {
        $this->date = $date;
    }
}
