<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 12/08/2017
 * Time: 18:06
 */

namespace Greenter\Factory;

use Greenter\Model\Company\Company;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\SummaryResult;
use Greenter\Security\SignedXml;
use Greenter\Ws\Services\FeSunat;
use Greenter\Ws\Services\WsSunatInterface;
use Greenter\Zip\ZipFactory;

/**
 * Class BaseFactory
 * @package Greenter\Factory
 */
class BaseFactory
{
    /**
     * @var SignedXml
     */
    protected $signer;

    /**
     * @var ZipFactory
     */
    protected $zipper;

    /**
     * @var WsSunatInterface
     */
    protected $sender;

    /**
     * @var Company
     */
    protected $company;

    /**
     * Ultimo xml generado.
     *
     * @var string
     */
    protected $lastXml;

    /**
     * BaseFactory constructor.
     */
    public function __construct()
    {
        $this->signer = new SignedXml();
        $this->sender = new FeSunat();
        $this->zipper = new ZipFactory();
        $this->sender->setUrlWsdl(__DIR__.'/../Resources/wsdl/billService.wsdl');
    }

    /**
     * @param array $ws
     */
    protected function setWsParams($ws)
    {
        $this->sender->setCredentials($ws['user'], $ws['pass']);
        if (isset($ws['service'])) {
            $this->sender->setService($ws['service']);
        }
        if (isset($ws['wsdl'])) {
            $this->sender->setUrlWsdl($ws['wsdl']);
        }
    }

    /**
     * @param string $xml
     * @param string $filename
     * @return BillResult
     */
    protected function getBillResult($xml, $filename)
    {
        $this->lastXml = $this->getXmmlSigned($xml);

        $zip = $this->zipper->compress("$filename.xml", $this->lastXml);
        return $this->sender->send("$filename.zip", $zip);
    }

    /**
     * @param string $xml
     * @param string $filename
     * @return SummaryResult
     */
    protected function getSummaryResult($xml, $filename)
    {
        $this->lastXml = $this->getXmmlSigned($xml);

        $zip = $this->zipper->compress("$filename.xml", $this->lastXml);
        return $this->sender->sendSummary("$filename.zip", $zip);
    }

    /**
     * @param string $xml
     * @return string
     */
    private function getXmmlSigned($xml)
    {
        return $this->signer->sign($xml);
    }
}