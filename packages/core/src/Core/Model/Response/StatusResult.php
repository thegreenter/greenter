<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 21/07/2017
 * Time: 23:20.
 */

namespace Greenter\Model\Response;

/**
 * Class StatusResult.
 */
class StatusResult extends BaseResult
{
    /**
     * StatusCode enviado por Sunat.
     *
     * 0 = Procesó correctamente
     * 98 = En proceso
     * 99 = Proceso con errores
     *
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $cdrZip;

    /**
     * @var CdrResponse
     */
    protected $cdrResponse;

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return StatusResult
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getCdrZip()
    {
        return $this->cdrZip;
    }

    /**
     * @param string $cdrZip
     *
     * @return StatusResult
     */
    public function setCdrZip($cdrZip)
    {
        $this->cdrZip = $cdrZip;

        return $this;
    }

    /**
     * @return CdrResponse
     */
    public function getCdrResponse()
    {
        return $this->cdrResponse;
    }

    /**
     * @param CdrResponse $cdrResponse
     *
     * @return StatusResult
     */
    public function setCdrResponse($cdrResponse)
    {
        $this->cdrResponse = $cdrResponse;

        return $this;
    }
}
