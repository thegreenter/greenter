<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/10/2017
 * Time: 12:36 PM.
 */

namespace Greenter\Validator;

use Greenter\Model\DocumentInterface;
use Greenter\Validator\Metadata\CustomMetadataFactory;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class SymfonyValidator.
 */
class SymfonyValidator implements DocumentValidatorInterface
{
    private $validator;
    private $factory;

    /**
     * SymfonyValidator constructor.
     *
     * @param ErrorCodeProviderInterface|null $provider
     */
    public function __construct(ErrorCodeProviderInterface $provider = null)
    {
        $this->factory = new CustomMetadataFactory();
        $builder = Validation::createValidatorBuilder();

        if ($provider) {
            $builder->setTranslator($this->getTranslator($provider));
        }

        $this->validator = $builder
            ->setMetadataFactory($this->factory)
            ->getValidator();

    }

    /**
     * @param DocumentInterface $document
     *
     * @return ConstraintViolationListInterface
     */
    public function validate(DocumentInterface $document)
    {
        return $this->validator->validate($document);
    }

    /**
     * @return ValidatorInterface
     */
    public function getValidator()
    {
        return $this->validator;
    }

    /**
     * @return CustomMetadataFactory
     */
    public function getMetadatFactory()
    {
        return $this->factory;
    }

    private function getTranslator($errorProvider)
    {
        $translator = new MessageTranslator($errorProvider);
        $translator->addResource($this->getResources());

        return $translator;
    }

    private function getResources()
    {
        return [
            'G001' => 'El texto no cumple con el formato establecido',
        ];
    }
}
