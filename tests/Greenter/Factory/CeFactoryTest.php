<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/08/2017
 * Time: 20:16
 */

namespace Tests\Greenter\Factory;

/**
 * Class CeFactoryTest
 * @package Tests\Greenter\Factory
 */
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

    public function testPerceptionNotValidTasa()
    {
        $perception = $this->getPerception();
        $perception->setTasa(3);
        $result = $this->factory->sendPerception($perception);

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('2603', $result->getError()->getCode());
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

        $this->assertNotEmpty($this->factory->getLastXml());
        $this->assertTrue($result->isSuccess());
        $this->assertNotEmpty($result->getTicket());
        $this->assertEquals(13, strlen($result->getTicket()));

        return $result->getTicket();
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

    /**
     * @depends testReversion
     * @param string $ticket
     */
    public function testStatus($ticket)
    {
        $result = $this->factory->getStatus($ticket);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertNotNull($result->getCdrZip());
        $this->assertEquals('0', $result->getCode());
        $this->assertRegExp(
            '/El Comprobante numero RR-\d{8}-001 ha sido aceptado$/',
            $result->getCdrResponse()->getDescription());
    }

    public function testStatusInvalidTicket()
    {
        $result = $this->factory->getStatus('123456789456');

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('0127', $result->getError()->getCode());
        $this->assertEquals('El ticket no existe',
            $result->getError()->getMessage());
    }
}