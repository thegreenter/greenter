<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 03:02 PM
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Model\Client\Client;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Perception\PerceptionDetail;
use Greenter\Model\Retention\Exchange;
use Greenter\Model\Retention\Payment;

/**
 * Class CePerceptionBuilderTest
 * @package tests\Greenter\Xml\Builder
 */
class CePerceptionBuilderTest extends \PHPUnit_Framework_TestCase
{
    use CeBuilderTrait;

    public function testValidatePerception()
    {
        $perception = $this->getPerception();
        $validator = $this->getValidator();
        $errors = $validator->validate($perception);

        $this->assertEquals(0,$errors->count());
    }

    public function testCreateXmlPerception()
    {
        $perception = $this->getPerception();

        $generator = $this->getGenerator();
        $xml = $generator->buildPerception($perception);

        $this->assertNotEmpty($xml);
        // file_put_contents('percep.xml', $xml);
    }

    /**
     * @expectedException \Greenter\Xml\Exception\ValidationException
     */
    public function testCreateXmlIPerceptionException()
    {
        $perception = $this->getPerception();
        $perception->setSerie('F2333')
            ->setRegimen('023');

        $generator = $this->getGenerator();
        $generator->buildPerception($perception);
    }

    public function testPerceptionFilename()
    {
        $ruc = $this->getCompany()->getRuc();
        $perception = $this->getPerception();
        $filename = $perception->getFileName($ruc);

        $this->assertEquals($this->getFilename($perception, $ruc), $filename);
    }

    private function getFileName(Perception $perception, $ruc)
    {
        $parts = [
            $ruc,
            '40',
            $perception->getSerie(),
            $perception->getCorrelativo(),
        ];

        return join('-', $parts);
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
            ->setFechaEmision(new \DateTime())
            ->setObservacion('NOTA PRUEBA />')
            ->setProveedor($client)
            ->setImpPercibido(10)
            ->setImpCobrado(210)
            ->setRegimen('01')
            ->setTasa(3);

        $detail = new PerceptionDetail();
        $detail->setTipoDoc('01')
            ->setNumDoc('F001-1')
            ->setFechaEmision(new \DateTime())
            ->setFechaPercepcion(new \DateTime())
            ->setMoneda('PEN')
            ->setImpTotal(200)
            ->setImpCobrar(200)
            ->setImpPercibido(5)
            ->setCobros($pays)
            ->setTipoCambio($cambio);

        $perception->setDetails([$detail]);

        return $perception;
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