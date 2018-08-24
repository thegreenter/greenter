<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 23:13.
 */

namespace Greenter\Ws\Services;

use Greenter\Model\Response\Error;
use Greenter\Validator\ErrorCodeProviderInterface;
use Greenter\Ws\Reader\CdrReaderInterface;
use Greenter\Ws\Reader\DomCdrReader;
use Greenter\Zip\ZipFly;

/**
 * Class BaseSunat.
 */
class BaseSunat
{
    /**
     * @var ZipFly
     */
    private $zipper;

    /**
     * @var CdrReaderInterface
     */
    private $cdrReader;

    /**
     * @var WsClientInterface
     */
    private $client;

    /**
     * @var ErrorCodeProviderInterface
     */
    private $codeProvider;

    /**
     * @param ErrorCodeProviderInterface $codeProvider
     */
    public function setCodeProvider(ErrorCodeProviderInterface $codeProvider)
    {
        $this->codeProvider = $codeProvider;
    }

    /**
     * BaseSunat constructor.
     */
    public function __construct()
    {
        $this->zipper = new ZipFly();
        $this->cdrReader = new DomCdrReader();
    }

    /**
     * @return WsClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param WsClientInterface $client
     *
     * @return BaseSunat
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get error from Fault Exception.
     *
     * @param \SoapFault $fault
     *
     * @return Error
     */
    protected function getErrorFromFault(\SoapFault $fault)
    {
        $err = new Error();
        $err->setCode($fault->faultcode);
        $code = preg_replace('/[^0-9]+/', '', $err->getCode());
        $msg = '';

        if (empty($code)) {
            $code = preg_replace('/[^0-9]+/', '', $fault->faultstring);
        }

        if ($code) {
            $msg = $this->getMessageError($code);
            $err->setCode($code);
        }

        if (empty($msg)) {
            $msg = isset($fault->detail) ? $fault->detail->message : $fault->faultstring;
        }

        return $err->setMessage($msg);
    }

    /**
     * @param string $filename
     * @param string $xml
     *
     * @return string
     */
    protected function compress($filename, $xml)
    {
        return $this->zipper->compress($filename, $xml);
    }

    /**
     * @param $zipContent
     *
     * @return \Greenter\Model\Response\CdrResponse
     */
    protected function extractResponse($zipContent)
    {
        $xml = $this->getXmlResponse($zipContent);

        return $this->cdrReader->getCdrResponse($xml);
    }

    /**
     * @param $code
     *
     * @return string
     */
    protected function getMessageError($code)
    {
        if (empty($this->codeProvider)) {
            return '';
        }

        return $this->codeProvider->getValue($code);
    }

    private function getXmlResponse($content)
    {
        $filter = function ($filename) {
            return strtolower($this->getFileExtension($filename)) === 'xml';
        };
        $files = $this->zipper->decompress($content, $filter);

        return count($files) === 0 ? '' : $files[0]['content'];
    }

    private function getFileExtension($filename)
    {
        $lastDotPos = strrpos($filename, '.');
        if (!$lastDotPos) {
            return '';
        }

        return substr($filename, $lastDotPos + 1);
    }
}
