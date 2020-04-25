<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 19/07/2017
 * Time: 10:47 AM
 */

namespace Tests\Greenter\Validator;

use Greenter\Model\Voided\Voided;
use Greenter\Model\Voided\VoidedDetail;
use PHPUnit\Framework\TestCase;

class FeVoidedValidatorTest extends TestCase
{
    use ValidatorTrait;

    public function testValidateVoided()
    {
        $voided = $this->getVoided();
        $validator = $this->getValidator();
        $errors = $validator->validate($voided);

        $this->assertEquals(0, count($errors));
    }

    public function testNotValidateVoided()
    {
        $voided = $this->getVoided();
        $voided->setCorrelativo('123342');
        $validator = $this->getValidator();
        $errors = $validator->validate($voided);

        $this->assertEquals(1, count($errors));
    }

    private function getVoided()
    {
        $detial1 = new VoidedDetail();
        $detial1->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('02132132')
            ->setDesMotivoBaja('ERROR DE SISTEMA');

        $detial2 = new VoidedDetail();
        $detial2->setTipoDoc('07')
            ->setSerie('F001')
            ->setCorrelativo('123')
            ->setDesMotivoBaja('ERROR DE RUC');

        $voided = new Voided();
        $voided->setCorrelativo('001')
            ->setFecGeneracion(new \DateTime())
            ->setFecComunicacion(new \DateTime())
            ->setCompany($this->getCompany())
            ->setDetails([$detial1, $detial2]);

        return $voided;
    }
}