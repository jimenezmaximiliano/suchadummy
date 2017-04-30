<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content;

use Jimenezmaximiliano\Suchadummy\Containment\SuchadummyContainer;

interface IdFactory
{
    public function make(SuchadummyContainer $container): string;
}
