<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content\Parsers;

use League\CommonMark\CommonMarkConverter;

class CommonMarkAdapter implements ContentParser
{
    /** @var CommonMarkConverter */
    private $converter;

    public function __construct(CommonMarkConverter $converter)
    {
        $this->converter = $converter;
    }

    public function parse(string $content): string
    {
        return $this->converter->convertToHtml($content);
    }
}
