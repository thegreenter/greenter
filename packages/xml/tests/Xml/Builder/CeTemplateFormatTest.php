<?php

declare(strict_types=1);

namespace Tests\Greenter\Xml\Builder;

use DOMDocument;
use DOMXPath;
use Greenter\Data\Generator\PerceptionStore;
use Greenter\Data\Generator\RetentionStore;
use Greenter\Model\Company\Address;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Retention\Retention;
use Greenter\Xml\Builder\PerceptionBuilder;
use Greenter\Xml\Builder\RetentionBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Formato y ubicación de los campos según las reglas de validación SUNAT
 * (hojas Percepciones1_0 y Retenciones1_0).
 */
class CeTemplateFormatTest extends TestCase
{
    use CeBuilderTrait;
    use XsdValidatorTrait;

    /**
     * @dataProvider storeProvider
     */
    public function testDomicilioEmisorConUrbanizacion(string $store)
    {
        $doc = $this->createDocument($store);
        $doc->getCompany()->getAddress()
            ->setUbigueo('150101')
            ->setDireccion('AV LOS OLIVOS 123')
            ->setUrbanizacion('CASUARINAS')
            ->setProvincia('HUAURA')
            ->setDepartamento('LIMA')
            ->setDistrito('HUACHO');

        $xml = $this->build($doc);
        $xpath = $this->xpath($xml);
        $addr = "/*/cac:AgentParty/cac:PostalAddress";

        $this->assertSame('150101', $xpath->evaluate("string($addr/cbc:ID)"));
        $this->assertSame('AV LOS OLIVOS 123', $xpath->evaluate("string($addr/cbc:StreetName)"));
        $this->assertSame('CASUARINAS', $xpath->evaluate("string($addr/cbc:CitySubdivisionName)"));
        $this->assertSame('HUAURA', $xpath->evaluate("string($addr/cbc:CityName)"));
        $this->assertSame('LIMA', $xpath->evaluate("string($addr/cbc:CountrySubentity)"));
        $this->assertSame('HUACHO', $xpath->evaluate("string($addr/cbc:District)"));
        $this->assertSame('PE', $xpath->evaluate("string($addr/cac:Country/cbc:IdentificationCode)"));
        $this->assertSchema($xml);
    }

    /**
     * Los datos condicionales del emisor no generan tags vacíos (ERR-2548, OBS-2901, OBS-2917).
     *
     * @dataProvider storeProvider
     */
    public function testEmisorSinDatosOpcionales(string $store)
    {
        $doc = $this->createDocument($store);
        $doc->getCompany()->setNombreComercial(null)->setAddress(null);

        $xml = $this->build($doc);
        $xpath = $this->xpath($xml);

        $this->assertSame(0, $xpath->query("/*/cac:AgentParty/cac:PartyName")->length);
        $this->assertSame(0, $xpath->query("/*/cac:AgentParty/cac:PostalAddress")->length);
        $this->assertSchema($xml);
    }

    /**
     * @dataProvider storeProvider
     */
    public function testDomicilioEmisorParcialSinTagsVacios(string $store)
    {
        $doc = $this->createDocument($store);
        $doc->getCompany()->setAddress((new Address())->setDireccion('AV LOS OLIVOS 123'));

        $xml = $this->build($doc);
        $xpath = $this->xpath($xml);
        $addr = "/*/cac:AgentParty/cac:PostalAddress";

        $this->assertSame(['cbc:StreetName', 'cac:Country'], $this->childNames($xpath, $addr));
        $this->assertSame(0, $xpath->query("/*/cac:AgentParty//*[not(*) and normalize-space(.) = '']")->length, 'Sin tags vacíos');
        $this->assertSchema($xml);
    }

    /**
     * @dataProvider storeProvider
     */
    public function testNombreComercialYDomicilioReceptor(string $store)
    {
        $doc = $this->createDocument($store);
        $doc->getProveedor()
            ->setNombreComercial('MI TIENDA & CIA')
            ->setAddress((new Address())
                ->setUbigueo('150203')
                ->setDireccion('JR. NIQUEL 123')
                ->setUrbanizacion('INDUSTRIAL')
                ->setProvincia('BARRANCA')
                ->setDepartamento('LIMA')
                ->setDistrito('PARAMONGA'));

        $xml = $this->build($doc);
        $xpath = $this->xpath($xml);
        $party = "/*/cac:ReceiverParty";

        $this->assertSame(
            ['cac:PartyIdentification', 'cac:PartyName', 'cac:PostalAddress', 'cac:PartyLegalEntity'],
            $this->childNames($xpath, $party)
        );
        $this->assertSame('MI TIENDA & CIA', $xpath->evaluate("string($party/cac:PartyName/cbc:Name)"));
        $addr = "$party/cac:PostalAddress";
        $this->assertSame(
            ['cbc:ID', 'cbc:StreetName', 'cbc:CitySubdivisionName', 'cbc:CityName', 'cbc:CountrySubentity', 'cbc:District', 'cac:Country'],
            $this->childNames($xpath, $addr)
        );
        $this->assertSame('150203', $xpath->evaluate("string($addr/cbc:ID)"));
        $this->assertSame('INDUSTRIAL', $xpath->evaluate("string($addr/cbc:CitySubdivisionName)"));
        $this->assertSame('BARRANCA', $xpath->evaluate("string($addr/cbc:CityName)"));
        $this->assertSame('LIMA', $xpath->evaluate("string($addr/cbc:CountrySubentity)"));
        $this->assertSame('PARAMONGA', $xpath->evaluate("string($addr/cbc:District)"));
        $this->assertSame('PE', $xpath->evaluate("string($addr/cac:Country/cbc:IdentificationCode)"));
        $this->assertSchema($xml);
    }

    /**
     * @dataProvider storeProvider
     */
    public function testReceptorSinDatosOpcionales(string $store)
    {
        $doc = $this->createDocument($store);
        $doc->getProveedor()->setNombreComercial(null)->setAddress(null);

        $xml = $this->build($doc);
        $xpath = $this->xpath($xml);

        $this->assertSame(
            ['cac:PartyIdentification', 'cac:PartyLegalEntity'],
            $this->childNames($xpath, "/*/cac:ReceiverParty")
        );
        $this->assertSchema($xml);
    }

    /**
     * Razón social con caracteres especiales sin escapar dentro del CDATA,
     * aunque el entorno Twig tenga autoescape activo.
     *
     * @dataProvider storeProvider
     */
    public function testRazonSocialReceptorSinEscapar(string $store)
    {
        $doc = $this->createDocument($store);
        $doc->getProveedor()->setRznSocial('PEREZ & HIJOS S.A.C.');

        $builders = [Perception::class => PerceptionBuilder::class, Retention::class => RetentionBuilder::class];
        $builder = new $builders[get_class($doc)](['cache' => false, 'strict_variables' => true]);
        $xpath = $this->xpath($builder->build($doc));

        $this->assertSame('PEREZ & HIJOS S.A.C.', $xpath->evaluate("string(/*/cac:ReceiverParty/cac:PartyLegalEntity/cbc:RegistrationName)"));
    }

    /**
     * Monto de redondeo del importe total cobrado/pagado (n(12,2), PEN).
     *
     * El XSD incluido en greenter/ubl-validator 2.3 aún no define
     * cbc:PayableRoundingAmount, por eso aquí no se valida el esquema.
     *
     * @dataProvider storeProvider
     */
    public function testMontoRedondeo(string $store, string $totalTag)
    {
        $doc = $this->createDocument($store);
        $doc->setRedondeo(-0.02);

        $xpath = $this->xpath($this->build($doc));
        $node = $xpath->query("/*/cbc:PayableRoundingAmount")->item(0);

        $this->assertNotNull($node);
        $this->assertSame('-0.02', $node->textContent);
        $this->assertSame('PEN', $node->getAttribute('currencyID'));
        $names = $this->childNames($xpath, "/*");
        $pos = array_search('cbc:PayableRoundingAmount', $names, true);
        $this->assertSame($totalTag, $names[$pos - 1]);

        $doc->setRedondeo(0.3);
        $this->assertSame('0.30', $this->xpath($this->build($doc))->evaluate("string(/*/cbc:PayableRoundingAmount)"));
    }

    /**
     * @dataProvider storeProvider
     */
    public function testSinMontoRedondeo(string $store)
    {
        $xml = $this->build($this->createDocument($store));

        $this->assertSame(0, $this->xpath($xml)->query("/*/cbc:PayableRoundingAmount")->length);
        $this->assertSchema($xml);
    }

    public function storeProvider(): array
    {
        return [
            'percepcion' => [PerceptionStore::class, 'sac:SUNATTotalCashed'],
            'retencion' => [RetentionStore::class, 'sac:SUNATTotalPaid'],
        ];
    }

    /**
     * @return string[]
     */
    private function childNames(DOMXPath $xpath, string $path): array
    {
        $names = [];
        foreach ($xpath->query("$path/*") as $node) {
            $names[] = $node->nodeName;
        }

        return $names;
    }

    private function xpath(string $xml): DOMXPath
    {
        $doc = new DOMDocument();
        $this->assertTrue($doc->loadXML($xml), 'XML bien formado');
        $xpath = new DOMXPath($doc);
        $xpath->registerNamespace('cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xpath->registerNamespace('cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $xpath->registerNamespace('sac', 'urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1');

        return $xpath;
    }
}
