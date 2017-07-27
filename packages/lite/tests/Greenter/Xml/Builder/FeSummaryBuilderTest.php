<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 19/07/2017
 * Time: 10:55 AM
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Model\Summary\Summary;
use Greenter\Model\Summary\SummaryDetail;

/**
 * Class FeSummaryBuilderTest
 * @package tests\Greenter\Xml\Builder
 */
class FeSummaryBuilderTest extends \PHPUnit_Framework_TestCase
{
    use FeBuilderTrait;

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
        $summary->setFecResumen(null);

        $validator = $this->getValidator();
        $errors = $validator->validate($summary);

        $this->assertEquals(1, count($errors));
    }

    public function testCreateXmlSummary()
    {
        $summary = $this->getSummary();

        $generator = $this->getGenerator();
        $xml = $generator->buildSummary($summary);

        $this->assertNotEmpty($xml);
    }


    /**
     * @expectedException \Greenter\Xml\Exception\ValidationException
     */
    public function testXmlSummaryException()
    {
        $summary = $this->getSummary();
        $summary->setFecResumen(null);

        $generator = $this->getGenerator();
        $generator->buildSummary($summary);
    }

    private function getSummary()
    {
        $detiail1 = new SummaryDetail();
        $detiail1->setTipoDoc('03')
            ->setSerie('B001')
            ->setDocInicio('1')
            ->setDocFin('4')
            ->setTotal(100)
            ->setMtoOperGravadas(20.555)
            ->setMtoOperInafectas(24.4)
            ->setMtoOperExoneradas(50)
            ->setMtoIGV(3.6);

        $detiail2 = new SummaryDetail();
        $detiail2->setTipoDoc('07')
            ->setSerie('BB01')
            ->setDocInicio('4')
            ->setDocFin('8')
            ->setTotal(200)
            ->setMtoOperGravadas(40)
            ->setMtoOperExoneradas(30)
            ->setMtoOperInafectas(120)
            ->setMtoIGV(7.2)
            ->setMtoISC(2.8);

        $sum = new Summary();
        $sum->setFecGeneracion(new \DateTime())
            ->setFecResumen(new \DateTime())
            ->setCorrelativo('001')
            ->setDetails([$detiail1, $detiail2]);

        return $sum;
    }
}