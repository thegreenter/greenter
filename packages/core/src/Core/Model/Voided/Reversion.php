<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 08/08/2017
 * Time: 04:20 PM.
 */

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
    public function getXmlId()
    {
        $parts = [
            'RR',
            $this->getFecComunicacion()->format('Ymd'),
            $this->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}
