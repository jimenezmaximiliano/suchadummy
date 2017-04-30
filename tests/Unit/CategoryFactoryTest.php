<?php

declare(strict_types=1);

namespace Tests\Unit;

use Jimenezmaximiliano\Suchadummy\Content\Category\Category;
use Jimenezmaximiliano\Suchadummy\Content\Category\CategoryFactory;
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
}
