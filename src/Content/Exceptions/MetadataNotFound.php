<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content\Exceptions;

use Exception;

class MetadataNotFound extends Exception
{
    public function __construct(string $metadata)
    {
        parent::__construct("Couldn't find $metadata in the metadata block");
    }
}
