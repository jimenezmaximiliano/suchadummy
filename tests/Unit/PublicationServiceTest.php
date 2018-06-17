<?php

declare(strict_types=1);

namespace Tests\Unit;

use Jimenezmaximiliano\Suchadummy\Content\ContentRepository;
use Jimenezmaximiliano\Suchadummy\Content\Exceptions\CategoryNotFound;
use Jimenezmaximiliano\Suchadummy\Content\Publication\PublicationService;
use Mockery;
use PHPUnit\Framework\TestCase;
use Tightenco\Collect\Support\Collection;

final class PublicationServiceTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }

    public function testGettingPostsByANonExistentCategory(): void
    {
        $this->expectException(CategoryNotFound::class);

        $contentRepository = Mockery::mock(ContentRepository::class)
            ->shouldReceive([
                'getCategories' => new Collection,
            ])
            ->getMock();
        $publicationService = new PublicationService($contentRepository);
        $publicationService->getByCategoryId('fooCategory');
    }
}
