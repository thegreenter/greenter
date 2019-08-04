<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 04/10/2017
 * Time: 12:44 PM
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Data\Generator\SummaryIcbperStore;
use Greenter\Data\Generator\SummaryStore;
use Greenter\Model\Summary\Summary;

/**
 * Class FeSummaryBuilderTest
 * @package Tests\Greenter\Xml\Builder
 */
class FeSummaryBuilderTest extends \PHPUnit_Framework_TestCase
{
    use FeBuilderTrait;
    use XsdValidatorTrait;

    /**
     * @dataProvider storeProvider
     */
    public function testCreateXmlSummary($summaryClass)
    {
        $summary = $this->createDocument($summaryClass);

        $xml = $this->build($summary);
        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }

    public function testCreateXmlSummaryOtherMoney()
    {
        /**@var $summary Summary*/
        $summary = $this->createDocument(SummaryStore::class);
        $summary->setMoneda('USD');

        $xml = $this->build($summary);

        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }


    public function testSummaryFilename()
    {
        /**@var $summary Summary*/
        $summary = $this->createDocument(SummaryStore::class);
        $filename = $summary->getName();

        $this->assertEquals($this->getFilename($summary), $filename);
    }

    public function storeProvider()
    {
        return [
          [SummaryStore::class],
          [SummaryIcbperStore::class]
        ];
    }

    private function getFileName(Summary $summary)
    {
        $parts = [
            $summary->getCompany()->getRuc(),
            'RC',
            $summary->getFecResumen()->format('Ymd'),
            $summary->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}