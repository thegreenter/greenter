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
use Greenter\Model\Client\Client;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\Transportist;
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

    /**
     * Georreferencia de los puntos de partida y llegada (cac:LocationCoordinate, al final del cac:Address),
     * GTIN del bien (StandardItemIdentification, entre el código del bien y la clasificación SUNAT)
     * y el número MTC del transportista, que no se escribe vacío.
     */
    public function testGeorreferenciaGtinYMtcVacio()
    {
        /** @var Despatch $despatch */
        $despatch = $this->createDocument(Despatch2022Store::class);
        $envio = $despatch->getEnvio();
        $envio->getPartida()->setLatitud(-12.04637)->setLongitud(-77.04279412);
        $envio->getLlegada()->setLatitud(-16.409047)->setLongitud(-71.537451);
        $envio->getTransportista()->setNroMtc(null);
        $despatch->getDetails()[0]->setCodProdGS1('7750182000014');
        $despatch->getDetails()[1]->setCodProdGS1('1234567');

        $xml = $this->build($despatch);
        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace('cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xpath->registerNamespace('cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $partida = '/*/cac:Shipment/cac:Delivery/cac:Despatch/cac:DespatchAddress/cac:LocationCoordinate';
        $llegada = '/*/cac:Shipment/cac:Delivery/cac:DeliveryAddress/cac:LocationCoordinate';

        $this->assertSame(['-12.04637', 'DD', '-77.04279412', 'DD'], [
            $xpath->evaluate("string($partida/cbc:LatitudeDegreesMeasure)"),
            $xpath->evaluate("string($partida/cbc:LatitudeDegreesMeasure/@unitCode)"),
            $xpath->evaluate("string($partida/cbc:LongitudeDegreesMeasure)"),
            $xpath->evaluate("string($partida/cbc:LongitudeDegreesMeasure/@unitCode)"),
        ]);
        $this->assertSame(['-16.409047', '-71.537451'], [
            $xpath->evaluate("string($llegada/cbc:LatitudeDegreesMeasure)"),
            $xpath->evaluate("string($llegada/cbc:LongitudeDegreesMeasure)"),
        ]);
        // La coordenada es lo último del cac:Address, después de cac:AddressLine.
        $this->assertSame(0, $xpath->query("$partida/following-sibling::*")->length);
        $this->assertSame(1, $xpath->query("$partida/preceding-sibling::cac:AddressLine")->length);

        $item = '/*/cac:DespatchLine[%d]/cac:Item';
        $this->assertSame(['7750182000014', 'GTIN-13'], [
            $xpath->evaluate('string('.sprintf($item, 1).'/cac:StandardItemIdentification/cbc:ID)'),
            $xpath->evaluate('string('.sprintf($item, 1).'/cac:StandardItemIdentification/cbc:ID/@schemeID)'),
        ]);
        // Un GTIN de longitud no válida se escribe sin schemeID.
        $this->assertSame(0, $xpath->query(sprintf($item, 2).'/cac:StandardItemIdentification/cbc:ID[@schemeID]')->length);
        $this->assertSame(1, $xpath->query(sprintf($item, 1).'/cac:SellersItemIdentification/following-sibling::cac:StandardItemIdentification/following-sibling::cac:CommodityClassification')->length);

        $this->assertSame(0, $xpath->query('/*/cac:Shipment/cac:ShipmentStage/cac:CarrierParty/cac:PartyLegalEntity/cbc:CompanyID')->length);
        $this->assertSchema($xml);
    }

    public function testSinGeorreferenciaNiGtinNoSeEscriben()
    {
        /** @var Despatch $despatch */
        $despatch = $this->createDocument(Despatch2022Store::class);

        $xml = $this->build($despatch);
        $this->assertStringNotContainsString('<cac:LocationCoordinate>', $xml);
        $this->assertStringNotContainsString('<cac:StandardItemIdentification>', $xml);
        $this->assertStringContainsString('<cbc:CompanyID>', $xml);
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

    /**
     * Guía de remisión transportista (31): el remitente va en cac:Despatch/cac:DespatchParty (antes de
     * cac:AgentParty cuando hay autorización especial) y el subcontratado en cac:Consignment, antes de
     * cac:ShipmentStage.
     */
    public function testGuiaTransportistaConRemitenteYSubcontratado()
    {
        /** @var Despatch $despatch */
        $despatch = $this->createDocument(Despatch2022Store::class);
        $despatch->setTipoDoc('31')
            ->setRemitente((new Client())->setTipoDoc('6')->setNumDoc('20555555551')->setRznSocial('REMITENTE SAC'));
        $despatch->getEnvio()
            ->setCodTraslado(null)
            ->setModTraslado(null)
            ->setAutorizacion((new Autorizacion())->setNumero('AUT-REM-2026-01')->setCodEmisor('06'))
            ->setSubContratado((new Transportist())->setTipoDoc('6')->setNumDoc('20000000003')->setRznSocial('SUBCONTRATA SAC'));

        $xml = $this->build($despatch);
        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace('cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xpath->registerNamespace('cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $remitente = '/*/cac:Shipment/cac:Delivery/cac:Despatch/cac:DespatchParty';
        $subcontratado = '/*/cac:Shipment/cac:Consignment/cac:LogisticsOperatorParty';

        $this->assertSame('31', $xpath->evaluate('string(/*/cbc:DespatchAdviceTypeCode)'));
        $this->assertSame(['6', '20555555551', 'REMITENTE SAC'], [
            $xpath->evaluate("string($remitente/cac:PartyIdentification/cbc:ID/@schemeID)"),
            $xpath->evaluate("string($remitente/cac:PartyIdentification/cbc:ID)"),
            $xpath->evaluate("string($remitente/cac:PartyLegalEntity/cbc:RegistrationName)"),
        ]);
        $this->assertSame('AUT-REM-2026-01', $xpath->evaluate("string($remitente/cac:AgentParty/cac:PartyLegalEntity/cbc:CompanyID)"));
        $this->assertSame(1, $xpath->query("$remitente/cac:PartyLegalEntity/following-sibling::cac:AgentParty")->length);
        $this->assertSame(['SUNAT_Envio', '6', '20000000003', 'SUBCONTRATA SAC'], [
            $xpath->evaluate('string(/*/cac:Shipment/cac:Consignment/cbc:ID)'),
            $xpath->evaluate("string($subcontratado/cac:PartyIdentification/cbc:ID/@schemeID)"),
            $xpath->evaluate("string($subcontratado/cac:PartyIdentification/cbc:ID)"),
            $xpath->evaluate("string($subcontratado/cac:PartyLegalEntity/cbc:RegistrationName)"),
        ]);
        $this->assertSame(1, $xpath->query('/*/cac:Shipment/cac:Consignment/following-sibling::cac:ShipmentStage')->length);
        // La guía 31 no lleva motivo ni modalidad de traslado, y el transportista solo escribe su número MTC.
        $this->assertSame(0, $xpath->query('/*/cac:Shipment/cbc:HandlingCode')->length);
        $this->assertSame(0, $xpath->query('/*/cac:Shipment/cac:ShipmentStage/cbc:TransportModeCode')->length);
        $carrier = '/*/cac:Shipment/cac:ShipmentStage/cac:CarrierParty';
        $this->assertSame('100101', $xpath->evaluate("string($carrier/cac:PartyLegalEntity/cbc:CompanyID)"));
        $this->assertSame(0, $xpath->query("$carrier/cac:PartyIdentification")->length);
        $this->assertSchema($xml);
    }

    public function testSinRemitenteNiSubcontratadoNoSeEscriben()
    {
        $xml = $this->build($this->createDocument(Despatch2022Store::class));
        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace('cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');

        $this->assertSame(0, $xpath->query('/*/cac:Shipment/cac:Consignment')->length);
        $this->assertSame(0, $xpath->query('/*/cac:Shipment/cac:Delivery/cac:Despatch/cac:DespatchParty/cac:PartyIdentification')->length);
        $this->assertSchema($xml);
    }
}
