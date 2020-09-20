<?php

declare(strict_types=1);

namespace Greenter\Validator\Xml;

use DOMDocument;

interface XslValidatorInterface extends ValidatorInterface
{
    public function setXsl(DOMDocument $xslDocument);
}