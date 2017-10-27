<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 26/07/2017
 * Time: 23:50
 */

namespace Tests\Greenter\Factory;
use Greenter\Ws\Services\SummarySender;
use Greenter\Xml\Builder\SummaryBuilder;
use Greenter\Xml\Builder\SummaryV2Builder;

/**
 * Class FeFactoryTest
 * @package Tests\Greenter
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
            'La Factura numero F001-123, ha sido aceptada',
            $result->getCdrResponse()->getDescription()
        );
        $this->assertNotEmpty($result->getCdrZip());
    }

    public function testInvalidInvoice()
    {
        $invoice = $this->getInvoice();
        $invoice->setTipoMoneda('UHT');
        $result = $this->getFactoryResult($invoice);

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('0306', $result->getError()->getCode());
        $this->assertEquals('No se puede leer (parsear) el archivo XML', $result->getError()->getMessage());
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
        $invoice->getClient()->setTipoDoc('0');
        $result = $this->getFactoryResult($invoice);

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('2016', $result->getError()->getCode());
    }

    public function testNotaCredito()
    {
        $creditNote = $this->getCreditNote();
        $result = $this->getFactoryResult($creditNote);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals(
            'La Nota de Credito numero FF01-123, ha sido aceptada',
            $result->getCdrResponse()->getDescription()
        );
    }

    public function testNotaDebito()
    {
        $debitNote = $this->getDebitNote();
        $result = $this->getFactoryResult($debitNote);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals(
            'La Nota de Debito numero FF01-123, ha sido aceptada',
            $result->getCdrResponse()->getDescription()
        );
    }

    public function testResumen()
    {
        $resumen = $this->getSummary();
        $result = $this->getFactoryResult($resumen);
        $this->assertInstanceOf(SummarySender::class, $this->factory->getSender());
        $this->assertInstanceOf(SummaryBuilder::class, $this->factory->getBuilder());

        if (!$result->isSuccess()) {
            return;
        }

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('2072', $result->getError()->getCode());
        $this->assertEquals('CustomizationID - La versión del documento no es la correcta',
            $result->getError()->getMessage());
    }

    public function testResumenV2()
    {
        $resumen = $this->getSummaryV2();
        $result = $this->getFactoryResult($resumen);
        $this->assertInstanceOf(SummarySender::class, $this->factory->getSender());
        $this->assertInstanceOf(SummaryV2Builder::class, $this->factory->getBuilder());

        if (!$result->isSuccess()) {
            return;
        }

        $this->assertTrue($result->isSuccess());
        $this->assertNotEmpty($result->getTicket());
        $this->assertEquals(13, strlen($result->getTicket()));
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
     * @depends testBaja
     * @param string $ticket
     */
    public function testStatus($ticket)
    {
        $result = $this->getExtService()->getStatus($ticket);

        if ($result->getCode() !== '0') {
            return;
        }

        if ($result->isSuccess()) {
            $this->assertNull($result->getError());
            $this->assertNotNull($result->getCdrResponse());
            $this->assertEquals('0', $result->getCdrResponse()->getCode());
            $this->assertContains('aceptada', $result->getCdrResponse()->getDescription());
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
