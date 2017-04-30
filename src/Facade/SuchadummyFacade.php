<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Facade;

use Jimenezmaximiliano\Suchadummy\Facade\Builders\CmsBuilderDirector;
use Jimenezmaximiliano\Suchadummy\Facade\Builders\CmsBuilder;
use Jimenezmaximiliano\Suchadummy\Facade\Builders\DefaultBuilder;
use Tightenco\Collect\Support\Collection;

class SuchadummyFacade
{
    public static function buildCms(
        string $filesPath,
        array $variables = [],
        CmsBuilder $cmsBuilder = null
    ): Cms
    {
        $cmsBuilder = $cmsBuilder ?? new DefaultBuilder;

        $cmsBuilderDirector = new CmsBuilderDirector;

        return $cmsBuilderDirector->build(
            $filesPath,
            $cmsBuilder,
            new Collection($variables)
        );
    }
}
