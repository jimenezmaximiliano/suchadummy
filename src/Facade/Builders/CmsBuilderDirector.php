<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Facade\Builders;

use Tightenco\Collect\Support\Collection;
use Jimenezmaximiliano\Suchadummy\Facade\Cms;

class CmsBuilderDirector
{
    public function build(
        string $filesPath,
        CmsBuilder $cmsBuilder,
        Collection $vars = null
    ): Cms
    {
        $cmsBuilder->setContentFence();
        $cmsBuilder->setDateFormat();
        $cmsBuilder->setFilesPath($filesPath);
        $cmsBuilder->setVars($vars);
        $cmsBuilder->setContentParsers();
        $cmsBuilder->setVariableParser();
        $cmsBuilder->setMetadataParser();

        return $cmsBuilder->buildCms();
    }
}
