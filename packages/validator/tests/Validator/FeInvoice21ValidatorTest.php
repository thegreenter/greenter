<?php

declare(strict_types=1);

namespace Tests\Greenter\Validator;

use DateTime;
use Greenter\Model\Client\Client;
use Greenter\Model\Sale\Detraction;
use Greenter\Model\Sale\Document;
use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\FormaPagos\FormaPagoCredito;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\Prepayment;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\SalePerception;
use PHPUnit\Framework\TestCase;

class FeInvoice21ValidatorTest extends TestCase
{
    use Validator21Trait;

    /**
     * @dataProvider dataDocs
     * @param Invoice $invoice
     */
    public function testValidateInvoice(Invoice $invoice)
    {
        $validator = $this->getValidator();

        $errors = $validator->validate($invoice);

        $this->assertEquals(0, $errors->count());
    }

    public function testValidateNotValidInvoice()
    {
        $invoice = $this->getInvoice();
        $invoice->setTotalImpuestos(null);
        $invoice->getPerception()->setPorcentaje(null);
        $invoice->setTipoOperacion('');
        $invoice->setValorVenta(null);
        $invoice->setFormaPago(null);

        $validator = $this->getValidator();
        $errors = $validator->validate($invoice);

        $this->assertEquals(5, $errors->count());
    }

    private function getInvoice()
    {
        $invoice = new Invoice();
        $invoice
            ->setTipoOperacion('0101')
            ->setSumOtrosDescuentos(23)
            ->setFecVencimiento(new DateTime())
            ->setPerception(
                (new SalePerception())
                ->setCodReg('01')
                ->setPorcentaje(3)
                ->setMto(2)
                ->setMtoBase(3)
                ->setMtoTotal(4)
            )->setCompra('001-12112')
            ->setDetraccion(
                (new Detraction())
                ->setMount(2228.3)
                ->setPercent(9)
                ->setCodBienDetraccion('00')
                ->setCodMedioPago('01')
                ->setCtaBanco('2222-2222')
            )->setAnticipos([(new Prepayment())
                ->setTotal(100)
                ->setTipoDocRel('02')
                ->setNroDocRel('F001-21')
            ])->setTotalAnticipos(300)
            ->setRelDocs([(new Document())
                ->setTipoDoc('01')
                ->setNroDoc('F001-123')
            ])
            ->setGuias([(new Document())
                ->setTipoDoc('09')
                ->setNroDoc('T001-1')
            ])
            ->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('123')
            ->setFechaEmision(new DateTime())
            ->setFormaPago(new FormaPagoContado())
            ->setTipoMoneda('PEN')
            ->setClient(
                (new Client())
                ->setTipoDoc('6')
                ->setNumDoc('20000000001')
                ->setRznSocial('EMPRESA 1')
            )->setMtoOperGravadas(200)
            ->setMtoIGV(36)
            ->setMtoBaseIsc(100)
            ->setMtoISC(2)
            ->setTotalImpuestos(38)
            ->setSumOtrosCargos(12)
            ->setMtoOtrosTributos(1)
            ->setValorVenta(230)
            ->setMtoImpVenta(236)
            ->setCompany($this->getCompany())
            ->setDetails([(new SaleDetail())
                ->setCodProducto('C023')
                ->setCodProdSunat('P001')
                ->setUnidad('NIU')
                ->setCantidad(2)
                ->setDescripcion('PROD 2')
                ->setMtoBaseIgv(100)
                ->setPorcentajeIgv(18)
                ->setIgv(18)
                ->setMtoBaseIgv(50)
                ->setPorcentajeIsc(6.00)
                ->setIsc(3)
                ->setTipSisIsc('3')
                ->setMtoValorGratuito(12)
                ->setTipAfeIgv('10')
                ->setTotalImpuestos(21)
                ->setMtoValorVenta(100)
                ->setMtoValorUnitario(50)
                ->setMtoPrecioUnitario(56)
            ])->setLegends([
                (new Legend())
                    ->setCode('1000')
                    ->setValue('SON N SOLES')
            ]);

        return $invoice;
    }

    private function getInvoicePagoCredito()
    {
        $invoiceBase = $this->getInvoice();

        return $invoiceBase->setFormaPago(new FormaPagoCredito(20));
    }

    public function dataDocs()
    {
        return [
          [$this->getInvoice()],
          [$this->getInvoicePagoCredito()],
        ];
    }
}
