<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content\Metadata;

use Jimenezmaximiliano\Suchadummy\Containment\SuchadummyContainer;
use Jimenezmaximiliano\Suchadummy\Content\IdFactory;

class MetadataIdFactory implements IdFactory
{
    public function make(SuchadummyContainer $container): string
    {
        return (string) $container->getMetadata()->get(Metadata::ID);
    }
}
