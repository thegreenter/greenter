<?php

declare(strict_types=1);

namespace Tests\Greenter;

use DOMDocument;
use Greenter\Api;
use Greenter\Data\Generator\InvoiceFullStore;
use Greenter\Data\GeneratorFactory;
use Greenter\Model\Sale\Invoice;
use Greenter\See;
use PHPUnit\Framework\TestCase;

/**
 * See y Api escapan los textos fuera de CDATA por defecto (opción autoescape de Twig).
 */
class AutoescapeDefaultTest extends TestCase
{
    private const TEXT = 'A & <B>';

    public function testSeeEscapesByDefault(): void
    {
        $xml = $this->build((new See())->getBuilderResolver()->find(Invoice::class));

        $this->assertStringContainsString('<cbc:CitySubdivisionName>A &amp; &lt;B&gt;</cbc:CitySubdivisionName>', $xml);
        $this->assertTrue(@(new DOMDocument())->loadXML($xml));
    }

    public function testApiEscapesByDefault(): void
    {
        $xml = $this->build((new Api())->getBuilderResolver()->find(Invoice::class));

        $this->assertStringContainsString('<cbc:CitySubdivisionName>A &amp; &lt;B&gt;</cbc:CitySubdivisionName>', $xml);
    }

    public function testSeeAllowsDisablingAutoescape(): void
    {
        $see = new See();
        $see->setBuilderOptions(['autoescape' => false]);

        $xml = $this->build($see->getBuilderResolver()->find(Invoice::class));

        $this->assertStringContainsString('<cbc:CitySubdivisionName>A & <B></cbc:CitySubdivisionName>', $xml);
    }

    private function build($builder): string
    {
        /** @var Invoice $invoice */
        $invoice = (new GeneratorFactory())->create(InvoiceFullStore::class)->create();
        $invoice->setUblVersion('2.1');
        $invoice->getClient()->getAddress()->setUrbanizacion(self::TEXT);

        return (string)$builder->build($invoice);
    }
}
