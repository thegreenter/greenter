<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 19/07/2017
 * Time: 04:14 PM
 */

declare(strict_types=1);

namespace Tests\Greenter\Validator;

use DateTime;
use Greenter\Model\Client\Client;
use Greenter\Model\Sale\Cuota;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\Note;
use Greenter\Model\Sale\PaymentTerms;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\SalePerception;
use PHPUnit\Framework\TestCase;

class FeNote21ValidatorTest extends TestCase
{
    use Validator21Trait;

    /**
     * @dataProvider dataDocs
     * @param Note $note
     */
    public function testValidateNote(Note $note)
    {
        $validator = $this->getValidator();

        $errors = $validator->validate($note);

        $this->assertEquals(0, $errors->count());
    }

    public function testValidateNotValidNote()
    {
        $note = $this->getCreditNote();
        $note->setCodMotivo('');
        $note->setDesMotivo('');

        $validator = $this->getValidator();
        $errors = $validator->validate($note);

        $this->assertEquals(2, $errors->count());
    }

    private function getCreditNote(): Note
    {
        $client = new Client();
        $client->setTipoDoc('6')
            ->setNumDoc('20000000001')
            ->setRznSocial('EMPRESA 1');

        $perc = new SalePerception();
        $perc->setCodReg('01')
            ->setMto(2)
            ->setMtoBase(3)
            ->setPorcentaje(2)
            ->setMtoTotal(4);

        $note = new Note();
        $note
            ->setTipDocAfectado('01')
            ->setNumDocfectado('F001-111')
            ->setCodMotivo('01')
            ->setDesMotivo('ANULACION DE LA OPERACION')
            ->setMtoOperGratuitas(1)
            ->setPerception($perc)
            ->setTipoDoc('07')
            ->setSerie('FF01')
            ->setCorrelativo('123')
            ->setFechaEmision(new DateTime())
            ->setTipoMoneda('PEN')
            ->setClient($client)
            ->setMtoOperGravadas(200)
            ->setTotalImpuestos(18)
            ->setMtoIGV(36)
            ->setMtoImpVenta(236)
            ->setCompany($this->getCompany());

        $detail1 = new SaleDetail();
        $detail1->setCodProducto('C023')
            ->setUnidad('NIU')
            ->setCantidad(2)
            ->setDescripcion('PROD 2')
            ->setMtoBaseIgv(100)
            ->setPorcentajeIgv(18)
            ->setIgv(18)
            ->setTotalImpuestos(18)
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(50)
            ->setMtoPrecioUnitario(56);

        $legend = new Legend();
        $legend->setCode('1000')
            ->setValue('SON N SOLES');

        $note->setDetails([$detail1])
            ->setLegends([$legend]);

        return $note;
    }

    private function getCreditNotePagoCredito(): Note
    {
        $noteBase = $this->getCreditNote();

        return $noteBase
            ->setFormaPago(
                (new PaymentTerms())
                ->setTipo('Credito')
                ->setMonto(100)
            )
            ->setCuotas([
                (new Cuota())
                ->setMonto(100)
                ->setFechaPago(new DateTime('2021-02-17 00:00:00-05:00'))
            ]);
    }

    public function dataDocs()
    {
        return [
            [$this->getCreditNote()],
            [$this->getCreditNotePagoCredito()],
        ];
    }
}
