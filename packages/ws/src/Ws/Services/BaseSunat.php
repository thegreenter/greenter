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
use Greenter\Zip\CompressInterface;
use Greenter\Zip\DecompressInterface;
use Greenter\Zip\ZipFileDecompress;
use Greenter\Zip\ZipFly;

/**
 * Class BaseSunat.
 */
class BaseSunat
{
    const NUMBER_PATTERN = '/[^0-9]+/';

    /**
     * @var CompressInterface
     */
    private $compressor;

    /**
     * @var DecompressInterface
     */
    private $decompressor;

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
        //TODO: Inject
        $this->compressor = new ZipFly();
        $this->decompressor = new ZipFileDecompress();
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
        $error = $this->getErrorByCode($fault->faultcode, $fault->faultstring);

        if (empty($error->getMessage())) {
            $error->setMessage(isset($fault->detail) ? $fault->detail->message : $fault->faultstring);
        }

        return $error;
    }

    /**
     * @param string $code
     * @param string $optional Intenta obtener el codigo de este parametro sino $codigo no es válido.
     * @return Error
     */
    protected function getErrorByCode($code, $optional = '')
    {
        $error = new Error();
        $error->setCode($code);
        $code = preg_replace(self::NUMBER_PATTERN, '', $code);
        $message = '';

        if (empty($code) && $optional) {
            $code = preg_replace(self::NUMBER_PATTERN, '', $optional);
        }

        if ($code) {
            $message = $this->getMessageError($code);
            $error->setCode($code);
        }

        return $error->setMessage($message);
    }
    
    /**
     * @param string $filename
     * @param string $xml
     *
     * @return string
     */
    protected function compress($filename, $xml)
    {
        return $this->compressor->compress($filename, $xml);
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

    protected function isExceptionCode($code)
    {
        $value = intval($code);

        return $value >= 100 && $value <= 1999;
    }

    protected function loadErrorByCode($result, $code)
    {
        $error = $this->getErrorByCode($code);

        if (empty($error->getMessage()) && $result->getCdrResponse()) {
            $error->setMessage($result->getCdrResponse()->getDescription());
        }

        $result
            ->setSuccess(false)
            ->setError($error);
    }

    private function getXmlResponse($content)
    {
        $filter = function ($filename) {
            return strtolower($this->getFileExtension($filename)) === 'xml';
        };
        $files = $this->decompressor->decompress($content, $filter);

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
