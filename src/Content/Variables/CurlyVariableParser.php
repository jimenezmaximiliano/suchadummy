<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content\Variables;

use Tightenco\Collect\Support\Collection;

class CurlyVariableParser implements VariableParser
{
    private const VARIABLE_WRAPPER_OPEN = '{{ ';
    private const VARIABLE_WRAPPER_CLOSE = ' }}';

    /** @var  Collection */
    private $variables;

    public function __construct()
    {
        $this->variables = new Collection;
    }

    public function parse(string $content): string
    {
        return str_replace(
            $this->variables->keys()->toArray(),
            $this->variables->values()->toArray(),
            $content
        );
    }

    public function setVariables(Collection $variables)
    {
        $variables->each(function ($value, $variableName) {
            $this->variables->put(
                self::VARIABLE_WRAPPER_OPEN . $variableName . self::VARIABLE_WRAPPER_CLOSE,
                $value
            );
        });
    }
}
