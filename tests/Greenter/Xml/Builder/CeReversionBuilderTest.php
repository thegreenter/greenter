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

    public function testValidateReversion()
    {
        $reversion = $this->getReversion();
        $validator = $this->getValidator();
        $errors = $validator->validate($reversion);

        $this->assertEquals(0, count($errors));
    }

    public function testNotValidateReversion()
    {
        $reversion = $this->getReversion();
        $reversion->setCorrelativo('1232')
            ->setFecComunicacion(null);
        $validator = $this->getValidator();
        $errors = $validator->validate($reversion);

        $this->assertEquals(2, count($errors));
    }

    public function testCreateXmlReversion()
    {
        $reversion = $this->getReversion();

        $generator = $this->getGenerator();
        $xml = $generator->buildReversion($reversion);

        $this->assertNotEmpty($xml);
    }

    /**
     * @expectedException \Greenter\Xml\Exception\ValidationException
     */
    public function testXmlReversionException()
    {
        $reversion = $this->getReversion();
        $reversion->setCorrelativo('1232');

        $generator = $this->getGenerator();
        $generator->buildReversion($reversion);
    }

    public function testReversionFilename()
    {
        $ruc = $this->getCompany()->getRuc();
        $reversion = $this->getReversion();
        $filename = $reversion->getFileName($ruc);

        $this->assertEquals($this->getFilename($reversion, $ruc), $filename);
    }

    private function getFilename(Reversion $reversion, $ruc)
    {
        $parts = [
          $ruc,
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
            ->setDetails([$detial1, $detial2]);

        return $reversion;
    }
}