<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 26/07/2017
 * Time: 23:50
 */

namespace Tests\Greenter\Factory;

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
        $result = $this->factory->sendInvoice($invoice);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals(
            'La Factura numero F001-123, ha sido aceptada',
            $result->getCdrResponse()->getDescription()
        );
    }

    public function testInvoiceNotValidZipFileName()
    {
        $invoice = $this->getInvoice();
        $invoice->setSerie('X001');
        $result = $this->factory->sendInvoice($invoice);

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('0151', $result->getError()->getCode());
    }

    /**
     * @expectedException \Greenter\Xml\Exception\ValidationException
     */
    public function testInvoiceInvalid()
    {
        $invoice = $this->getInvoice();
        $invoice->setTipoDoc('000');
        $this->factory->sendInvoice($invoice);
    }

    public function testNotaCredito()
    {
        $creditNote = $this->getCreditNote();
        $result = $this->factory->sendNote($creditNote);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals(
            'La Nota de Credito numero FF01-123, ha sido aceptada',
            $result->getCdrResponse()->getDescription()
        );
    }

    /**
     * @expectedException \Greenter\Xml\Exception\ValidationException
     */
    public function testCreditNoteException()
    {
        $creditNote = $this->getCreditNote();
        $creditNote->setCodMotivo('C00');
        $this->factory->sendNote($creditNote);
    }

    public function testNotaDebito()
    {
        $debitNote = $this->getDebitNote();
        $result = $this->factory->sendNote($debitNote);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals(
            'La Nota de Debito numero FF01-123, ha sido aceptada',
            $result->getCdrResponse()->getDescription()
        );
    }

    /**
     * @expectedException \Greenter\Xml\Exception\ValidationException
     */
    public function testDebitNoteException()
    {
        $debitNote = $this->getDebitNote();
        $debitNote->setCodMotivo('C00');
        $this->factory->sendNote($debitNote);
    }


    public function testResumen()
    {
        $resumen = $this->getSummary();
        $result = $this->factory->sendResumen($resumen);

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('2072', $result->getError()->getCode());
        $this->assertEquals('CustomizationID - La versión del documento no es la correcta',
            $result->getError()->getMessage());
    }

    /**
     * @expectedException \Greenter\Xml\Exception\ValidationException
     */
    public function testResumenException()
    {
        $resumen = $this->getSummary();
        $resumen->setCorrelativo('1234');
        $this->factory->sendResumen($resumen);
    }

    public function testBaja()
    {
        $baja = $this->getVoided();
        $result = $this->factory->sendBaja($baja);

        $this->assertTrue($result->isSuccess());
        $this->assertNotEmpty($result->getTicket());
        $this->assertEquals(13, strlen($result->getTicket()));

        return $result->getTicket();
    }

    /**
     * @expectedException \Greenter\Xml\Exception\ValidationException
     */
    public function testBajaException()
    {
        $baja = $this->getVoided();
        $baja->getDetails()[0]->setTipoDoc('100');
        $this->factory->sendBaja($baja);
    }

    /**
     * @depends testBaja
     * @param string $ticket
     */
    public function testStatus($ticket)
    {
        $result = $this->factory->getStatus($ticket);

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('200', $result->getError()->getCode());
    }
}
