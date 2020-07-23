<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 28/01/2019
 * Time: 16:32.
 */

declare(strict_types=1);

namespace Tests\Greenter\Ws\Reader;

use Greenter\Ws\Reader\FilenameExtractorInterface;
use Greenter\Ws\Reader\XmlFilenameExtractor;
use Greenter\Ws\Reader\XmlReader;
use PHPUnit\Framework\TestCase;

class XmlFilenameExtractorTest extends TestCase
{
    const CBC_NS = 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2';

    /**
     * @var FilenameExtractorInterface
     */
    private $extractor;

    protected function setUp(): void
    {
        $this->extractor = new XmlFilenameExtractor(new XmlReader());
    }

    /**
     * @dataProvider getFiles
     *
     * @param string $filename
     */
    public function testGetName($filename)
    {
        $xml = file_get_contents($filename);
        $pathParts = pathinfo($filename);
        $name = $pathParts['filename'];

        $result = $this->extractor->getFilename($xml);

        $this->assertEquals($name, $result);
    }

    /**
     * @throws \Exception
     */
    public function testUblVersionNotSupported()
    {
        $this->expectException(\Exception::class);
        $doc = new \DOMDocument();
        $doc->load(__DIR__.'/../../Resources/20600055519-01-F001-00000001.xml');
        $doc->getElementsByTagNameNS(self::CBC_NS, 'UBLVersionID')
            ->item(0)
            ->nodeValue = '3.0';

        $this->extractor->getFilename($doc);
    }

    public function getFiles()
    {
        $files = glob(__DIR__.'/../../Resources/Name/*.xml');
        $list = array_map(function ($file) {
            return [$file];
        }, $files);

        $params = [
            [__DIR__.'/../../Resources/20600055519-01-F001-00000001.xml'],
            [__DIR__.'/../../Resources/20000000001-RC-20171119-001.xml'],
        ];
        $params = array_merge($params, $list);

        return $params;
    }
}
