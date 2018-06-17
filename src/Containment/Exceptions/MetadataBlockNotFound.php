<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Containment\Exceptions;

use Exception;

class MetadataBlockNotFound extends Exception
{
    public function __construct()
    {
        parent::__construct("Couldn't find metadata block");
    }
}
