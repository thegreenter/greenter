<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 29/01/2019
 * Time: 17:42
 */

namespace Tests\Greenter\Ws\Resolver;

use Greenter\Model\Perception\Perception;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;
use Greenter\Model\Summary\Summary;
use Greenter\Model\Voided\Reversion;
use Greenter\Model\Voided\Voided;
use Greenter\Ws\Resolver\TypeResolverInterface;
use Greenter\Ws\Resolver\XmlTypeResolver;

class TypeResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TypeResolverInterface
     */
    private $resolver;

    protected function setUp()
    {
        $this->resolver = new XmlTypeResolver();
    }

    /**
     * @dataProvider getFilesTypeExpected
     * @param string $expectedType
     * @param string $file
     */
    public function testResolveType($expectedType, $file)
    {
        $xml = file_get_contents($file);

        $resultType = $this->resolver->getType($xml);

        $this->assertEquals($expectedType, $resultType);
    }

    public function testNotFoundType()
    {
        $content = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<Invoice2 xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2">
</Invoice2>
XML;

        $doc = new \DOMDocument();
        $doc->loadXML($content);

        $result = $this->resolver->getType($doc);

        $this->assertEmpty($result);
    }

    public function getFilesTypeExpected()
    {
        $params = [
            [Invoice::class, __DIR__.'/../../Resources/20600055519-01-F001-00000001.xml'],
            [Note::class, __DIR__.'/../../Resources/Name/20123456789-07-FF01-123.xml'],
            [Note::class, __DIR__.'/../../Resources/Name/20123456789-08-FF01-123.xml'],
            [Retention::class, __DIR__.'/../../Resources/Name/20123456789-20-R001-123.xml'],
            [Perception::class, __DIR__.'/../../Resources/Name/20123456789-40-P001-123.xml'],
            [Summary::class,__DIR__.'/../../Resources/20000000001-RC-20171119-001.xml'],
            [Voided::class,__DIR__.'/../../Resources/20600995805-RA-20170719-01.xml'],
            [Reversion::class,__DIR__.'/../../Resources/Name/20123456789-RR-20190122-00111.xml'],
        ];

        return $params;
    }
}