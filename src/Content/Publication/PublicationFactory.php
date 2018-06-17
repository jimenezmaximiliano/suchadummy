<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content\Publication;

use Jimenezmaximiliano\Suchadummy\Containment\SuchadummyContainer;
use Jimenezmaximiliano\Suchadummy\Content\AbstractContentFactory;
use Jimenezmaximiliano\Suchadummy\Content\IdFactory;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\Metadata;
use Tightenco\Collect\Support\Collection;

class PublicationFactory extends AbstractContentFactory
{
    /** @var Publication */
    protected $entity;

    public function __construct(string $dateFormat, IdFactory $idFactory)
    {
        parent::__construct($dateFormat, $idFactory);
        $this->dateFormat = $dateFormat;
    }

    public function make(SuchadummyContainer $container): Publication
    {
        $this->container = $container;
        $this->rejectMissingMetadata(new Collection([
            Metadata::ID,
            Metadata::CONTENT_TYPE,
        ]));
        $this->entity = new Publication($this->getId(), $container->getContent());
        $this->setString(Metadata::TITLE);
        $this->setString(Metadata::AUTHOR);
        $this->setString(Metadata::EXCERPT);
        $this->setString(Metadata::SLUG);
        $this->setDate();
        $this->setCustomFields();

        return $this->entity;
    }
}
