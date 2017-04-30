<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Facade\Builders;

use Jimenezmaximiliano\Suchadummy\Facade\Cms;
use Tightenco\Collect\Support\Collection;

interface CmsBuilder
{
    public function setContentParsers(): void;
    public function setVariableParser(): void;
    public function setMetadataParser(): void;
    public function setContentFence(): void;
    public function setDateFormat(): void;
    public function setFilesPath(string $filesPath): void;
    /**
     * @param string[] | Collection $vars
     */
    public function setVars(Collection $vars): void;
    public function buildCms(): Cms;
}
