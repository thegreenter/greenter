<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 26/07/2017
 * Time: 23:50
 */

namespace Tests\Greenter;
use Greenter\FeFactory;
use Greenter\FeFactoryInterface;

/**
 * Class FeFactoryTest
 * @package Tests\Greenter
 */
class FeFactoryTest extends \PHPUnit_Framework_TestCase
{
    use FeFactoryTrait;

    /**
     * @var FeFactoryInterface
     */
    private $factory;

    public function setUp()
    {
        $factory = new FeFactory();
        $factory->setParameters([
            'auth' => [
              'user' => '20000000001MODDATOS',
              'pass' => 'moddatos',
            ],
            'xml' => [
                'cache' => sys_get_temp_dir(),
            ],
            'cert' => [
                'public' => file_get_contents(__DIR__.'/Resources/certificado.cer'),
                'private' => file_get_contents(__DIR__.'/Resources/certificado.key'),
            ]
        ]);
        $factory->setCompany($this->getCompany());
        $this->factory = $factory;
    }

    public function testInvoice()
    {
        $invoice = $this->getInvoice();
        $result = $this->factory->sendInvoice($invoice);

        $this->assertTrue($result->isSuccess());
        $this->assertNotNull($result->getCdrResponse());
        $this->assertEquals(
            'La Factura numero F001-123, ha sido aceptada',
            $result->getCdrResponse()->getDescription()
        );
    }

    public function testNota()
    {
        $creditNote = $this->getCreditNote();
        $result = $this->factory->sendNote($creditNote);

        $this->assertFalse($result->isSuccess());
//        $this->assertNotNull($result->getCdrResponse());
//        $this->assertEquals(
//            'La Factura numero F001-123, ha sido aceptada',
//            $result->getCdrResponse()->getDescription()
//        );
    }

    public function testResumen()
    {
        $resumen = $this->getSummary();
        $result = $this->factory->sendResumen($resumen);

        $this->assertFalse($result->isSuccess());
    }

    public function testBaja()
    {
        $baja = $this->getVoided();
        $result = $this->factory->sendBaja($baja);

        $this->assertNotNull($result);
//        $this->assertTrue($result->isSuccess());
//        $this->assertNotEmpty($result->getTicket());
//        $this->assertEquals(11, strlen($result->getTicket()));
    }

    public function testStatus()
    {
        $result = $this->factory->getStatus('1500523236696');

        $this->assertNotNull($result);
    }
}
