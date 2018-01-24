<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/08/2017
 * Time: 20:19
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\VoidedDetail;

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
        $this->assertVoidedSchema($xml);
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

    private function getReversion()
    {
        $detial1 = new VoidedDetail();
        $detial1->setTipoDoc('20')
            ->setSerie('R001')
            ->setCorrelativo('02132132')
            ->setDesMotivoBaja('ERROR DE SISTEMA');

        $detial2 = new VoidedDetail();
        $detial2->setTipoDoc('20')
            ->setSerie('R001')
            ->setCorrelativo('123')
            ->setDesMotivoBaja('ERROR DE RUC');

        $reversion = new Reversion();
        $reversion->setCorrelativo('001')
            ->setFecComunicacion(new \DateTime())
            ->setFecGeneracion(new \DateTime())
            ->setCompany($this->getCompany())
            ->setDetails([$detial1, $detial2]);

        return $reversion;
    }
}