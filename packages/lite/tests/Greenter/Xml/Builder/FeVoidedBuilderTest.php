<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 19/07/2017
 * Time: 10:47 AM
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Model\Voided\Voided;
use Greenter\Model\Voided\VoidedDetail;

/**
 * Class FeVoidedBuilderTest
 * @package tests\Greenter\Xml\Builder
 */
class FeVoidedBuilderTest extends \PHPUnit_Framework_TestCase
{
    use FeBuilderTrait;

    public function testValidateVoided()
    {
        $voided = $this->getVoided();
        $validator = $this->getValidator();
        $errors = $validator->validate($voided);

        $this->assertEquals(0, count($errors));
    }

    public function testNotValidateVoided()
    {
        $voided = $this->getVoided();
        $voided->setCorrelativo('1232')
            ->setFecComunicacion(null);
        $validator = $this->getValidator();
        $errors = $validator->validate($voided);

        $this->assertEquals(2, count($errors));
    }

    public function testCreateXmlVoided()
    {
        $voided = $this->getVoided();

        $generator = $this->getGenerator();
        $xml = $generator->buildVoided($voided);

        $this->assertNotEmpty($xml);
    }

    /**
     * @expectedException \Greenter\Xml\Exception\ValidationException
     */
    public function testXmlVoidedException()
    {
        $voided = $this->getVoided();
        $voided->setCorrelativo('1232');

        $generator = $this->getGenerator();
        $generator->buildVoided($voided);
    }

    public function testVoidedFilename()
    {
        $ruc = $this->getCompany()->getRuc();
        $voided = $this->getVoided();
        $filename = $voided->getFileName($ruc);

        $this->assertEquals($this->getFilename($voided, $ruc), $filename);
    }

    private function getFilename(Voided $voided, $ruc)
    {
        $parts = [
            $ruc,
            'RA',
            $voided->getFecComunicacion()->format('Ymd'),
            $voided->getCorrelativo(),
        ];

        return join('-', $parts);
    }

    private function getVoided()
    {
        $detial1 = new VoidedDetail();
        $detial1->setTipoDoc('01')
            ->setSerie('F001')
            ->setCorrelativo('02132132')
            ->setDesMotivoBaja('ERROR DE SISTEMA');

        $detial2 = new VoidedDetail();
        $detial2->setTipoDoc('03')
            ->setSerie('B001')
            ->setCorrelativo('123')
            ->setDesMotivoBaja('ERROR DE RUC');

        $voided = new Voided();
        $voided->setCorrelativo('001')
            ->setFecComunicacion(new \DateTime())
            ->setFecGeneracion(new \DateTime())
            ->setDetails([$detial1, $detial2]);

        return $voided;
    }
}