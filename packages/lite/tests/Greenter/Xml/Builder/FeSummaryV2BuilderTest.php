<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 04/10/2017
 * Time: 12:44 PM
 */

namespace Tests\Greenter\Xml\Builder;
use Greenter\Model\Sale\Document;
use Greenter\Model\Summary\SummaryDetailV2;
use Greenter\Model\Summary\SummaryV2;

/**
 * Class FeSummaryV2BuilderTest
 * @package Tests\Greenter\Xml\Builder
 */
class FeSummaryV2BuilderTest extends \PHPUnit_Framework_TestCase
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
        $det = $summary->getDetails()[0];
        $det->setTipoDoc('222');
        $det->setClienteTipo('');

        $validator = $this->getValidator();
        $errors = $validator->validate($summary);

        $this->assertEquals(2, count($errors));
    }

    public function testCreateXmlSummary()
    {
        $summary = $this->getSummary();

        $xml = $this->build($summary);

        $this->assertNotEmpty($xml);
    }

    /**
     * @expectedException \Greenter\Xml\Exception\ValidationException
     */
    public function testXmlSummaryException()
    {
        $summary = $this->getSummary();
        $summary->setFecResumen(null);

        $this->build($summary);
    }

    public function testSummaryFilename()
    {
        $summary = $this->getSummary();
        $filename = $summary->getName();

        $this->assertEquals($this->getFilename($summary), $filename);
    }

    private function getFileName(SummaryV2 $summary)
    {
        $parts = [
            $summary->getCompany()->getRuc(),
            'RC',
            $summary->getFecResumen()->format('Ymd'),
            $summary->getCorrelativo(),
        ];

        return join('-', $parts);
    }

    private function getSummary()
    {
        $detiail1 = new SummaryDetailV2();
        $detiail1->setTipoDoc('03')
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
            ->setMtoDescuentos(5)
            ->setMtoIGV(3.6);

        $detiail2 = new SummaryDetailV2();
        $detiail2->setTipoDoc('07')
            ->setSerieNro('B001-22')
            ->setClienteTipo('1')
            ->setClienteNro('55667733')
            ->setEstado('1')
            ->setTotal(200)
            ->setMtoOperGravadas(40)
            ->setMtoOperExoneradas(30)
            ->setMtoOperInafectas(120)
            ->setMtoIGV(7.2)
            ->setMtoISC(2.8);

        $sum = new SummaryV2();
        $sum->setFecGeneracion(new \DateTime())
            ->setFecResumen(new \DateTime())
            ->setCompany($this->getCompany())
            ->setCorrelativo('001')
            ->setDetails([$detiail1, $detiail2]);

        return $sum;
    }
}