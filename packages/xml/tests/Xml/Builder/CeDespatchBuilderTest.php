<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 03:18 PM
 */

declare(strict_types=1);

namespace Tests\Greenter\Xml\Builder;

use Greenter\Data\Generator\Despatch2022Store;
use Greenter\Data\Generator\DespatchStore;
use Greenter\Model\Despatch\Autorizacion;
use Greenter\Model\Despatch\Contenedor;
use Greenter\Model\Despatch\Despatch;
use PHPUnit\Framework\TestCase;

/**
 * Class CeDespatchBuilderTest
 * @package Tests\Greenter\Xml\Builder
 */
class CeDespatchBuilderTest extends TestCase
{
    use CeBuilderTrait;
    use XsdValidatorTrait;

    public function testCreateXmlDespatch()
    {
        $despatch = $this->createDocument(DespatchStore::class);

        $xml = $this->build($despatch);

        $this->assertSchema($xml);
    }

    public function testCreateXmlDespatch2022()
    {
        $despatch = $this->createDocument(Despatch2022Store::class);

        $xml = $this->build($despatch);

        $this->assertSchema($xml);
    }

    public function testAutorizacionesEspecialesYContenedoresConPrecinto()
    {
        /** @var Despatch $despatch */
        $despatch = $this->createDocument(Despatch2022Store::class);
        $envio = $despatch->getEnvio();
        $envio->setAutorizacion((new Autorizacion())->setNumero('AUT-REM-2026-01')->setCodEmisor('06'))
            ->setContenedores([
                (new Contenedor())->setNumero('MSKU1234567')->setPrecinto('PE45879'),
                (new Contenedor())->setNumero('TGHU7654321'),
            ]);
        $envio->getTransportista()->setAutorizacion((new Autorizacion())->setNumero('AUT-TRA-77')->setCodEmisor('10'));

        $xml = $this->build($despatch);
        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace('cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xpath->registerNamespace('cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $remitente = '/*/cac:Shipment/cac:Delivery/cac:Despatch/cac:DespatchParty/cac:AgentParty/cac:PartyLegalEntity/cbc:CompanyID';
        $transportista = '/*/cac:Shipment/cac:ShipmentStage/cac:CarrierParty/cac:AgentParty/cac:PartyLegalEntity/cbc:CompanyID';
        $valores = fn (string $ruta) => [
            $xpath->evaluate('string('.$ruta.')'), $xpath->evaluate('string('.$ruta.'/@schemeID)'),
            $xpath->evaluate('string('.$ruta.'/@schemeName)'), $xpath->evaluate('string('.$ruta.'/@schemeAgencyName)'),
        ];
        $this->assertSame(['AUT-REM-2026-01', '06', 'Entidad Autorizadora', 'PE:SUNAT'], $valores($remitente));
        $this->assertSame(['AUT-TRA-77', '10', 'Entidad Autorizadora', 'PE:SUNAT'], $valores($transportista));
        // El número de contenedor en cbc:ID y el precinto en cbc:TraceID (campos 28 a 31); sin precinto, sin TraceID.
        $paquetes = $xpath->query('/*/cac:Shipment/cac:TransportHandlingUnit/cac:Package');
        $this->assertSame(2, $paquetes->length);
        $this->assertSame(['MSKU1234567', 'PE45879'], [
            $xpath->evaluate('string(cbc:ID)', $paquetes->item(0)), $xpath->evaluate('string(cbc:TraceID)', $paquetes->item(0)),
        ]);
        $this->assertSame(['TGHU7654321', 0], [
            $xpath->evaluate('string(cbc:ID)', $paquetes->item(1)), $xpath->query('cbc:TraceID', $paquetes->item(1))->length,
        ]);
        $this->assertSchema($xml);
    }

    public function testContenedoresComoTextoSiguenComoAntes()
    {
        /** @var Despatch $despatch */
        $despatch = $this->createDocument(Despatch2022Store::class);

        $xml = $this->build($despatch);
        $this->assertStringContainsString('<cbc:ID>1</cbc:ID>', $xml);
        $this->assertStringContainsString('<cbc:TraceID>0000001</cbc:TraceID>', $xml);
        $this->assertStringNotContainsString('<cac:AgentParty>', $xml);
        $this->assertStringNotContainsString('<cac:DespatchParty>', $xml);
    }

    public function testDespatchFilename()
    {
        /**@var $despatch Despatch*/
        $despatch= $this->createDocument(DespatchStore::class);
        $filename = $despatch->getName();

        $this->assertEquals($this->getFilename($despatch), $filename);
    }

    private function getFileName(Despatch $despatch)
    {
        $parts = [
            $despatch->getCompany()->getRuc(),
            '09',
            $despatch->getSerie(),
            $despatch->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}