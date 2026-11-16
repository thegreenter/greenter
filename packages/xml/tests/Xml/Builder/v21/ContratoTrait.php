<?php

declare(strict_types=1);

namespace Tests\Greenter\Xml\Builder\v21;

use Greenter\Model\Client\Client;
use Greenter\Model\Sale\Contrato;

/**
 * El contrato de colaboración empresarial y sus participantes, común a la
 * factura y a las notas.
 */
trait ContratoTrait
{
    /**
     * El contrato de colaboración y un participante: lo que se pone y dónde tiene que salir.
     *
     * @param \Greenter\Model\Sale\BaseSale $doc
     */
    private function conContrato($doc)
    {
        return $doc->setContrato((new Contrato())
                ->setTipo('1')
                ->setNumero('CCE-2026-014')
                ->setDescripcion('CONSORCIO VIAL DEL SUR')
                ->setPorcentaje(35.5))
            ->setParticipantes([(new Client())->setTipoDoc('6')->setNumDoc('20601234567')->setRznSocial('CONSTRUCTORA ANDINA S.A.C.')]);
    }

    private function assertContrato(string $xml)
    {
        $doc = new \DOMDocument();
        $doc->loadXML($xml);
        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace('cac', 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $xpath->registerNamespace('cbc', 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $contrato = '/*/cac:ContractDocumentReference';
        $this->assertSame(1, $xpath->query($contrato)->length, 'Un solo contrato (3498).');
        $this->assertSame(['CCE-2026-014', '1', 'CONSORCIO VIAL DEL SUR', '35.50'], [
            $xpath->evaluate('string('.$contrato.'/cbc:ID)'),
            $xpath->evaluate('string('.$contrato.'/cbc:DocumentTypeCode)'),
            $xpath->evaluate('string('.$contrato.'/cbc:DocumentDescription)'),
            $xpath->evaluate('string('.$contrato.'/cac:IssuerParty/cac:PartyLegalEntity/cac:ShareholderParty/cbc:PartecipationPercent)'),
        ]);
        $participante = '/*/cac:AccountingCustomerParty/cac:Party/cac:PartyLegalEntity/cac:ShareholderParty/cac:Party';
        $this->assertSame(['20601234567', '6', 'CONSTRUCTORA ANDINA S.A.C.'], [
            $xpath->evaluate('string('.$participante.'/cac:PartyIdentification/cbc:ID)'),
            $xpath->evaluate('string('.$participante.'/cac:PartyIdentification/cbc:ID/@schemeID)'),
            $xpath->evaluate('string('.$participante.'/cac:PartyLegalEntity/cbc:RegistrationName)'),
        ]);
        $this->assertSchema($xml);
    }
}
