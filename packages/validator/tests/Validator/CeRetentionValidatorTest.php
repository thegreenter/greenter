<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 01:42 PM
 */

declare(strict_types=1);

namespace Tests\Greenter\Validator;

use Greenter\Model\Client\Client;
use Greenter\Model\Retention\Exchange;
use Greenter\Model\Retention\Payment;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Retention\RetentionDetail;
use PHPUnit\Framework\TestCase;

class CeRetentionValidatorTest extends TestCase
{
    use ValidatorTrait;

    public function testValidateRetention()
    {
        $retention = $this->getRetention();
        $validator = $this->getValidator();
        $errors = $validator->validate($retention);

        $this->assertEquals(0,$errors->count());
    }

    /**
     * @return Retention
     */
    private function getRetention()
    {
        $client = new Client();
        $client->setTipoDoc('6')
            ->setNumDoc('20000000001')
            ->setRznSocial('EMPRESA 1');

        list($pays, $cambio) = $this->getExtras();
        $retention = new Retention();
        $retention
            ->setSerie('R001')
            ->setCorrelativo('123')
            ->setFechaEmision(new \DateTime())
            ->setCompany($this->getCompany())
            ->setProveedor($client)
            ->setObservacion('NOTA /><!-- HI -->')
            ->setImpRetenido(10)
            ->setImpPagado(210)
            ->setRegimen('01')
            ->setTasa(3);

        $detail = new RetentionDetail();
        $detail->setTipoDoc('01')
            ->setNumDoc('F001-1')
            ->setFechaEmision(new \DateTime())
            ->setFechaRetencion(new \DateTime())
            ->setMoneda('PEN')
            ->setImpTotal(200)
            ->setImpPagar(200)
            ->setImpRetenido(5)
            ->setPagos($pays)
            ->setTipoCambio($cambio);

        $retention->setDetails([$detail]);

        return $retention;
    }

    /**
     * @return array
     */
    private function getExtras()
    {
        $pay = new Payment();
        $pay->setMoneda('PEN')
            ->setFecha(new \DateTime())
            ->setImporte(100);

        $cambio = new Exchange();
        $cambio->setFecha(new \DateTime())
            ->setFactor(1)
            ->setMonedaObj('PEN')
            ->setMonedaRef('PEN');

        return [[$pay], $cambio];
    }
}