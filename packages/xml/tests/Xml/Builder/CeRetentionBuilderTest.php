<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 01:42 PM
 */

declare(strict_types=1);

namespace Tests\Greenter\Xml\Builder;

use Greenter\Data\Generator\RetentionStore;
use Greenter\Model\Retention\Retention;
use PHPUnit\Framework\TestCase;

/**
 * Class CeRetentionBuilderTest
 * @package Tests\Greenter\Xml\Builder
 */
class CeRetentionBuilderTest extends TestCase
{
    use CeBuilderTrait;
    use XsdValidatorTrait;

    public function testCreateXmlRetention()
    {
        $retention = $this->createDocument(RetentionStore::class);

        $xml = $this->build($retention);

        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }

    public function testCreateXmlRetentionWithoutInformation()
    {
        $retention = $this->createDocument(RetentionStore::class);

        $xml = $this->build($retention);

        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }

    public function testRetentionFilename()
    {
        /**@var $retention Retention*/
        $retention = $this->createDocument(RetentionStore::class);
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