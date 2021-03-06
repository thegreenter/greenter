<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 19/07/2017
 * Time: 10:47 AM
 */

declare(strict_types=1);

namespace Tests\Greenter\Xml\Builder;

use DateTime;
use DateTimeImmutable;
use Greenter\Data\Generator\VoidedStore;
use Greenter\Model\Voided\Voided;
use PHPUnit\Framework\TestCase;

/**
 * Class FeVoidedBuilderTest
 * @package tests\Greenter\Xml\Builder
 */
class FeVoidedBuilderTest extends TestCase
{
    use FeBuilderTrait;
    use XsdValidatorTrait;

    public function testCreateXmlVoided()
    {
        $voided = $this->createDocument(VoidedStore::class);

        $xml = $this->build($voided);

        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }

    public function testCreateXmlVoidedTimeInmutable()
    {
        /**@var Voided $voided */
        $voided = $this->createDocument(VoidedStore::class);
        $voided->setFecComunicacion(new DateTimeImmutable());

        $xml = $this->build($voided);

        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }

    public function testVoideTimeZone()
    {
        /**@var Voided $voided */
        $voided = $this->createDocument(VoidedStore::class);
        $voided->setFecComunicacion(new DateTime('2021-02-04 01:30:00+00:00')); // UTC 20210204

        $name = $voided->getName();

        $this->assertStringContainsString('RA-20210203-', $name); // Lima 20210203
    }

    public function testVoidedFilename()
    {
        /**@var $voided Voided */
        $voided = $this->createDocument(VoidedStore::class);
        $voided->setFecComunicacion(new DateTime('2021-03-05 00:00:00-05:00'));
        $filename = $voided->getName();

        $this->assertEquals('20123456789-RA-20210305-00111', $filename);
    }
}
