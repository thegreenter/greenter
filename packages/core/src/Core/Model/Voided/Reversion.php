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
        $parts = [
            'RR',
            $this->getFecComunicacion()->format('Ymd'),
            $this->getCorrelativo(),
        ];

        return join('-', $parts);
    }
}
