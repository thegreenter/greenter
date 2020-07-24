<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 6/11/2018
 * Time: 12:01.
 */

declare(strict_types=1);

namespace Greenter\Ws\Services;

/**
 * Class WsdlProvider.
 */
final class WsdlProvider
{
    /**
     * Get billService WSDL Local Path.
     *
     * @return string
     */
    public static function getBillPath()
    {
        return __DIR__.'/../../Resources/wsdl/billService.wsdl';
    }

    /**
     * Get billConsultService WSDL Local Path.
     *
     * @return string
     */
    public static function getConsultPath()
    {
        return __DIR__.'/../../Resources/wsdl/billConsultService.wsdl';
    }
}
