<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 19/07/2017
 * Time: 04:14 PM
 */

namespace Tests\Greenter\Validator;

use Greenter\Model\Client\Client;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\Note;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\SalePerception;
use PHPUnit\Framework\TestCase;

class FeNoteValidatorTest extends TestCase
{
    use ValidatorTrait;

    public function testValidateNote()
    {
        $note = $this->getCreditNote();
        $validator = $this->getValidator();
        $errors = $validator->validate($note);

        $this->assertEquals(0,$errors->count());
    }

    public function testNotValidateNote()
    {
        $note = $this->getCreditNote();
        $note->setCodMotivo('C00')
            ->setTipoDoc('212');
        $validator = $this->getValidator();
        $errors = $validator->validate($note);

        $this->assertEquals(2,$errors->count());
    }

    private function getCreditNote()
    {
        $client = new Client();
        $client->setTipoDoc('6')
            ->setNumDoc('20000000001')
            ->setRznSocial('EMPRESA 1');

        $perc = new SalePerception();
        $perc->setCodReg('01')
            ->setMto(2)
            ->setMtoBase(3)
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
            ->setFechaEmision(new \DateTime())
            ->setTipoMoneda('PEN')
            ->setClient($client)
            ->setMtoOperGravadas(200)
            ->setMtoOperExoneradas(0)
            ->setMtoOperInafectas(0)
            ->setMtoIGV(36)
            ->setMtoImpVenta(236)
            ->setCompany($this->getCompany());

        $detail1 = new SaleDetail();
        $detail1->setCodProducto('C023')
            ->setUnidad('NIU')
            ->setCantidad(2)
            ->setDescripcion('PROD 2')
            ->setIgv(18)
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(50)
            ->setMtoPrecioUnitario(56);

        $detail2 = new SaleDetail();
        $detail2->setCodProducto('C02')
            ->setUnidad('NIU')
            ->setCantidad(2)
            ->setDescripcion('PROD 2')
            ->setIgv(18)
            ->setTipAfeIgv('10')
            ->setMtoValorVenta(100)
            ->setMtoValorUnitario(50)
            ->setMtoPrecioUnitario(56);

        $legend = new Legend();
        $legend->setCode('1000')
            ->setValue('SON N SOLES');

        $note->setDetails([$detail1, $detail2])
            ->setLegends([$legend]);

        return $note;
    }
}