<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Content;

use Carbon\Carbon;
use Jimenezmaximiliano\Suchadummy\Containment\SuchadummyContainer;
use Jimenezmaximiliano\Suchadummy\Content\Exceptions\MetadataNotFound;
use Jimenezmaximiliano\Suchadummy\Content\Metadata\Metadata;
use Tightenco\Collect\Support\Collection;

abstract class AbstractContentFactory
{
    /** @var mixed */
    protected $entity;
    /** @var IdFactory */
    protected $idFactory;
    /** @var SuchadummyContainer */
    protected $container;
    /** @var string */
    protected $dateFormat;

    public function __construct(string $dateFormat, IdFactory $idFactory)
    {
        $this->idFactory = $idFactory;
        $this->dateFormat = $dateFormat;
    }

    protected function getId(): string
    {
        return $this->idFactory->make($this->container);
    }

    protected function setString(string $property): void
    {
        if (!$this->container->getMetadata()->has($property)) {
            return;
        }

        $method = 'set' . ucfirst($property);
        $this->entity->$method($this->container->getMetadata()->get($property));
    }

    protected function setDate(): void
    {
        if (!$this->container->getMetadata()->has(Metadata::DATE)) {
            return;
        }

        $date = Carbon::createFromFormat(
            $this->dateFormat,
            $this->container->getMetadata()->get('date')
        );

        $this->entity->setDate($date);
    }

    protected function setCustomFields(): void
    {
        if (!$this->container->getMetadata()->has(Metadata::CUSTOM_FIELDS)) {
            return;
        }

        $customFields = $this->container->getMetadata()->get(Metadata::CUSTOM_FIELDS);
        /** @var AbstractContent $entity */
        $entity = $this->entity;

        foreach ($customFields as $customFieldKey => $customFieldValue) {
            $entity->setCustomField($customFieldKey, $customFieldValue);
        }
    }

    protected function rejectMissingMetadata(Collection $requiredMetadata): void
    {
        $requiredMetadata->each(function (string $metadataKey) {
            if ($this->container->getMetadata()->has($metadataKey)) {
                return;
            }

            throw new MetadataNotFound($metadataKey);
        });
    }
}
