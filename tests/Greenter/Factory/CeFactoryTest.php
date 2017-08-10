<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/08/2017
 * Time: 20:16
 */

namespace Tests\Greenter\Factory;


class CeFactoryTest extends \PHPUnit_Framework_TestCase
{
    use CeFactoryTraitTest;

    public function testDespatch()
    {
        $despatch = $this->getDespatch();
        $result = $this->factory->sendDispatch($despatch);

        // file_put_contents('guia.xml', $this->factory->getLastXml());
        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals(
            'El Comprobante numero T001-123 ha sido aceptado',
            $result->getCdrResponse()->getDescription()
        );
    }

    /**
     * @expectedException \Greenter\Xml\Exception\ValidationException
     */
    public function testDespatchException()
    {
        $despatch = $this->getDespatch();
        $despatch->setTipoDoc('000');
        $this->factory->sendDispatch($despatch);
    }

    public function testRetention()
    {
        $retention = $this->getRetention();
        $result = $this->factory->sendRetention($retention);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals(
            'El Comprobante numero R001-123 ha sido aceptado',
            $result->getCdrResponse()->getDescription()
        );
    }

    /**
     * @expectedException \Greenter\Xml\Exception\ValidationException
     */
    public function testRetentionException()
    {
        $retention = $this->getRetention();
        $retention->setSerie('RR000');
        $this->factory->sendRetention($retention);
    }

    public function testPerception()
    {
        $perception = $this->getPerception();
        $result = $this->factory->sendPerception($perception);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals(
            'El Comprobante numero P001-123 ha sido aceptado',
            $result->getCdrResponse()->getDescription()
        );
    }

    /**
     * @expectedException \Greenter\Xml\Exception\ValidationException
     */
    public function testPerceptionException()
    {
        $perception = $this->getPerception();
        $perception->setSerie('FF000');
        $this->factory->sendPerception($perception);
    }

    public function testReversion()
    {
        $reversion = $this->getReversion();
        $result = $this->factory->sendReversion($reversion);

        $this->assertTrue($result->isSuccess());
        $this->assertNotEmpty($result->getTicket());
        $this->assertEquals(13, strlen($result->getTicket()));
    }

    /**
     * @expectedException \Greenter\Xml\Exception\ValidationException
     */
    public function testReversionException()
    {
        $reversion = $this->getReversion();
        $reversion->getDetails()[0]->setTipoDoc('100');
        $this->factory->sendReversion($reversion);
    }

    public function testStatus()
    {
        $result = $this->factory->getStatus('1500523236696');

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('200', $result->getError()->getCode());
    }
}