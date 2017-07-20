<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/07/2017
 * Time: 04:06 PM
 */

namespace Greenter;

use Greenter\Helper\ZipHelper;
use Greenter\Security\SignedXml;
use Greenter\Ws\Services\FeSunat;
use Greenter\Xml\Generator\FeGenerator;
use Greenter\Xml\Model\Sale\Invoice;

class FeFactory
{
    /**
     * @var FeGenerator
     */
    private $generator;

    /**
     * @var SignedXml
     */
    private $signer;

    /**
     * @var ZipHelper
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
        $this->generator = new FeGenerator();
        $this->signer = new SignedXml();
        $this->sender = new FeSunat('20000000001MODDATOS', 'moddatos');
        $this->signer->setPrivateKey('');
    }

    public function sendInvoice(Invoice $invoice)
    {
        $xml = $this->generator->buildInvoice($invoice);
        $xmlS = $this->signer->sign($xml);
        $filename = '';
        $zip = $this->zip->compress("$filename.xml", $xmlS);
        $zipR = $this->sender->send("$filename.zip", $zip);
        $xml = $this->zip->decompress($zipR, "R-$filename.xml");
    }
}