<?php

declare(strict_types=1);

namespace Tests\Unit;

use Jimenezmaximiliano\Suchadummy\Content\AbstractContent;
use Jimenezmaximiliano\Suchadummy\Content\Category\Category;
use Jimenezmaximiliano\Suchadummy\Content\Category\CategoryFactory;
use Jimenezmaximiliano\Suchadummy\Content\Exceptions\MetadataNotFound;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\Metadata;
use Mockery;

final class CategoryFactoryTest extends ContentEntityFactory
{
    /** @var CategoryFactory */
    private $categoryFactory;
    /** @var Category */
    protected $entity;

    public function setUp(): void
    {
        parent::setUp();
        $this->categoryFactory = new CategoryFactory(self::DATE_FORMAT, $this->idFactory);
        $this->entity = $this->categoryFactory->make($this->sadContainer);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->categoryFactory = null;

        Mockery::close();
    }

    public function testCreatingACategoryWithoutId(): void
    {
        $this->expectException(MetadataNotFound::class);

        $this->setMetadata(collect([
            Metadata::CONTENT_TYPE => AbstractContent::TYPE_CATEGORY,
            Metadata::TITLE => self::METADATA_TITLE,
        ]));
        $this->categoryFactory->make($this->sadContainer);
    }

    public function testCreatingACategoryWithoutTitle(): void
    {
        $this->expectException(MetadataNotFound::class);

        $this->setMetadata(collect([
            Metadata::ID => self::METADATA_ID,
            Metadata::CONTENT_TYPE => AbstractContent::TYPE_CATEGORY,
        ]));
        $this->categoryFactory->make($this->sadContainer);
    }

    public function testCreatingACategoryWithoutContentType(): void
    {
        $this->expectException(MetadataNotFound::class);

        $this->setMetadata(collect([
            Metadata::ID => self::METADATA_ID,
            Metadata::TITLE => self::METADATA_TITLE,
        ]));
        $this->categoryFactory->make($this->sadContainer);
    }
}
