<?php

declare(strict_types=1);

namespace Tests\Unit;

use Jimenezmaximiliano\Suchadummy\Content\Variables\CurlyVariableParser;
use PHPUnit\Framework\TestCase;
use Tightenco\Collect\Support\Collection;

final class CurlyVariableParserTest extends TestCase
{
    private const CONTENT = 'My name is {{ name }}';

    /** @var CurlyVariableParser */
    private $parser;

    public function setUp(): void
    {
        $this->parser = new CurlyVariableParser;
    }

    public function tearDown(): void
    {
        $this->parser = null;
    }

    public function testGettingParsedContentWithOneVar(): void
    {
        $this->parser->setVariables(new Collection([
            'name' => 'John Doe',
        ]));
        $result = $this->parser->parse(self::CONTENT);

        $this->assertEquals($result, 'My name is John Doe');
    }

    public function testGettingParsedContentWithoutSettingVars(): void
    {
        $result = $this->parser->parse(self::CONTENT);

        $this->assertEquals($result, self::CONTENT);
    }
}
