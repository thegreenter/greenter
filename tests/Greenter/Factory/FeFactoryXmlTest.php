<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 30/07/2017
 * Time: 12:10
 */

namespace Tests\Greenter\Factory;

use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\BaseResult;
use Greenter\Validator\SymfonyValidator;
use Greenter\Services\SenderInterface;

/**
 * Class FeFactoryXmlTest
 * @package Tests\Greenter
 */
class FeFactoryXmlTest extends \PHPUnit_Framework_TestCase
{
    use FeFactoryTraitTest;

    public function testInvoiceXml()
    {
        $invoice = $this->getInvoice();
        $this->getFactoryForXml($invoice);

        $xml = $this->factory->getLastXml();
        $xpt = $this->getXpath($xml);

        $nodes = $xpt->query('//ds:Signature');
        $tipo = $xpt->query('//cbc:InvoiceTypeCode');

        $this->assertEquals(1, $nodes->length);
        $this->assertEquals(1, $tipo->length);
        $this->assertEquals($invoice->getTipoDoc(), $tipo->item(0)->nodeValue);
    }

    public function testCreditNoteXml()
    {
        $creditNote = $this->getCreditNote();
        $this->getFactoryForXml($creditNote);

        $xml = $this->factory->getLastXml();


        $xpt = $this->getXpath($xml);

        $nodes = $xpt->query('//ds:Signature');
        $tipo = $xpt->query('//cbc:ResponseCode');

        $this->assertEquals(1, $nodes->length);
        $this->assertEquals(1, $tipo->length);
        $this->assertEquals($creditNote->getCodMotivo(), $tipo->item(0)->nodeValue);
    }

    public function testDebitNoteXml()
    {
        $debitNote = $this->getDebitNote();
        $this->getFactoryForXml($debitNote);

        $xml = $this->factory->getLastXml();


        $xpt = $this->getXpath($xml);

        $nodes = $xpt->query('//ds:Signature');
        $tipo = $xpt->query('//cbc:ResponseCode');

        $this->assertEquals(1, $nodes->length);
        $this->assertEquals(1, $tipo->length);
        $this->assertEquals($debitNote->getCodMotivo(), $tipo->item(0)->nodeValue);
    }

    public function testResumenXml()
    {
        $resumen = $this->getSummary();
        $this->getFactoryForXml($resumen);

        $xml = $this->factory->getLastXml();


        $xpt = $this->getXpath($xml);

        $nodes = $xpt->query('//ds:Signature');
        $tipo = $xpt->query('//sac:SummaryDocumentsLine');

        $this->assertEquals(1, $nodes->length);
        $this->assertEquals(count($resumen->getDetails()), $tipo->length);
    }

    public function testBajaXml()
    {
        $baja = $this->getVoided();
        $this->getFactoryForXml($baja);

        $xml = $this->factory->getLastXml();


        $xpt = $this->getXpath($xml);

        $nodes = $xpt->query('//ds:Signature');
        $tipo = $xpt->query('//sac:VoidedDocumentsLine');

        $this->assertEquals(1, $nodes->length);
        $this->assertEquals(count($baja->getDetails()), $tipo->length);
    }
    /**
     * @param string $xml
     * @return \DOMXPath
     */
    private function getXpath($xml)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($xml);

        return new \DOMXPath($doc);
    }

    private function getFactoryForXml(DocumentInterface $document)
    {
        $sender = $this->getMockBuilder(SenderInterface::class)
                    ->getMock();
        $sender->method('send')
                ->will($this->returnValue((new BaseResult())
                    ->setSuccess(true)));

        /**@var $sender SenderInterface */
        $builder = new $this->builders[get_class($document)]();
        $factory = $this->factory
            ->setBuilder($builder)
            ->setSender($sender)
            ->setValidator(new SymfonyValidator());

        return $factory->send($document);
    }
}