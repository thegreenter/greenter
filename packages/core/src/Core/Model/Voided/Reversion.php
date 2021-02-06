<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 04:20 PM.
 */

declare(strict_types=1);

namespace Greenter\Model\Voided;

/**
 * Class Reversion.
 */
class Reversion extends Voided
{
    /**
     * Get Id Xml.
     *
     * @return string
     */
    public function getXmlId(): string
    {
        $fecComunicacionPe = $this->getDateWithTimezone($this->fecComunicacion);
        $parts = [
            'RR',
            $fecComunicacionPe->format('Ymd'),
            $this->correlativo,
        ];

        return join('-', $parts);
    }
}
