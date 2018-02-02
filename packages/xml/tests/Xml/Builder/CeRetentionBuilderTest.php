<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 01:42 PM
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Model\Retention\Retention;

/**
 * Class CeRetentionBuilderTest
 * @package Tests\Greenter\Xml\Builder
 */
class CeRetentionBuilderTest extends \PHPUnit_Framework_TestCase
{
    use CeBuilderTrait;
    use XsdValidatorTrait;

    public function testCreateXmlRetention()
    {
        $retention = $this->getRetention();

        foreach ($retention->getDetails() as $per)
        {
            $per->setImpPagar(0)
                ->setPagos(null)
                ->setImpRetenido(0);

        }
        $xml = $this->build($retention);

        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
        // file_put_contents('reten.xml', $xml);
    }

    public function testCreateXmlRetentionWithoutInformation()
    {
        $retention = $this->getRetention();

        foreach ($retention->getDetails() as $per)
        {
            $per->setImpPagar(0)
                ->setPagos(null)
                ->setImpRetenido(0);

        }
        $xml = $this->build($retention);

        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
        // file_put_contents('reten.xml', $xml);
    }

    public function testCreateXmlRetentionWihtoutExchange()
    {
        $retention = $this->getRetention();

        foreach ($retention->getDetails() as $detail) {
            $detail->setTipoCambio(null);
        }
        $xml = $this->build($retention);

        $this->assertNotEmpty($xml);
    }

    public function testRetentionFilename()
    {
        $retention = $this->getRetention();
        $filename = $retention->getName();

        $this->assertEquals($this->getFilename($retention), $filename);
    }

    private function getFileName(Retention $retention)
    {
        $parts = [
            $retention->getCompany()->getRuc(),
            '20',
            $retention->getSerie(),
            $retention->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}