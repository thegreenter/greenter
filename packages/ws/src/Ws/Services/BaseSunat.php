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
    private $compressor;

    /**
     * @var DecompressInterface|null
     */
    private $decompressor;

    /**
     * @var CdrReaderInterface|null
     */
    private $cdrReader;

    /**
     * Propiedades públicas anteriores (compressor, decompressor, cdrReader).
     */
    private const DEPRECATED_PROPERTIES = [
        'compressor' => 'setCompressor',
        'decompressor' => 'setDecompressor',
        'cdrReader' => 'setCdrReader',
    ];

    /**
     * Compresión del XML a enviar (por defecto ZipFly).
     *
     * @return $this
     */
    public function setCompressor(?CompressInterface $compressor)
    {
        $this->compressor = $compressor;

        return $this;
    }

    /**
     * Descompresión del CDR recibido (por defecto ZipFly).
     *
     * @return $this
     */
    public function setDecompressor(?DecompressInterface $decompressor)
    {
        $this->decompressor = $decompressor;

        return $this;
    }

    /**
     * Lectura del CDR (por defecto DomCdrReader).
     *
     * @return $this
     */
    public function setCdrReader(?CdrReaderInterface $cdrReader)
    {
        $this->cdrReader = $cdrReader;

        return $this;
    }

    /**
     * @deprecated desde 5.5, se elimina en 6.0: acceso a las propiedades públicas compressor, decompressor
     *             y cdrReader, usar setCompressor(), setDecompressor() y setCdrReader().
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        if (!$this->isDeprecatedProperty($name)) {
            trigger_error(sprintf('Undefined property: %s::$%s', static::class, $name), E_USER_WARNING);

            return null;
        }

        return $this->{$name};
    }

    /**
     * @deprecated desde 5.5, se elimina en 6.0: usar setCompressor(), setDecompressor() y setCdrReader().
     *
     * @param mixed $value
     */
    public function __set(string $name, $value): void
    {
        if (!$this->isDeprecatedProperty($name)) {
            // Propiedad dinámica, igual que sin __set
            $this->{$name} = $value;

            return;
        }

        $this->{self::DEPRECATED_PROPERTIES[$name]}($value);
    }

    /**
     * @deprecated desde 5.5, se elimina en 6.0.
     */
    public function __isset(string $name): bool
    {
        return isset(self::DEPRECATED_PROPERTIES[$name]) && isset($this->{$name});
    }

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
        if ($this->isUnauthorizedFault($fault)) {
            $error = $this->getErrorByCode(CustomErrorCodes::UNAUTHORIZED_CODE);

            return empty($error->getMessage()) ? $error->setMessage(CustomErrorCodes::UNAUTHORIZED_MSG) : $error;
        }

        $error = $this->getErrorByCode($fault->faultcode, $fault->faultstring);

        if (empty($error->getMessage())) {
            $detail = isset($fault->detail) ? ' | '.json_encode($fault->detail) : '';
            $error->setMessage($fault->faultstring.$detail);
        }

        return $error;
    }

    /**
     * \SoapClient convierte un HTTP 401 sin sobre SOAP en SoapFault('HTTP', 'Unauthorized').
     *
     * @param SoapFault $fault
     *
     * @return bool
     */
    private function isUnauthorizedFault(SoapFault $fault): bool
    {
        return 'HTTP' === $fault->faultcode
            && 0 === strcasecmp(trim($fault->faultstring), 'Unauthorized');
    }

    /**
     * @param string|null $code
     * @param string|null $optional intenta obtener el codigo de este parametro sino $codigo no es válido
     *
     * @return Error
     */
    protected function getErrorByCode(?string $code, ?string $optional = ''): Error
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
     * @param string|null $filename
     * @param string|null $xml
     *
     * @return null|string
     */
    protected function compress(?string $filename, ?string $xml): ?string
    {
        if (!$this->compressor) {
            $this->compressor = new ZipFly();
        }

        return $this->compressor->compress($filename, $xml);
    }

    /**
     * @param string|null $zipContent
     *
     * @return CdrResponse|null
     */
    protected function extractResponse(?string $zipContent): ?CdrResponse
    {
        if (!$this->cdrReader) {
            $this->cdrReader = new DomCdrReader(new XmlReader());
        }

        $xml = $this->getXmlResponse($zipContent);

        return $this->cdrReader->getCdrResponse($xml);
    }

    /**
     * @param string|null $code
     *
     * @return null|string
     */
    protected function getMessageError(?string $code): ?string
    {
        if ($this->codeProvider === null) {
            return '';
        }

        return $this->codeProvider->getValue($code);
    }

    protected function isExceptionCode(int $code): bool
    {
        return $code >= 100 && $code <= 1999;
    }

    /**
     * @param BillResult $result
     * @param string|null $code
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

    private function isDeprecatedProperty(string $name): bool
    {
        if (!isset(self::DEPRECATED_PROPERTIES[$name])) {
            return false;
        }

        @trigger_error(sprintf('La propiedad pública "%s::$%s" está deprecada desde greenter/ws 5.5 y se elimina en 6.0, usar "%s()".', self::class, $name, self::DEPRECATED_PROPERTIES[$name]), E_USER_DEPRECATED);

        return true;
    }

    private function getXmlResponse(?string $content)
    {
        if (!$this->decompressor) {
            $this->decompressor = new ZipDecompressDecorator(new ZipFly());
        }

        $filter = function (?string $filename) {
            return 'xml' === strtolower($this->getFileExtension($filename));
        };
        $files = $this->decompressor->decompress($content, $filter);

        return 0 === count($files) ? '' : $files[0]['content'];
    }

    private function getFileExtension(?string $filename)
    {
        $lastDotPos = strrpos($filename, '.');
        if (!$lastDotPos) {
            return '';
        }

        return substr($filename, $lastDotPos + 1);
    }
}
