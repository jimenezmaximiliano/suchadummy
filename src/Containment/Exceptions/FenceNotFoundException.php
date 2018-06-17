<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Containment\Exceptions;

use Exception;

class FenceNotFoundException extends Exception
{
    public function __construct(string $expectedFence)
    {
        parent::__construct("Couldn't find expected fence: '$expectedFence''");
    }
}
