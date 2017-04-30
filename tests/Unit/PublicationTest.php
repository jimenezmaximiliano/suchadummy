<?php

declare(strict_types=1);

namespace Tests\Unit;

use Jimenezmaximiliano\Suchadummy\Content\Category\Category;
use Jimenezmaximiliano\Suchadummy\Content\Publication\Publication;
use Mockery;
use PHPUnit\Framework\TestCase;

final class PublicationTest extends TestCase
{
    private const ID = 'pub';
    private const CONTENT = 'Some content';

    /** @var Publication */
    private $publication;
    /** @var Category */
    private $category;

    public function setUp(): void
    {
        $this->publication = new Publication(self::ID, self::CONTENT);
        $this->category = Mockery::mock(Category::class)
            ->shouldReceive(['getId' => 'cat'])
            ->getMock();
    }

    public function tearDown(): void
    {
        $this->publication = null;
        Mockery::close();
    }

    public function testAddingACategory(): void
    {
        $this->publication->addCategory($this->category);
        $this->assertEquals($this->publication->getCategories()->first(), $this->category);
    }

    public function testPublicationHasACategory(): void
    {
        $this->publication->addCategory($this->category);

        $this->assertTrue($this->publication->hasCategory($this->category->getId()));
    }

    public function testPublicationHasNotACategory(): void
    {
        $this->assertFalse($this->publication->hasCategory($this->category->getId()));
    }
}
