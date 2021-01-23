<?php

declare(strict_types=1);

namespace Tests\Integration;

use Jimenezmaximiliano\Suchadummy\Containment\Parsers\FileParser;
use Jimenezmaximiliano\Suchadummy\Containment\Parsers\FileSplitter;
use Jimenezmaximiliano\Suchadummy\Containment\SuchadummyContainer;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\Metadata;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\Parsers\JsonMetadataParser;
use Jimenezmaximiliano\Suchadummy\Content\Parsers\CommonMarkAdapter;
use Jimenezmaximiliano\Suchadummy\Content\Variables\CurlyVariableParser;
use League\CommonMark\CommonMarkConverter;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\SplFileInfo;

class FileParsingTest extends TestCase
{
    private const FENCE = '========================';

    /** @var SuchadummyContainer */
    private $container;

    public function setUp(): void
    {
        $rawContent = '{ '
            . '"title": "Hello world!",'
            . '"contentType": "publication",'
            . '"id": "1"'
            . '}'

            . "\n" . self::FENCE . "\n"

            . "# Hello world!\n"
            . "A paragraph\n"
            . "\n"
            . 'basePath is {{ basePath }}' . "\n"
        ;

        $file = Mockery::mock(SplFileInfo::class)
            ->shouldReceive([
                'getContents' => $rawContent,
                'getPath' => '/tmp/file.md',
            ])
            ->getMock();

        $commonMark = new CommonMarkAdapter(new CommonMarkConverter);
        $fileParser = new FileParser(
            collect([
                $commonMark,
                new CurlyVariableParser,
            ]),
            new JsonMetadataParser,
            new FileSplitter(self::FENCE),
            collect([
                'basePath' => 'http://localhost',
            ])
        );

        $this->container = $fileParser->parseFile($file);
    }

    public function tearDown(): void
    {
        $this->container = null;
        Mockery::close();
    }

    public function testGettingMetadata(): void
    {
        $this->assertEquals(
            'Hello world!',
            $this->container->getMetadata()->get(Metadata::TITLE)
        );
        $this->assertEquals(
            '1',
            $this->container->getMetadata()->get(Metadata::ID)
        );
        $this->assertEquals(
            'publication',
            $this->container->getMetadata()->get(Metadata::CONTENT_TYPE)
        );
    }

    public function testAssertingContentType(): void
    {
        $this->assertTrue($this->container->isPublication());
        $this->assertFalse($this->container->isCategory());
    }

    public function testHTMLConversion(): void
    {
        $this->assertStringContainsString(
            '<h1>Hello world!</h1>',
            $this->container->getContent()
        );
        $this->assertStringContainsString(
            '<p>A paragraph</p>',
            $this->container->getContent()
        );
    }

    public function testVariableReplacement(): void
    {
        $this->assertStringContainsString(
            '<p>basePath is http://localhost</p>',
            $this->container->getContent()
        );
    }
}
