<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content\Metadata;

interface Metadata
{
    public const ID = 'id';
    public const TITLE = 'title';
    public const AUTHOR = 'author';
    public const EXCERPT = 'excerpt';
    public const SLUG = 'slug';
    public const DATE = 'date';
    public const CONTENT_TYPE = 'contentType';
    public const CUSTOM_FIELDS = 'customFields';
    public const CATEGORIES = 'categories';
}
