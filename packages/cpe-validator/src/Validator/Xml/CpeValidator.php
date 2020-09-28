<?php

declare(strict_types=1);

namespace Greenter\Validator\Xml;

use DOMDocument;
use Greenter\Validator\Entity\CpeError;
use Greenter\Validator\Entity\ErrorLevel;
use Greenter\Validator\Resolver\RuleResolverInterface;
use Greenter\Validator\Resolver\TypeResolverInterface;

class CpeValidator implements ValidatorInterface
{
    /**
     * @var TypeResolverInterface
     */
    private $typeResolver;

    /**
     * @var RuleResolverInterface
     */
    private $ruleResolver;

    /**
     * @var XslValidatorInterface
     */
    private $xslValidator;

    /**
     * CpeValidator constructor.
     * @param TypeResolverInterface $typeResolver
     * @param RuleResolverInterface $ruleResolver
     * @param XslValidatorInterface $xslValidator
     */
    public function __construct(TypeResolverInterface $typeResolver, RuleResolverInterface $ruleResolver, XslValidatorInterface $xslValidator)
    {
        $this->typeResolver = $typeResolver;
        $this->ruleResolver = $ruleResolver;
        $this->xslValidator = $xslValidator;
    }

    /**
     * @param string $filename
     * @param string $xml
     * @return CpeError[]
     */
    public function validateFromXml(string $filename, string $xml): array
    {
        $document = new DOMDocument();
        $document->loadXML($xml);

        return $this->validate($filename, $document);
    }

    /**
     * @param string $filename
     * @param DOMDocument $document
     * @return CpeError[]
     */
    public function validate(string $filename, DOMDocument $document): array
    {
        $type = $this->typeResolver->getType($document);

        if ($type === null) {
            return [
                (new CpeError())
                    ->setCode('0305')
                    ->setLevel(ErrorLevel::EXCEPTION)
            ];
        }

        $rulePath = $this->ruleResolver->getPath($type);
        if ($rulePath === null) {
            return [
                (new CpeError())
                    ->setCode('0305')
                    ->setLevel(ErrorLevel::EXCEPTION)
            ];
        }

        $xslDoc = new DOMDocument();
        $xslDoc->load($rulePath);

        $this->xslValidator->setXsl($xslDoc);

        return $this->xslValidator->validate($filename, $document);
    }
}
