<?php

declare(strict_types=1);

namespace Tests\Unit;

use Illuminate\Support\Collection;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\Parsers\JsonMetadataParser;
use PHPUnit\Framework\TestCase;

final class JsonMetadataParserTest extends TestCase
{
    private const RAW_METADATA = '{ "id": "1" }';
    private const EMPTY_RAW_METADATA = '';

    /** @var JsonMetadataParser */
    private $jsonMetadataParser;

    public function setUp(): void
    {
        $this->jsonMetadataParser = new JsonMetadataParser;
    }

    public function tearDown(): void
    {
        $this->jsonMetadataParser = null;
    }

    public function testNotEmptyMetadataIsACollection(): void
    {
        $parsedMetadata = $this->jsonMetadataParser
            ->parseMetadata(self::RAW_METADATA);

        $this->assertInstanceOf(Collection::class, $parsedMetadata);
    }

    public function testEmptyMetadataIsACollection(): void
    {
        $parsedMetadata = $this->jsonMetadataParser
            ->parseMetadata(self::EMPTY_RAW_METADATA);

        $this->assertInstanceOf(Collection::class, $parsedMetadata);
    }

    public function testGettingMetadataContent(): void
    {
        $parsedMetadata = $this->jsonMetadataParser
            ->parseMetadata(self::RAW_METADATA);

        $this->assertEquals('1', $parsedMetadata->get('id'));
    }
}
