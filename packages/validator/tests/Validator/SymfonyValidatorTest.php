<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/10/2017
 * Time: 12:50 PM
 */

declare(strict_types=1);

namespace Tests\Greenter\Validator;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Sale\Detraction;
use Greenter\Model\Sale\Document;
use Greenter\Model\Sale\EmbededDespatch;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\Prepayment;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\SalePerception;
use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\VoidedDetail;
use Greenter\Validator\SymfonyValidator;
use PHPUnit\Framework\TestCase;

/**
 * Class SymfonyValidatorTest
 * @package Tests\Greenter\Validator
 */
class SymfonyValidatorTest extends TestCase
{
    public function testInvoiceValidate()
    {
        $validator = new SymfonyValidator();
        $errors = $validator->validate($this->getInvoice());

        $this->assertEquals(0, count($errors));
    }

    public function testNotValidReversion()
    {
        $reversion = $this->getReversion();
        $reversion->setCorrelativo('123421');
        $validator = new SymfonyValidator();
        $errors = $validator->validate($reversion);

        $this->assertEquals(1, count($errors));
    }

    private function getInvoice()
    {
        $invoice = new Invoice();
        $invoice
            ->setMtoOperGratuitas(12)
            ->setSumDsctoGlobal(12)
            ->setMtoDescuentos(23)
            ->setTipoOperacion('2')
            ->setPerception((new SalePerception())
                ->setCodReg('01')
                ->setMto(2)
                ->setMtoBase(3)
                ->setMtoTotal(4)
            )->setCompra('001-12112')
            ->setDetraccion((new Detraction())
                ->setMount(2228.3)
                ->setPercent(9)
                ->setValueRef(2000)
            )->setGuiaEmbebida((new EmbededDespatch())
                ->setLlegada(new Direction('070101', 'AV. REPUBLICA DE ARGENTINA N? 2976 URB.'))
                ->setPartida(new Direction('070101', 'AV OSCAR R BENAVIDES No 5915  PE'))
                ->setTransportista((new Client())
                    ->setTipoDoc('6')
                    ->setNumDoc('20100006376')
                    ->setRznSocial('TRANS SAC')
                )->setNroLicencia('1111111111')
                ->setTranspPlaca('B9Y-778')
                ->setTranspCodeAuth('112121')
                ->setTranspMarca('Scania')
                ->setModTraslado('01')
                ->setUndPesoBruto('KGM')
                ->setPesoBruto(2020.23)
            )->setAnticipos([(new Prepayment())
                ->setTotal(100)
                ->setTipoDocRel('02')
                ->setNroDocRel('F001-21'),
                (new Prepayment())->setTotal(200)
                    ->setTipoDocRel('02')
                    ->setNroDocRel('F001-23')
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
            ->setFechaEmision(new \DateTime())
            ->setTipoMoneda('PEN')
            ->setClient((new Client())
                ->setTipoDoc('6')
                ->setNumDoc('20000000001')
                ->setRznSocial('EMPRESA 1')
            )->setMtoOperGravadas(200)
            ->setMtoOperExoneradas(0)
            ->setMtoOperInafectas(0)
            ->setMtoIGV(36)
            ->setMtoISC(2)
            ->setSumOtrosCargos(12)
            ->setMtoOtrosTributos(1)
            ->setMtoImpVenta(236)
            ->setCompany($this->getCompany())
            ->setDetails([(new SaleDetail())
                ->setCodProducto('C023')
                ->setUnidad('NIU')
                ->setCantidad(2)
                ->setDescripcion('PROD 2')
                ->setIgv(18)
                ->setIsc(3)
                ->setTipSisIsc('3')
                ->setMtoValorGratuito(12)
                ->setTipAfeIgv('10')
                ->setMtoValorVenta(100)
                ->setMtoValorUnitario(50)
                ->setMtoPrecioUnitario(56)
                , (new SaleDetail())
                    ->setCodProducto('C02')
                    ->setUnidad('NIU')
                    ->setCantidad(2)
                    ->setDescripcion('PROD 2')
                    ->setIgv(18)
                    ->setDescuento(1)
                    ->setTipAfeIgv('10')
                    ->setMtoValorVenta(100)
                    ->setMtoValorUnitario(10)
                    ->setMtoValorGratuito(2)
                    ->setMtoPrecioUnitario(0)
            ])->setLegends([
                (new Legend())
                    ->setCode('1000')
                    ->setValue('SON N SOLES')
            ]);

        return $invoice;
    }

    /**
     * @return Company
     */
    private function getCompany()
    {
        $company = new Company();
        $address = new Address();
        $address->setUbigueo('150101')
            ->setDepartamento('LIMA')
            ->setProvincia('LIMA')
            ->setUrbanizacion('NINGUNA')
            ->setCodigoPais('PE')
            ->setDistrito('LIMA')
            ->setDireccion('AV LS');
        $company->setRuc('20000000001')
            ->setRazonSocial('EMPRESA SAC')
            ->setNombreComercial('EMPRESA')
            ->setAddress($address);

        return $company;
    }

    /**
     * @return Reversion
     */
    private function getReversion()
    {
        $detial1 = new VoidedDetail();
        $detial1->setTipoDoc('20')
            ->setSerie('R001')
            ->setCorrelativo('02132132')
            ->setDesMotivoBaja('ERROR DE SISTEMA');

        $detial2 = new VoidedDetail();
        $detial2->setTipoDoc('20')
            ->setSerie('R001')
            ->setCorrelativo('123')
            ->setDesMotivoBaja('ERROR DE RUC');

        $reversion = new Reversion();
        $reversion->setCorrelativo('001')
            ->setFecGeneracion(new \DateTime())
            ->setFecComunicacion(new \DateTime())
            ->setCompany($this->getCompany())
            ->setDetails([$detial1, $detial2]);

        return $reversion;
    }
}