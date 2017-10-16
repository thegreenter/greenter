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
class FeFactoryTest extends \PHPUnit_Framework_TestCase
{
    use FeFactoryTraitTest;

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

    /**
     * @expectedException \Greenter\Validator\ValidationException
     */
    public function testCreateXmlInvoiceException()
    {
        $invoice = $this->getInvoice();
        $invoice->setTipoDoc('333')
            ->setSerie('FF000');

        $this->getFactoryResult($invoice);
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

    /**
     * @expectedException \Greenter\Validator\ValidationException
     */
    public function testXmlCreditNoteException()
    {
        $note = $this->getCreditNote();
        $note->setCodMotivo('C00');

        $this->getFactoryResult($note);
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

    /**
     * @expectedException \Greenter\Validator\ValidationException
     */
    public function testInvoiceInvalid()
    {
        $invoice = $this->getInvoice();
        $invoice->setTipoDoc('000');
        $this->getFactoryResult($invoice);
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

    /**
     * @expectedException \Greenter\Validator\ValidationException
     */
    public function testCreditNoteException()
    {
        $creditNote = $this->getCreditNote();
        $creditNote->setCodMotivo('C00');
        $this->getFactoryResult($creditNote);
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

    /**
     * @expectedException \Greenter\Validator\ValidationException
     */
    public function testDebitNoteException()
    {
        $debitNote = $this->getDebitNote();
        $debitNote->setCodMotivo('C00');
        $this->getFactoryResult($debitNote);
    }


    public function testResumen()
    {
        $resumen = $this->getSummary();
        $result = $this->getFactoryResult($resumen);
        $this->assertInstanceOf(SummarySender::class, $this->factory->getSender());
        $this->assertInstanceOf(SummaryBuilder::class, $this->factory->getBuilder());

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('2072', $result->getError()->getCode());
        $this->assertEquals('CustomizationID - La versión del documento no es la correcta',
            $result->getError()->getMessage());
    }

    /**
     * @expectedException \Greenter\Validator\ValidationException
     */
    public function testXmlSummaryException()
    {
        $summary = $this->getSummary();
        $summary->setFecResumen(null);

        $this->getFactoryResult($summary);
    }

    public function testResumenV2()
    {
        $resumen = $this->getSummaryV2();
        $result = $this->getFactoryResult($resumen);
        $this->assertInstanceOf(SummarySender::class, $this->factory->getSender());
        $this->assertInstanceOf(SummaryV2Builder::class, $this->factory->getBuilder());

        $this->assertTrue($result->isSuccess());
        $this->assertNotEmpty($result->getTicket());
        $this->assertEquals(13, strlen($result->getTicket()));
    }

    /**
     * @expectedException \Greenter\Validator\ValidationException
     */
    public function testResumenException()
    {
        $resumen = $this->getSummary();
        $resumen->setCorrelativo('1234');
        $this->getFactoryResult($resumen);
    }

    /**
     * @expectedException \Greenter\Validator\ValidationException
     */
    public function testXmlSummaryV2Exception()
    {
        $summary = $this->getSummary();
        $summary->setFecResumen(null);

        $this->getFactoryResult($summary);
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
     * @expectedException \Greenter\Validator\ValidationException
     */
    public function testBajaException()
    {
        $baja = $this->getVoided();
        $baja->getDetails()[0]->setTipoDoc('100');
        $this->getFactoryResult($baja);
    }

    /**
     * @expectedException \Greenter\Validator\ValidationException
     */
    public function testXmlVoidedException()
    {
        $voided = $this->getVoided();
        $voided->setCorrelativo('1232');

        $this->getFactoryResult($voided);
    }


    /**
     * @depends testBaja
     * @param string $ticket
     */
    public function testStatus($ticket)
    {
        $result = $this->getExtService()->getStatus($ticket);

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('200', $result->getError()->getCode());
        $this->assertEmpty($result->getCode());
        $this->assertEmpty($result->getCdrZip());
        $this->assertEmpty($result->getCdrResponse());
    }
}
