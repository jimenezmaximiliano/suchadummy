<?php

declare(strict_types=1);

namespace Tests\Unit;

use Jimenezmaximiliano\Suchadummy\Content\Category\Category;
use Jimenezmaximiliano\Suchadummy\Content\Publication\Publication;
use Mockery;
use PHPUnit\Framework\TestCase;

final class CategoryTest extends TestCase
{
    private const ID = '1';
    private const TITLE = 'cat';
    private const PUBLICATION_ID = 'pubId';

    /** @var Category */
    private $category;

    public function setUp(): void
    {
        $this->category = new Category(self::ID, self::TITLE);
    }

    public function tearDown(): void
    {
        $this->category = null;
        Mockery::close();
    }

    public function testAddingAPublication(): void
    {
        $publication = Mockery::mock(Publication::class)
            ->shouldReceive('getId')
            ->once()
            ->andReturn(self::PUBLICATION_ID)
            ->getMock();
        $this->category->addPublication($publication);
        $resultPublication = $this->category->getPublications()->get(self::PUBLICATION_ID);

        $this->assertEquals($resultPublication, $publication);
    }
}
