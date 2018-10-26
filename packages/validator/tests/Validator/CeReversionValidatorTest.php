<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/08/2017
 * Time: 20:19
 */

namespace Tests\Greenter\Validator;

use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\VoidedDetail;

class CeReversionValidatorTest extends \PHPUnit_Framework_TestCase
{
    use ValidatorTrait;

    public function testValidateReversion()
    {
        $reversion = $this->getReversion();
        $validator = $this->getValidator();
        $errors = $validator->validate($reversion);

        $this->assertEquals(0, count($errors));
    }

    public function testNotValidateReversion()
    {
        $reversion = $this->getReversion();
        $reversion->setCorrelativo('123234');
        $validator = $this->getValidator();
        $errors = $validator->validate($reversion);

        $this->assertEquals(1, count($errors));
    }

    private function getReversion()
    {
        $detial1 = new VoidedDetail();
        $detial1->setTipoDoc('20')
            ->setSerie('R001')
            ->setCorrelativo('02132132')
            ->setDesMotivoBaja('ERROR DE SISTEMA');

        $detial2 = new VoidedDetail();
        $detial2->setTipoDoc('20')
            ->setSerie('R001')
            ->setCorrelativo('123')
            ->setDesMotivoBaja('ERROR DE RUC');

        $reversion = new Reversion();
        $reversion->setCorrelativo('001')
            ->setFecGeneracion(new \DateTime())
            ->setFecComunicacion(new \DateTime())
            ->setCompany($this->getCompany())
            ->setDetails([$detial1, $detial2]);

        return $reversion;
    }
}