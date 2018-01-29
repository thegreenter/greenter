<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 04/10/2017
 * Time: 12:44 PM
 */

namespace Tests\Greenter\Xml\Builder;

use Greenter\Model\Summary\Summary;

/**
 * Class FeSummaryBuilderTest
 * @package Tests\Greenter\Xml\Builder
 */
class FeSummaryBuilderTest extends \PHPUnit_Framework_TestCase
{
    use FeBuilderTrait;
    use XsdValidatorTrait;

    public function testCreateXmlSummary()
    {
        $summary = $this->getSummary();

        $xml = $this->build($summary);
        $this->assertNotEmpty($xml);

        $this->assertNotEmpty($xml);
        $this->assertSchema($xml);
    }

    public function testSummaryFilename()
    {
        $summary = $this->getSummary();
        $filename = $summary->getName();

        $this->assertEquals($this->getFilename($summary), $filename);
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