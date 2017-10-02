<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 23:13
 */

namespace Greenter\Ws\Services;

use Greenter\Model\Response\Error;
use Greenter\Ws\Header\WSSESecurityHeader;
use Greenter\Ws\Reader\DomCdrReader;
use Greenter\Ws\Reader\XmlErrorReader;
use Greenter\Zip\ZipFactory;
use SoapClient;

/**
 * Class BaseSunat
 * @package Greenter\Ws\Services
 */
class BaseSunat
{
    /**
     * Url del servicio.
     * @var string
     */
    private $service;

    /**
     * Usuario (RUC + User SOL).
     * @var string
     */
    private $user;
    /**
     * Clave SOL
     *
     * @var string
     */
    private $password;

    /**
     * Parametros del Soap.
     * @var array
     */
    protected $parameters = [];

    /**
     * Url del WSDL.
     * @var string
     */
    protected $urlWsdl;

    /**
     * BaseSunat constructor.
     */
    public function __construct()
    {
        $this->urlWsdl = __DIR__.'/../../Resources/wsdl/billService.wsdl';
    }

    /**
     * Set Credentiasl WebService.
     *
     * @param string $user
     * @param string $password
     */
    public function setCredentials($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Create a new SoapClient.
     * @return SoapClient
     */
    public function getClient()
    {
        $client = new SoapClient($this->urlWsdl, $this->parameters);
        $client->__setLocation($this->service);
        $client->__setSoapHeaders(new WSSESecurityHeader($this->user, $this->password));

        return $client;
    }

    /**
     * Set Service of SUNAT.
     *
     * @param string $service
     * @return BaseSunat
     */
    public function setService($service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * Set Url del WSDL.
     *
     * @param string $urlWsdl
     * @return BaseSunat
     */
    public function setUrlWsdl($urlWsdl)
    {
        $this->urlWsdl = $urlWsdl;
        return $this;
    }

    /**
     * Get error from Fault Exception.
     *
     * @param \SoapFault $fault
     * @return Error
     */
    protected function getErrorFromFault(\SoapFault $fault)
    {
        $err = new Error();
        $fcode = $fault->faultcode;
        $code = preg_replace('/[^0-9]+/', '', $fcode);
        $msg = '';

        if ($code) {
            $msg = $this->getMessageError($code);
            $fcode = $code;
        } else {
            $code = preg_replace('/[^0-9]+/', '', $fault->faultstring);

            if ($code) {
                $msg = $this->getMessageError($code);
                $fcode = $code;
            }
        }

        if (!$msg) {
            $msg = isset($fault->detail) ? $fault->detail->message : $fault->faultstring;
        }

        $err->setCode($fcode);
        $err->setMessage($msg);

        return $err;
    }

    protected function extractResponse($zipContent)
    {
        $zip = new ZipFactory();
        $xml = $zip->decompressLastFile($zipContent);
        $reader = new DomCdrReader();

        return $reader->getCdrResponse($xml);
    }

    private function getMessageError($code)
    {
        $search = new XmlErrorReader();
        $msg = $search->getMessageByCode(intval($code));

        return $msg;
    }
}