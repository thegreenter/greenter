<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 04/10/2017
 * Time: 12:44 PM
 */

declare(strict_types=1);

namespace Tests\Greenter\Xml\Builder;

use DateTime;
use Greenter\Data\Generator\SummaryIcbperStore;
use Greenter\Data\Generator\SummaryStore;
use Greenter\Model\Summary\Summary;
use PHPUnit\Framework\TestCase;

/**
 * Class FeSummaryBuilderTest
 * @package Tests\Greenter\Xml\Builder
 */
class FeSummaryBuilderTest extends TestCase
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
        $summary->setFecResumen(new DateTime('2021-03-05 00:00:00-05:00'));
        $filename = $summary->getName();

        $this->assertEquals('20123456789-RC-20210305-001', $filename);
    }

    public function storeProvider()
    {
        return [
          [SummaryStore::class],
          [SummaryIcbperStore::class]
        ];
    }
}
