<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 05/10/2017
 * Time: 08:14
 */

namespace Greenter\Xml\Parser;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Address;
use Greenter\Model\Company\Company;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Detraction;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\Prepayment;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\SalePerception;
use Greenter\Parser\DocumentParserInterface;

/**
 * Class InvoiceParser
 * @package Greenter\Xml\Parser
 */
class InvoiceParser implements DocumentParserInterface
{
    /**
     * @param $value
     * @return DocumentInterface
     */
    public function parse($value)
    {
        $xpt = $this->getXpath($value);
        $inv = new Invoice();
        $docFac = explode('-', $this->defValue($xpt->query('/xt:Invoice/cbc:ID')));
        $inv->setSerie($docFac[0])
            ->setCorrelativo($docFac[1])
            ->setTipoDoc($this->defValue($xpt->query('/xt:Invoice/cbc:InvoiceTypeCode')))
            ->setTipoMoneda($this->defValue($xpt->query('/xt:Invoice/cbc:DocumentCurrencyCode')))
            ->setFechaEmision(new \DateTime($this->defValue($xpt->query('/xt:Invoice/cbc:IssueDate'))))
            ->setCompany($this->getCompany($xpt))
            ->setClient($this->getClient($xpt));


        $additional = $xpt->query('/xt:Invoice/ext:UBLExtensions/ext:UBLExtension[1]/ext:ExtensionContent/sac:AdditionalInformation')->item(0);
        $this->loadTotals($inv, $xpt, $additional);
        $this->loadTributos($inv, $xpt);
        $monetaryTotal = $xpt->query('/xt:Invoice/cac:LegalMonetaryTotal')->item(0);
        $inv->setTipoOperacion($this->defValue($xpt->query('sac:SUNATTransaction/cbc:ID', $additional)))
            ->setSumDsctoGlobal(floatval($this->defValue($xpt->query('cbc:AllowanceTotalAmount', $monetaryTotal),0)))
            ->setTotalAnticipos(floatval($this->defValue($xpt->query('cbc:PrepaidAmount', $monetaryTotal),0)))
            ->setAnticipos(iterator_to_array($this->getPrepayments($xpt)))
            ->setMtoOtrosTributos(floatval($this->defValue($xpt->query('cbc:ChargeTotalAmount', $monetaryTotal), 0)))
            ->setMtoImpVenta($this->defValue($xpt->query('cbc:PayableAmount', $monetaryTotal)))
            ->setDetails(iterator_to_array($this->getDetails($xpt)))
            ->setLegends(iterator_to_array($this->getLegends($xpt,  $additional)));

        return $inv;
    }

    private function getXpath($value)
    {
        if ($value instanceof \DOMDocument) {
            $doc = $value;
        } else {
            $doc = new \DOMDocument();
            $doc->loadXML($value);
        }
        $rootNamespace = $doc->documentElement->namespaceURI;
        $xpt = new \DOMXPath($doc);
        $xpt->registerNamespace('xt', $rootNamespace);

        return $xpt;
    }

    private function defValue(\DOMNodeList $nodeList, $default = '')
    {
        if ($nodeList->length == 0) {
            return $default;
        }

        return $nodeList->item(0)->nodeValue;
    }

    private function loadTotals(Invoice $inv, \DOMXPath $xpt, \DOMNode $node)
    {
        $totals = $xpt->query('sac:AdditionalMonetaryTotal', $node);
        foreach ($totals as $total) {
            /**@var $total \DOMElement*/
            $id = $this->defValue($xpt->query('cbc:ID', $total));
            $val = floatval($this->defValue($xpt->query('cbc:PayableAmount', $total),0));
            switch ($id) {
                case '1001':
                    $inv->setMtoOperGravadas($val);
                    break;
                case '1002':
                    $inv->setMtoOperInafectas($val);
                    break;
                case '1003':
                    $inv->setMtoOperExoneradas($val);
                    break;
                case '1004':
                    $inv->setMtoOperGratuitas($val);
                    break;
                case '2001':
                    $inv->setPerception((new SalePerception())
                        ->setCodReg($xpt->query('cbc:ID', $total)->item(0)->getAttribute('schemeID'))
                        ->setMto($val)
                        ->setMtoBase($this->defValue($xpt->query('sac:ReferenceAmount', $total)))
                        ->setMtoTotal($this->defValue($xpt->query('sac:TotalAmount', $total))));
                    break;
                case '2003':
                    $inv->setDetraccion((new Detraction())
                        ->setMount($val)
                        ->setPercent($this->defValue($xpt->query('cbc:Percent', $total)))
                        ->setValueRef($this->defValue($xpt->query('sac:ReferenceAmount', $total))));
                    break;
                case '2005':
                    $inv->setMtoDescuentos($val);
                    break;
            }
        }
    }

    private function loadTributos(Invoice $inv, \DOMXPath $xpt)
    {
        $taxs = $xpt->query('/xt:Invoice/cac:TaxTotal');
        foreach ($taxs as $tax) {
            $name = $this->defValue($xpt->query('cac:TaxSubtotal/cac:TaxCategory/cac:TaxScheme/cbc:Name', $tax));
            $val = floatval($this->defValue($xpt->query('cbc:TaxAmount', $tax),0));
            switch ($name) {
                case 'IGV':
                    $inv->setMtoIGV($val);
                    break;
                case 'ISC':
                    $inv->setMtoISC($val);
                    break;
                case 'OTROS':
                    $inv->setSumOtrosCargos($val);
                    break;
            }
        }
    }

    private function getPrepayments(\DOMXPath $xpt)
    {
        $nodes = $xpt->query('/xt:Invoice/cac:PrepaidPayment');
        if ($nodes->length == 0) {
            return;
        }
        foreach ($nodes as $node) {
            $docRel = $xpt->query('cbc:ID', $node)->item(0);
            $item = (new Prepayment())
                ->setTotal(floatval($this->defValue($xpt->query('cbc:PaidAmount', $node),0)))
                ->setTipoDocRel($docRel->getAttribute('schemeID'))
                ->setNroDocRel($docRel->nodeValue);

            yield $item;
        }
    }

    private function getLegends(\DOMXPath $xpt, \DOMNode $node)
    {
        $legends = $xpt->query('sac:AdditionalProperty', $node);
        foreach ($legends as $legend) {
            /**@var $legend \DOMElement*/
            $leg = (new Legend())
                ->setCode($this->defValue($xpt->query('cbc:ID', $legend)))
                ->setValue($this->defValue($xpt->query('cbc:Value', $legend)));

            yield $leg;
        }
    }

    private function getClient(\DOMXPath $xp)
    {
        $node = $xp->query('/xt:Invoice/cac:AccountingCustomerParty')->item(0);

        $cl = new Client();
        $cl->setNumDoc($this->defValue($xp->query('cbc:CustomerAssignedAccountID', $node)))
            ->setTipoDoc($this->defValue($xp->query('cbc:AdditionalAccountID', $node)))
            ->setRznSocial($this->defValue($xp->query('cac:Party/cac:PartyLegalEntity/cbc:RegistrationName', $node)))
            ->setAddress((new Address())
                ->setDireccion($this->defValue($xp->query('cac:Party/cac:PostalAddress/cbc:StreetName', $node))));

        return $cl;
    }

    private function getCompany(\DOMXPath $xp)
    {
        $node = $xp->query('/xt:Invoice/cac:AccountingSupplierParty')->item(0);

        $cl = new Company();
        $cl->setRuc($this->defValue($xp->query('cbc:CustomerAssignedAccountID', $node)))
            ->setNombreComercial($this->defValue($xp->query('cac:Party/cac:PartyName/cbc:Name', $node)))
            ->setRazonSocial($this->defValue($xp->query('cac:Party/cac:PartyLegalEntity/cbc:RegistrationName', $node)))
            ->setAddress((new Address())
                ->setDireccion($this->defValue($xp->query('cac:Party/cac:PostalAddress/cbc:StreetName', $node))));

        return $cl;
    }

    private function getDetails(\DOMXPath $xpt)
    {
        $nodes = $xpt->query('/xt:Invoice/cac:InvoiceLine');

        foreach ($nodes as $node) {
            $quant = $xpt->query('cbc:InvoicedQuantity', $node)->item(0);
            $det = new SaleDetail();
            $det->setCtdUnidadItem($quant->nodeValue)
                ->setCodUnidadMedida($quant->getAttribute('unitCode'))
                ->setMtoValorVenta($this->defValue($xpt->query('cbc:LineExtensionAmount', $node)))
                ->setMtoValorUnitario($this->defValue($xpt->query('cac:Price/cbc:PriceAmount', $node)))
                ->setDesItem($this->defValue($xpt->query('cac:Item/cbc:Description', $node)))
                ->setCodProducto($this->defValue($xpt->query('cac:Item/cac:SellersItemIdentification/cbc:ID', $node)));

            $taxs = $xpt->query('cac:TaxTotal', $node);
            foreach ($taxs as $tax) {
                $name = $this->defValue($xpt->query('cac:TaxSubtotal/cac:TaxCategory/cac:TaxScheme/cbc:Name', $tax));
                $val = floatval($this->defValue($xpt->query('cbc:TaxAmount', $tax),0));
                switch ($name) {
                    case 'IGV':
                        $det->setMtoIgvItem($val);
                        $det->setTipAfeIgv($this->defValue($xpt->query('cac:TaxSubtotal/cac:TaxCategory/cbc:TaxExemptionReasonCode', $tax)));
                        break;
                    case 'ISC':
                        $det->setMtoIscItem($val);
                        $det->setTipSisIsc($this->defValue($xpt->query('cac:TaxSubtotal/cac:TaxCategory/cbc:TierRange', $tax)));
                        break;
                }
            }

            $prices = $xpt->query('cac:PricingReference', $node);
            foreach ($prices as $price) {
                $code = $this->defValue($xpt->query('cac:AlternativeConditionPrice/cbc:PriceTypeCode', $price));
                $value = floatval($this->defValue($xpt->query('cac:AlternativeConditionPrice/cbc:PriceAmount', $price),0));
                $code = trim($code);

                switch ($code) {
                    case '01':
                        $det->setMtoPrecioUnitario($value);
                        break;
                    case '02':
                        $det->setMtoValorGratuito($value);
                        break;
                }
            }

            yield $det;
        }
    }
}