<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 23:13.
 */

declare(strict_types=1);

namespace Greenter\Ws\Services;

use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\CdrResponse;
use Greenter\Model\Response\Error;
use Greenter\Validator\ErrorCodeProviderInterface;
use Greenter\Ws\Reader\CdrReaderInterface;
use Greenter\Ws\Reader\DomCdrReader;
use Greenter\Ws\Reader\XmlReader;
use Greenter\Zip\CompressInterface;
use Greenter\Zip\DecompressInterface;
use Greenter\Zip\ZipDecompressDecorator;
use Greenter\Zip\ZipFly;
use SoapFault;

/**
 * Class BaseSunat.
 */
class BaseSunat
{
    const NUMBER_PATTERN = '/[^0-9]+/';

    /**
     * @var WsClientInterface
     */
    private $client;

    /**
     * @var ErrorCodeProviderInterface|null
     */
    private $codeProvider;

    /**
     * @var CompressInterface|null
     */
    public $compressor;

    /**
     * @var DecompressInterface|null
     */
    public $decompressor;

    /**
     * @var CdrReaderInterface|null
     */
    public $cdrReader;

    /**
     * @param ErrorCodeProviderInterface|null $codeProvider
     */
    public function setCodeProvider(?ErrorCodeProviderInterface $codeProvider)
    {
        $this->codeProvider = $codeProvider;
    }

    /**
     * @return WsClientInterface
     */
    public function getClient(): WsClientInterface
    {
        return $this->client;
    }

    /**
     * @param WsClientInterface $client
     *
     * @return BaseSunat
     */
    public function setClient(WsClientInterface $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get error from Fault Exception.
     *
     * @param SoapFault $fault
     *
     * @return Error
     */
    protected function getErrorFromFault(SoapFault $fault)
    {
        $error = $this->getErrorByCode($fault->faultcode, $fault->faultstring);

        if (empty($error->getMessage())) {
            $error->setMessage($fault->faultstring.(isset($fault->detail) ? ' '.$fault->detail->message : ''));
        }

        return $error;
    }

    /**
     * @param string $code
     * @param string $optional intenta obtener el codigo de este parametro sino $codigo no es válido
     *
     * @return Error
     */
    protected function getErrorByCode($code, $optional = '')
    {
        $error = new Error($code);
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
     * @return null|string
     */
    protected function compress($filename, $xml): ?string
    {
        if (!$this->compressor) {
            $this->compressor = new ZipFly();
        }

        return $this->compressor->compress($filename, $xml);
    }

    /**
     * @param string $zipContent
     *
     * @return CdrResponse|null
     */
    protected function extractResponse($zipContent): ?CdrResponse
    {
        if (!$this->cdrReader) {
            $this->cdrReader = new DomCdrReader(new XmlReader());
        }

        $xml = $this->getXmlResponse($zipContent);

        return $this->cdrReader->getCdrResponse($xml);
    }

    /**
     * @param string $code
     *
     * @return null|string
     */
    protected function getMessageError($code): ?string
    {
        if ($this->codeProvider === null) {
            return '';
        }

        return $this->codeProvider->getValue($code);
    }

    protected function isExceptionCode($code): bool
    {
        $value = (int)$code;

        return $value >= 100 && $value <= 1999;
    }

    /**
     * @param null|string $code
     */
    protected function loadErrorByCode(BillResult $result, ?string $code): void
    {
        $error = $this->getErrorByCode($code);

        if (empty($error->getMessage()) && $result->getCdrResponse()) {
            $error->setMessage($result->getCdrResponse()->getDescription());
        }

        $result
            ->setSuccess(false)
            ->setError($error);
    }

    private function getXmlResponse(?string $content)
    {
        if (!$this->decompressor) {
            $this->decompressor = new ZipDecompressDecorator(new ZipFly());
        }

        $filter = function ($filename) {
            return 'xml' === strtolower($this->getFileExtension($filename));
        };
        $files = $this->decompressor->decompress($content, $filter);

        return 0 === count($files) ? '' : $files[0]['content'];
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
