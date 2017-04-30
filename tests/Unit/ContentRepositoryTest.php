<?php

declare(strict_types=1);

namespace Tests\Unit;

use Jimenezmaximiliano\Suchadummy\Containment\SuchadummyContainer;
use Jimenezmaximiliano\Suchadummy\Containment\SuchadummyContainerRepository;
use Jimenezmaximiliano\Suchadummy\Content\Category\Category;
use Jimenezmaximiliano\Suchadummy\Content\Category\CategoryFactory;
use Jimenezmaximiliano\Suchadummy\Content\ContentRepository;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\Metadata;
use Jimenezmaximiliano\Suchadummy\Content\Publication\Publication;
use Jimenezmaximiliano\Suchadummy\Content\Publication\PublicationFactory;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tightenco\Collect\Support\Collection;

final class ContentRepositoryTest extends TestCase
{
    private const CATEGORY_ID = 'cat';
    private const PUBLICATION_ID = 'pub';

    /** @var ContentRepository */
    private $repository;

    public function tearDown(): void
    {
        Mockery::close();
    }

    public function setUp(): void
    {
        $publicationContainer = Mockery::mock(SuchadummyContainer::class)
            ->shouldReceive([
                'getMetadata' => new Collection([
                    Metadata::CATEGORIES => [self::CATEGORY_ID],
                ]),
            ])
            ->getMock();
        $categoryContainer = Mockery::mock(SuchadummyContainer::class)
            ->shouldReceive([
                'getMetadata' => new Collection([
                ]),
            ])
            ->zeroOrMoreTimes()
            ->getMock();

        $containerRepository = Mockery::mock(SuchadummyContainerRepository::class)
            ->shouldReceive([
                'getPublicationContainers' => new Collection([
                    $publicationContainer,
                ]),
                'getCategoryContainers' => new Collection([
                    $categoryContainer,
                ]),
            ])
            ->getMock();

        $publication = Mockery::mock(Publication::class)
            ->shouldReceive([
                'getId' => self::PUBLICATION_ID,
                'addCategory' => null,
            ])
            ->getMock();
        $publicationFactory = Mockery::mock(PublicationFactory::class)
            ->shouldReceive([
                'make' => $publication,
            ])
            ->getMock();

        $category = Mockery::mock(Category::class)
            ->shouldReceive([
                'getId' => 'cat',
                'addPublication' => null,
            ])
            ->atLeast()
            ->once()
            ->getMock();
        $categoryFactory = Mockery::mock(CategoryFactory::class)
            ->shouldReceive(['make' => $category])
            ->getMock();

        $this->repository = new ContentRepository(
            $containerRepository,
            $publicationFactory,
            $categoryFactory
        );
    }

    public function testGettingAPublication(): void
    {
        $this->assertEquals(
            $this->repository->getPublications()->first()->getId(),
            self::PUBLICATION_ID
        );
    }

    public function testGettingACategory(): void
    {
        $this->assertEquals(
            $this->repository->getCategories()->first()->getId(),
            self::CATEGORY_ID
        );
    }

}
