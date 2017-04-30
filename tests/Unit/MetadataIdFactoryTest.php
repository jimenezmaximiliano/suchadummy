<?php

declare(strict_types=1);

namespace Tests\Unit;

use Jimenezmaximiliano\Suchadummy\Containment\SuchadummyContainer;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\Metadata;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\MetadataIdFactory;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tightenco\Collect\Support\Collection;

final class MetadataIdFactoryTest extends TestCase
{
    private const ID = 'some id';

    /** @var MetadataIdFactory */
    private $idFactory;

    public function setUp(): void
    {
        $this->idFactory = new MetadataIdFactory;
    }

    public function tearDown(): void
    {
        $this->idFactory = null;
        Mockery::close();
    }

    public function testGettingAnIdFromMetadata(): void
    {
        $container = Mockery::mock(SuchadummyContainer::class)
            ->shouldReceive([
                'getMetadata' => new Collection([
                    Metadata::ID => self::ID,
                ]),
            ])
            ->getMock();

        $this->assertEquals($this->idFactory->make($container), self::ID);
    }
}
