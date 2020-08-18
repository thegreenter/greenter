<?php

declare(strict_types=1);

namespace Greenter\Validator\Xml;

use DOMDocument;
use Greenter\Validator\Entity\CpeError;

interface ValidatorInterface
{
    /**
     * @param string $filename
     * @param DOMDocument $document
     *
     * @return CpeError[]
     */
    public function validate(string $filename, DOMDocument $document): array;
}
