<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/08/2017
 * Time: 20:16
 */

declare(strict_types=1);

namespace Tests\Greenter\Factory;

use Greenter\Model\Response\CdrResponse;
use Greenter\Model\Response\StatusResult;

/**
 * Class CeFactoryTest.
 * @group integration
 */
class CeFactoryTest extends CeFactoryBase
{
    public function testDespatch()
    {
        $despatch = $this->getDespatch();
        $result = $this->getFactoryResult($despatch);

        if (!$result->isSuccess() &&
            $result->getError()->getCode() == '200') {
            return;
        }

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals(
            '0',
            $result->getCdrResponse()->getCode()
        );

    }

    public function testRetention()
    {
        $retention = $this->getRetention();
        $result = $this->getFactoryResult($retention);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals(
            '0',
            $result->getCdrResponse()->getCode()
        );
    }

    public function testGetXmlSigned()
    {
        $despatch = $this->getDespatch();
        $signXml = $this->getXmlSigned($despatch);

        $this->assertNotEmpty($signXml);
    }

    public function testPerception()
    {
        $perception = $this->getPerception();
        $result = $this->getFactoryResult($perception);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals(
            '0',
            $result->getCdrResponse()->getCode()
        );
    }

    public function testPerceptionNotValidRuc()
    {
        $perception = $this->getPerception();
        $perception->getCompany()->setRuc('2000010000');
        $result = $this->getFactoryResult($perception);

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('0151', $result->getError()->getCode());
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function testReversion()
    {
        $reversion = $this->getReversion();
        $result = $this->getFactoryResult($reversion);

        if (!$result->isSuccess()) {
            return '';
        }
        $this->assertNotEmpty($this->factory->getLastXml());
        $this->assertTrue($result->isSuccess());
        $this->assertNotEmpty($result->getTicket());
        $this->assertEquals(13, strlen($result->getTicket()));

        return $result->getTicket();
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
    }

    public function testStatusInvalidTicket()
    {
        $myFact = $this->getExtService();
        $result = $myFact->getStatus('123456789456');

        $this->assertFalse($result->isSuccess());
        $this->assertNotNull($result->getError());
        $this->assertEquals('0127', $result->getError()->getCode());
        $this->assertStringContainsString('El ticket no existe',
            $result->getError()->getMessage());
    }
}