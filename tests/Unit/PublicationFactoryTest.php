<?php

declare(strict_types=1);

namespace Tests\Unit;

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
}
