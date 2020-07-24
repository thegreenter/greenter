<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 21/07/2017
 * Time: 23:20.
 */

declare(strict_types=1);

namespace Greenter\Model\Response;

/**
 * Class StatusResult.
 */
class StatusResult extends BillResult
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
     * @return string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return $this
     */
    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
