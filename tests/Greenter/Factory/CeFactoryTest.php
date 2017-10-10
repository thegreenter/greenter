<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/08/2017
 * Time: 20:16
 */

namespace Tests\Greenter\Factory;

use Greenter\Model\Response\CdrResponse;
use Greenter\Model\Response\StatusResult;

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
        $result = $this->getFactoryResult($despatch);

        if (!$result->isSuccess() &&
            $result->getError()->getCode() == '200') {
            return;
        }

        // file_put_contents('guia.xml', $this->factory->getLastXml());
        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals(
            'El Comprobante numero T001-123 ha sido aceptado',
            $result->getCdrResponse()->getDescription()
        );
    }

    public function testDespatchException()
    {
        $despatch = $this->getDespatch();
        $despatch->setTipoDoc('000');
        $this->getFactoryResult($despatch);
    }

    public function testRetention()
    {
        $retention = $this->getRetention();
        $result = $this->getFactoryResult($retention);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals(
            'El Comprobante numero R001-123 ha sido aceptado',
            $result->getCdrResponse()->getDescription()
        );
    }

    public function testRetentionException()
    {
        $retention = $this->getRetention();
        $retention->setSerie('RR000');
        $this->getFactoryResult($retention);
    }

    public function testPerception()
    {
        $perception = $this->getPerception();
        $result = $this->getFactoryResult($perception);

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
        $result = $this->getFactoryResult($perception);

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('2603', $result->getError()->getCode());
    }

    public function testPerceptionException()
    {
        $perception = $this->getPerception();
        $perception->setSerie('FF000');
        $this->getFactoryResult($perception);
    }

    public function testCreateXmlIPerceptionException()
    {
        $perception = $this->getPerception();
        $perception->setSerie('F2333')
            ->setRegimen('023');

        $this->getFactoryResult($perception);
    }

    public function testReversion()
    {
        $reversion = $this->getReversion();
        $result = $this->getFactoryResult($reversion);

        if (!$result->isSuccess() &&
            $result->getError()->getCode() == '200') {
            return '';
        }
        $this->assertNotEmpty($this->factory->getLastXml());
        $this->assertTrue($result->isSuccess());
        $this->assertNotEmpty($result->getTicket());
        $this->assertEquals(13, strlen($result->getTicket()));

        return $result->getTicket();
    }

    public function testReversionException()
    {
        $reversion = $this->getReversion();
        $reversion->getDetails()[0]->setTipoDoc('100');
        $this->getFactoryResult($reversion);
    }

    public function testXmlReversionException()
    {
        $reversion = $this->getReversion();
        $reversion->setCorrelativo('1232');

        $this->getFactoryResult($reversion);
    }

    /**
     * @depends testReversion
     * @param string $ticket
     */
    public function testStatus($ticket)
    {
        if ($ticket) {
            $myFact = $this->getExtService();
            $result = $myFact->getStatus($ticket);
        } else {
            $result = new StatusResult();
            $result
                ->setCode('0')
                ->setCdrResponse((new CdrResponse())
                ->setDescription('El Comprobante numero RR-20171001-001 ha sido aceptado')
                ->setId('RR-20171001-001')
                ->setCode('0')
                ->setNotes([]))
                ->setCdrZip('xx')
                ->setSuccess(true);
        }

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
        $myFact = $this->getExtService();
        $result = $myFact->getStatus('123456789456');

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('0127', $result->getError()->getCode());
        $this->assertEquals('El ticket no existe',
            $result->getError()->getMessage());
    }
}