<?php

declare(strict_types=1);

namespace Tests\Unit;

use Carbon\Carbon;
use Jimenezmaximiliano\Suchadummy\Containment\SuchadummyContainer;
use Jimenezmaximiliano\Suchadummy\Content\AbstractContent;
use Jimenezmaximiliano\Suchadummy\Content\IdFactory;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\Metadata;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tightenco\Collect\Support\Collection;

abstract class ContentEntityFactory extends TestCase
{
    public const DATE_FORMAT = 'Y-m-d';
    public const METADATA_ID = '1';
    public const METADATA_TITLE = 'A test';
    public const METADATA_SLUG = 'a-test';
    public const CONTENT = 'Test content';
    public const EXCERPT = 'Test excerpt';
    public const AUTHOR = 'Test author';
    public const DATE = '1984-01-01';
    public const CUSTOM_FIELD_KEY = 'custom key';
    public const CUSTOM_FIELD_VALUE = 'custom value';

    /** @var IdFactory */
    protected $idFactory;
    /** @var SuchadummyContainer */
    protected $sadContainer;
    protected $entity;

    public function setUp(): void
    {
        $this->idFactory = Mockery::mock(IdFactory::class)
            ->shouldReceive('make')
            ->once()
            ->andReturn(self::METADATA_ID)
            ->getMock();

        $this->setSadContainer($this->getCompleteMetadata());
    }

    protected function setMetadata(Collection $metadata): void
    {
        $this->setSadContainer($metadata);
    }

    private function setSadContainer(Collection $metadata): void
    {
        $this->sadContainer = Mockery::mock(SuchadummyContainer::class)
            ->shouldReceive([
                'getMetadata' => $metadata,
                'getContent' => self::CONTENT,
            ])
            ->getMock();
    }

    private function getCompleteMetadata(): Collection
    {
        return new Collection([
            Metadata::CONTENT_TYPE => AbstractContent::TYPE_CATEGORY,
            Metadata::ID => self::METADATA_ID,
            Metadata::TITLE => self::METADATA_TITLE,
            Metadata::SLUG => self::METADATA_SLUG,
            Metadata::EXCERPT => self::EXCERPT,
            Metadata::AUTHOR => self::AUTHOR,
            Metadata::DATE => self::DATE,
            Metadata::CUSTOM_FIELDS => [
                self::CUSTOM_FIELD_KEY => self::CUSTOM_FIELD_VALUE,
            ],
        ]);
    }

    public function tearDown(): void
    {
        $this->idFactory = null;
        $this->sadContainer = null;
        $this->entity = null;
    }

    public function testGettingContentEntityId(): void
    {
        $this->assertEquals($this->entity->getId(), self::METADATA_ID);
    }

    public function testGettingContentEntityTitle(): void
    {
        $this->assertEquals($this->entity->getTitle(), self::METADATA_TITLE);
    }

    public function testGettingContentEntitySlug(): void
    {
        $this->assertEquals($this->entity->getSlug(), self::METADATA_SLUG);
    }

    public function testGettingContentEntityContent(): void
    {
        $this->assertEquals($this->entity->getContent(), self::CONTENT);
    }

    public function testGettingContentEntityExcerpt(): void
    {
        $this->assertEquals($this->entity->getExcerpt(), self::EXCERPT);
    }

    public function testGettingContentEntityAuthor(): void
    {
        $this->assertEquals($this->entity->getAuthor(), self::AUTHOR);
    }

    public function testGettingContentEntityDate(): void
    {
        $expectedDate = Carbon::parse(self::DATE)->format(self::DATE_FORMAT);

        $this->assertEquals(
            $this->entity->getDate()->format(self::DATE_FORMAT),
            $expectedDate
        );
    }

    public function testGettingCustomField(): void
    {
        $this->assertEquals(
            $this->entity->getCustomField(self::CUSTOM_FIELD_KEY),
            self::CUSTOM_FIELD_VALUE
        );
    }

    public function testAddingACustomField(): void
    {
        $this->entity->setCustomField('new', 'new value');
        $this->assertEquals(
            $this->entity->getCustomField('new'),
            'new value'
        );
    }
}
