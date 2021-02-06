<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 26/07/2017
 * Time: 23:50
 */

declare(strict_types=1);

namespace Tests\Greenter\Factory;

use Greenter\Ws\Services\SummarySender;
use Greenter\Xml\Builder\SummaryBuilder;
use Greenter\XMLSecLibs\Sunat\SignedXml;
/**
 * Class FeFactoryTest
 * @group integration
 */
class FeFactoryTest extends FeFactoryBase
{
    public function testInvoice()
    {
        $invoice = $this->getInvoice();
        $result = $this->getFactoryResult($invoice);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals(
            '0',
            $result->getCdrResponse()->getCode()
        );
        $this->assertCount(0, $result->getCdrResponse()->getNotes());
        $this->assertNotEmpty($result->getCdrZip());
    }

    public function testGetXmlSigned()
    {
        $invoice = $this->getInvoice();
        $builder = $this->getBuilder($invoice);
        $this->factory->setBuilder($builder);

        $signXml = $this->factory->getXmlSigned($invoice);

        $this->assertInstanceOf(SignedXml::class, $this->factory->getSigner());
        $this->assertNotEmpty($signXml);
    }

    public function testInvalidInvoice()
    {
        $invoice = $this->getInvoice();
        $invoice->setTipoMoneda('UHT');
        $result = $this->getFactoryResult($invoice);

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('3088', $result->getError()->getCode());
    }

    public function testInvoiceNotValidZipFileName()
    {
        $invoice = $this->getInvoice();
        $invoice->setSerie('X001');
        $result = $this->getFactoryResult($invoice);

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('0151', $result->getError()->getCode());
    }

    public function testInvoiceRechazado()
    {
        $invoice = $this->getInvoice();
        $invoice->getClient()->setTipoDoc('1');

        $result = $this->getFactoryResult($invoice);

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('2801', $result->getError()->getCode());
    }

    public function testNotaCredito()
    {
        $creditNote = $this->getCreditNote();
        $result = $this->getFactoryResult($creditNote);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals(
            '0',
            $result->getCdrResponse()->getCode()
        );
        $this->assertCount(0, $result->getCdrResponse()->getNotes());
    }

    public function testNotaDebito()
    {
        $debitNote = $this->getDebitNote();
        $result = $this->getFactoryResult($debitNote);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals(
            '0',
            $result->getCdrResponse()->getCode()
        );
        $this->assertCount(0, $result->getCdrResponse()->getNotes());
    }

    public function testResumen()
    {
        $resumen = $this->getSummary();
        $result = $this->getFactoryResult($resumen);
        $this->assertInstanceOf(SummarySender::class, $this->factory->getSender());
        $this->assertInstanceOf(SummaryBuilder::class, $this->factory->getBuilder());

        $this->assertTrue($result->isSuccess());
        $this->assertNotEmpty($result->getTicket());
        $this->assertEquals(13, strlen($result->getTicket()));

        return $result->getTicket();
    }

    public function testBaja()
    {
        $baja = $this->getVoided();
        $result = $this->getFactoryResult($baja);

        if (!$result->isSuccess()) {
            return '123456789234';
        }

        $this->assertTrue($result->isSuccess());
        $this->assertNotEmpty($result->getTicket());
        $this->assertEquals(13, strlen($result->getTicket()));

        return $result->getTicket();
    }

    /**
     * @depends testResumen
     * @param string $ticket
     */
    public function testStatusResumenV2($ticket)
    {
        $result = $this->getExtService()->getStatus($ticket);

        if ($result->getCode() !== '0') {
            $this->assertTrue(true);
            return;
        }

        if ($result->isSuccess()) {
            $this->assertNull($result->getError());
            $this->assertNotNull($result->getCdrResponse());
            $this->assertEquals('0', $result->getCdrResponse()->getCode());
            $this->assertCount(0, $result->getCdrResponse()->getNotes());
            return;
        }

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('200', $result->getError()->getCode());
    }

    /**
     * @depends testBaja
     * @param string $ticket
     */
    public function testStatus($ticket)
    {
        $result = $this->getExtService()->getStatus($ticket);

        if ($result->getCode() !== '0') {
            $this->assertTrue(true);
            return;
        }

        if ($result->isSuccess()) {
            $this->assertNull($result->getError());
            $this->assertNotNull($result->getCdrResponse());
            $this->assertEquals('0', $result->getCdrResponse()->getCode());
            $this->assertCount(0, $result->getCdrResponse()->getNotes());
            return;
        }

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('200', $result->getError()->getCode());
        $this->assertEmpty($result->getCode());
        $this->assertEmpty($result->getCdrZip());
        $this->assertEmpty($result->getCdrResponse());
    }
}
