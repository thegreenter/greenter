<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/08/2017
 * Time: 20:19
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Model\Voided\Reversion;

/**
 * Class CeReversionBuilderTest
 * @package Tests\Greenter\Xml\Builder
 */
class CeReversionBuilderTest extends \PHPUnit_Framework_TestCase
{
    use CeBuilderTrait;
    use XsdValidatorTrait;

    public function testCreateXmlReversion()
    {
        $reversion = $this->getReversion();

        $xml = $this->build($reversion);

        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }

    public function testReversionFilename()
    {
        $reversion = $this->getReversion();
        $filename = $reversion->getName();

        $this->assertEquals($this->getFilename($reversion), $filename);
    }

    private function getFilename(Reversion $reversion)
    {
        $parts = [
          $reversion->getCompany()->getRuc(),
          'RR',
          $reversion->getFecComunicacion()->format('Ymd'),
          $reversion->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}