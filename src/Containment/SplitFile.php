<?php

declare(strict_types=1);

namespace Jimenezmaximiliano\Suchadummy\Containment;

class SplitFile
{
    /** @var  string */
    private $rawContent;
    /** @var  string */
    private $rawMetadata;

    public function __construct($rawContent = null, $rawMetadata = null)
    {
        $this->rawContent = $rawContent;
        $this->rawMetadata = $rawMetadata;
    }

    public function getRawContent(): ?string
    {
        return $this->rawContent;
    }

    public function getRawMetadata(): ?string
    {
        return $this->rawMetadata;
    }
}
