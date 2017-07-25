<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/07/2017
 * Time: 04:06 PM
 */

namespace Greenter;

use Greenter\Zip\ZipFactory;
use Greenter\Security\SignedXml;
use Greenter\Ws\Services\FeSunat;
use Greenter\Xml\Builder\FeBuilder;
use Greenter\Model\Sale\Invoice;

class FeFactory
{
    /**
     * @var FeBuilder
     */
    private $generator;

    /**
     * @var SignedXml
     */
    private $signer;

    /**
     * @var ZipFactory
     */
    private $zip;

    /**
     * @var FeSunat
     */
    private $sender;

    /**
     * FeFactory constructor.
     */
    public function __construct()
    {
        $this->generator = new FeBuilder();
        $this->signer = new SignedXml();
        $this->sender = new FeSunat();
        $this->sender->setCrentials('20000000001MODDATOS', 'moddatos');
        $this->signer->setPrivateKey('');
    }

    public function sendInvoice(Invoice $invoice)
    {
        $xml = $this->generator->buildInvoice($invoice);
        $xmlS = $this->signer->sign($xml);
        $filename = sprintf('200000000-%s-%s-%s',
            $invoice->getTipoDoc(), $invoice->getSerie(), $invoice->getCorrelativo());

        $zip = $this->zip->compress("$filename.xml", $xmlS);
        $res = $this->sender->send("$filename.zip", $zip);
        $res->isSuccess();
    }

    /**
     * @param $company
     * @return $this
     */
    public function setCompany($company)
    {
        $this->generator->setCompany($company);
        return $this;
    }
}