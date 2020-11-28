<?php

declare(strict_types=1);

namespace Tests\Greenter\Validator\Factory;

use Greenter\Validator\Parser\ErrorResultParser;
use Greenter\Validator\Resolver\XmlTypeResolver;
use Greenter\Validator\Resolver\XslPathResolver;
use Greenter\Validator\Xml\CpeValidator;
use Greenter\Validator\Xml\XslValidator;

class CpeValidatorFactory
{
    public function create(string $xslBasePath): CpeValidator
    {
        $typeResolver = new XmlTypeResolver();
        $rulePathResolver = new XslPathResolver($xslBasePath);
        $xslValidator = new XslValidator(new ErrorResultParser());

        return new CpeValidator($typeResolver, $rulePathResolver, $xslValidator);
    }
}