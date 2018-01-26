<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 24/01/2018
 * Time: 10:14 AM
 */

namespace Tests\Greenter\Xml\Builder;
use Greenter\Ubl\SchemaValidator;
use Greenter\Ubl\SchemaValidatorInterface;

/**
 * Trait XsdValidatorTrait
 * @method assertTrue($state)
 */
trait XsdValidatorTrait
{

    public function assertSchema($xml, $version = '2.0')
    {
        $validator = $this->getValidator($version);

        $success = $validator->validate($xml);

        $this->assertTrue($success);
    }

    /**
     * @param string $version
     * @return SchemaValidatorInterface
     */
    private function getValidator($version = '2.0')
    {
        $validator = new SchemaValidator();
        $validator->setVersion($version);

        return $validator;
    }
}