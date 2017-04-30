<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content\Variables;

use Tightenco\Collect\Support\Collection;
use Jimenezmaximiliano\Suchadummy\Content\Parsers\ContentParser;

interface VariableParser extends ContentParser
{
    public function setVariables(Collection $variables);
}
