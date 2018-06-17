<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content\Exceptions;

use Exception;

class CategoryNotFound extends Exception
{
    public function __construct(string $categoryId)
    {
        parent::__construct("Couldn't find category with id $categoryId");
    }
}
