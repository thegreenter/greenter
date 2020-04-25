<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 04/10/2017
 * Time: 12:44 PM
 */

namespace Tests\Greenter\Validator;

use Greenter\Model\Sale\Document;
use Greenter\Model\Summary\SummaryDetail;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryPerception;
use PHPUnit\Framework\TestCase;

class FeSummaryValidatorTest extends TestCase
{
    use ValidatorTrait;

    public function testValidateSummary()
    {
        $summary = $this->getSummary();
        $validator = $this->getValidator();
        $errors = $validator->validate($summary);

        $this->assertEquals(0, count($errors));
    }

    public function testNotValidateSummary()
    {
        $summary = $this->getSummary();
        $det = $summary->getDetails()[0];
        $det->setTipoDoc('222');
        $det->setClienteTipo('33');

        $validator = $this->getValidator();
        $errors = $validator->validate($summary);

        $this->assertEquals(2, count($errors));
    }

    private function getSummary()
    {
        $detiail1 = new SummaryDetail();
        $detiail1->setTipoDoc('07')
            ->setSerieNro('B001-12')
            ->setClienteTipo('1')
            ->setClienteNro('44556677')
            ->setEstado('1')
            ->setDocReferencia((new Document())
                ->setTipoDoc('03')
                ->setNroDoc('B001-1'))
            ->setTotal(100)
            ->setMtoOperGravadas(20.555)
            ->setMtoOperInafectas(24.4)
            ->setMtoOperExoneradas(50)
            ->setMtoOtrosTributos(12.32)
            ->setMtoOtrosCargos(5)
            ->setMtoIGV(3.6)
            ->setMtoISC(0);

        $detiail2 = new SummaryDetail();
        $detiail2->setTipoDoc('03')
            ->setSerieNro('B001-22')
            ->setClienteTipo('1')
            ->setClienteNro('22334455')
            ->setPercepcion((new SummaryPerception())
            ->setCodReg('01')
            ->setTasa(2.00)
            ->setMto(4)
            ->setMtoBase(200)
            ->setMtoTotal(204))
            ->setEstado('1')
            ->setTotal(800)
            ->setMtoOperGravadas(40)
            ->setMtoOperExoneradas(30)
            ->setMtoOperInafectas(120)
            ->setMtoIGV(0)
            ->setMtoISC(2.8);

        $sum = new Summary();
        $sum->setFecGeneracion(new \DateTime())
            ->setFecResumen(new \DateTime())
            ->setCompany($this->getCompany())
            ->setCorrelativo('001')
            ->setDetails([$detiail1, $detiail2]);

        return $sum;
    }
}