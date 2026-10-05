<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 03:02 PM
 */

declare(strict_types=1);

namespace Tests\Greenter\Validator;

use DateTime;
use Greenter\Model\Client\Client;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Perception\PerceptionDetail;
use Greenter\Model\Retention\Exchange;
use Greenter\Model\Retention\Payment;
use PHPUnit\Framework\TestCase;

class CePerceptionValidatorTest extends TestCase
{
    use ValidatorTrait;

    public function testValidatePerception()
    {
        $perception = $this->getPerception();
        $validator = $this->getValidator();
        $errors = $validator->validate($perception);

        $this->assertEquals(0, $errors->count());
    }

    public function testValidatePerceptionWithIndExcepcional()
    {
        $perception = $this->getPerception();
        $perception->setIndExcepcional('01');
        $validator = $this->getValidator();
        $errors = $validator->validate($perception);

        $this->assertEquals(0, $errors->count());
    }

    public function testValidatePerceptionInvalidIndExcepcional()
    {
        $perception = $this->getPerception();
        $perception->setIndExcepcional('1');
        $validator = $this->getValidator();
        $errors = $validator->validate($perception);

        $this->assertEquals(1, $errors->count());
        $this->assertEquals('indExcepcional', $errors->get(0)->getPropertyPath());
    }

    public function testValidatePerceptionMultiplesCobrosPorDetalle()
    {
        $perception = $this->getPerception();
        $detail = $perception->getDetails()[0];
        $cobro = (new Payment())
            ->setNumero(2)
            ->setMoneda('PEN')
            ->setFecha(new DateTime())
            ->setImporte(100);
        $detail->setCobros(array_merge($detail->getCobros(), [$cobro]));

        $errors = $this->getValidator()->validate($perception);

        $this->assertEquals(1, $errors->count());
    }

    public function testValidatePerceptionNumeroCobroInvalido()
    {
        $perception = $this->getPerception();
        $perception->getDetails()[0]->getCobros()[0]->setNumero(0);

        $errors = $this->getValidator()->validate($perception);

        $this->assertEquals(1, $errors->count());
    }

    /**
     * @return Perception
     */
    private function getPerception()
    {
        $client = new Client();
        $client->setTipoDoc('6')
            ->setNumDoc('20000000001')
            ->setRznSocial('EMPRESA 1');

        list($pays, $cambio) = $this->getExtras();
        $perception = new Perception();
        $perception
            ->setSerie('P001')
            ->setCorrelativo('123')
            ->setFechaEmision(new DateTime())
            ->setObservacion('NOTA PRUEBA />')
            ->setCompany($this->getCompany())
            ->setProveedor($client)
            ->setImpPercibido(10)
            ->setImpCobrado(210)
            ->setRegimen('01')
            ->setTasa(3);

        $perception->setDetails([(new PerceptionDetail())
            ->setTipoDoc('01')
            ->setNumDoc('F001-1')
            ->setFechaEmision(new DateTime())
            ->setFechaPercepcion(new DateTime())
            ->setMoneda('PEN')
            ->setImpTotal(200)
            ->setImpCobrar(200)
            ->setImpPercibido(5)
            ->setCobros($pays)
            ->setTipoCambio($cambio)]);

        return $perception;
    }

    /**
     * @return array
     */
    private function getExtras()
    {
        $pay = new Payment();
        $pay->setNumero(1)
            ->setMoneda('PEN')
            ->setFecha(new DateTime())
            ->setImporte(100);

        $cambio = new Exchange();
        $cambio->setFecha(new DateTime())
            ->setFactor(1)
            ->setMonedaObj('PEN')
            ->setMonedaRef('PEN');

        return [[$pay], $cambio];
    }
}