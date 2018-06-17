<?php

declare(strict_types=1);

namespace Tests\Unit;

use Jimenezmaximiliano\Suchadummy\Content\AbstractContent;
use Jimenezmaximiliano\Suchadummy\Content\Exceptions\MetadataNotFound;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\Metadata;
use Jimenezmaximiliano\Suchadummy\Content\Publication\Publication;
use Jimenezmaximiliano\Suchadummy\Content\Publication\PublicationFactory;
use Mockery;

final class PublicationFactoryTest extends ContentEntityFactory
{
    /** @var PublicationFactory */
    private $publicationFactory;
    /** @var Publication */
    protected $entity;

    public function setUp(): void
    {
        parent::setUp();
        $this->publicationFactory = new PublicationFactory(self::DATE_FORMAT, $this->idFactory);
        $this->entity = $this->publicationFactory->make($this->sadContainer);
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->publicationFactory = null;

        Mockery::close();
    }

    public function testCreatingAPublicationWithoutId(): void
    {
        $this->expectException(MetadataNotFound::class);

        $this->setMetadata(collect([
            Metadata::CONTENT_TYPE => AbstractContent::TYPE_PUBLICATION,
        ]));
        $this->publicationFactory->make($this->sadContainer);
    }

    public function testCreatingAPublicationWithoutContentType(): void
    {
        $this->expectException(MetadataNotFound::class);

        $this->setMetadata(collect([
            Metadata::ID => self::METADATA_ID,
        ]));
        $this->publicationFactory->make($this->sadContainer);
    }
}
