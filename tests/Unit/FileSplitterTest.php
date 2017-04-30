<?php

declare(strict_types=1);

namespace Tests\Unit;

use Jimenezmaximiliano\Suchadummy\Containment\Parsers\FileSplitter;
use Jimenezmaximiliano\Suchadummy\Containment\SplitFile;
use Mockery;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\SplFileInfo;

final class FileSplitterTest extends TestCase
{
    private const FENCE = "\n=====\n";
    private const RAW_METADATA = '{ "id": "1" }';
    private const RAW_CONTENT = 'Hello';

    /** @var FileSplitter */
    private $fileSplitter;

    public function setUp(): void
    {
        $this->fileSplitter = new FileSplitter(self::FENCE);
    }

    public function tearDown(): void
    {
        $this->fileSplitter = null;
        Mockery::close();
    }

    public function testReturnsASplitedFile(): void
    {
        $completeFile = $this->getFileMock(self::RAW_METADATA . self::FENCE . self::RAW_CONTENT);
        $splitFile = $this->fileSplitter->split($completeFile);

        $this->assertInstanceOf(SplitFile::class, $splitFile);
    }

    public function testGettingContentFromACompleteFile(): void
    {
        $completeFile = $this->getFileMock(self::RAW_METADATA . self::FENCE . self::RAW_CONTENT);
        $splitFile = $this->fileSplitter->split($completeFile);

        $this->assertEquals(self::RAW_CONTENT, $splitFile->getRawContent());
    }

    public function testGettingMetadataFromACompleteFile(): void
    {
        $completeFile = $this->getFileMock(self::RAW_METADATA . self::FENCE . self::RAW_CONTENT);
        $splitFile = $this->fileSplitter->split($completeFile);

        $this->assertEquals(self::RAW_METADATA, $splitFile->getRawMetadata());
    }

    public function testGettingMetadataFromAFileWithoutContent(): void
    {
        $fileWithoutContent = $this->getFileMock(self::RAW_METADATA . self::FENCE);
        $splitFile = $this->fileSplitter->split($fileWithoutContent);

        $this->assertEquals(self::RAW_METADATA, $splitFile->getRawMetadata());
    }

    private function getFileMock($content)
    {
        return Mockery::mock(SplFileInfo::class)
            ->shouldReceive('getContents')
            ->once()
            ->andReturn($content)
            ->getMock();
    }
}
