<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 07/10/2017
 * Time: 12:29
 */

namespace Tests\Greenter\Xml;

use Greenter\Xml\Parser\InvoiceParser;
use Greenter\Xml\Parser\NoteParser;
use Greenter\Xml\ParserResolver;

/**
 * Class ParserResolverTest
 * @package Tests\Greenter\Xml
 */
class ParserResolverTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ParserResolver
     */
    private $resolver;

    protected function setUp()
    {
        $this->resolver = new ParserResolver();
    }

    public function testFactura()
    {
        $doc = new \DOMDocument();
        $doc->load(__DIR__.'/../Resources/exportacion.xml');
        $this->resolver->load($doc);

        $parser = $this->resolver->getParser();

        $this->assertInstanceOf(InvoiceParser::class, $parser);
    }

    public function testCreditNote()
    {
        $xml = file_get_contents(__DIR__.'/../Resources/notacr-fac.xml');
        $this->resolver->loadXml($xml);

        $parser = $this->resolver->getParser();

        $this->assertInstanceOf(NoteParser::class, $parser);
    }

    public function testDebitNote()
    {
        $xml = file_get_contents(__DIR__.'/../Resources/notadb-fac.xml');
        $this->resolver->loadXml($xml);

        $parser = $this->resolver->getParser();

        $this->assertInstanceOf(NoteParser::class, $parser);
    }

    public function testNotValidParser()
    {
        $xml = file_get_contents(__DIR__.'/../Resources/notadb-fac.xml');
        $this->resolver->loadXml($xml);

        $parser = $this->resolver->getParser();

        $this->assertNotInstanceOf(InvoiceParser::class, $parser);
    }

    /**
     * @expectedException \Exception
     */
    public function testNotInitialize()
    {
        $this->resolver->getParser();
    }
}