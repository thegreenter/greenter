<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 24/01/2018
 * Time: 10:14 AM
 */

namespace Tests\Greenter\Xml\Builder;

/**
 * Trait XsdValidatorTrait
 * @method assertTrue($state)
 */
trait XsdValidatorTrait
{

    public function assertSchema($xsd, $xml)
    {
        $doc = $this->getDoc($xml);
        $success = $doc->schemaValidate($xsd);

        $this->assertTrue($success);
    }

    public function assertInvoiceSchema($xml)
    {
        $xsd = __DIR__ . '/../../Resources/xsd/maindoc/UBLPE-Invoice-1.0.xsd';

        $this->assertSchema($xsd, $xml);
    }

    public function assertCreditNoteSchema($xml)
    {
        $xsd = __DIR__ . '/../../Resources/xsd/maindoc/UBLPE-CreditNote-1.0.xsd';

        $this->assertSchema($xsd, $xml);
    }

    public function assertDebitNoteSchema($xml)
    {
        $xsd = __DIR__ . '/../../Resources/xsd/maindoc/UBLPE-DebitNote-1.0.xsd';

        $this->assertSchema($xsd, $xml);
    }

    public function assertDespatchSchema($xml)
    {
        $xsd = __DIR__ . '/../../Resources/xsd2.1/maindoc/UBL-DespatchAdvice-2.1.xsd';

        $this->assertSchema($xsd, $xml);
    }

    public function assertRetentionSchema($xml)
    {
        $xsd = __DIR__ . '/../../Resources/xsd/maindoc/UBLPE-Retention-1.0.xsd';

        $this->assertSchema($xsd, $xml);
    }

    public function assertPerceptionSchema($xml)
    {
        $xsd = __DIR__ . '/../../Resources/xsd/maindoc/UBLPE-Perception-1.0.xsd';

        $this->assertSchema($xsd, $xml);
    }

    public function assertSummarySchema($xml)
    {
        $xsd = __DIR__ . '/../../Resources/xsd/maindoc/UBLPE-SummaryDocuments-1.0.xsd';

        $this->assertSchema($xsd, $xml);
    }

    public function assertVoidedSchema($xml)
    {
        $xsd = __DIR__ . '/../../Resources/xsd/maindoc/UBLPE-VoidedDocuments-1.0.xsd';

        $this->assertSchema($xsd, $xml);
    }

    private function getDoc($xml)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($xml);

        return $doc;
    }
}