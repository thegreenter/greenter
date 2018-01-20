<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 12:27 PM.
 */

namespace Greenter\Report\Filter;

use Greenter\Model\Sale\Legend;

class DocumentFilter
{
    public function getNameDoc($tipo)
    {
        switch (trim($tipo)) {
            case '01': return 'FACTURA';
            case '03': return 'BOLETA';
            case '07': return 'NOTA DE CRÉDITO';
            case '08': return 'NOTA DE DÉBITO';
            case '09': return 'GUÍA DE REMISIÓN';
            case '20': return 'RETENCIÓN';
            case '40': return 'PERCEPCIÓN';
        }

        return '';
    }

    public function getSymbolCurrency($code)
    {
        switch (trim($code)) {
            case 'PEN': return 'S/';
            case 'USD': return '$';
            case 'EUR': return '€';
        }

        return $code;
    }

    public function getNameCurrency($code)
    {
        switch (trim($code)) {
            case 'PEN': return 'SOLES';
            case 'USD': return 'DÓLARES AMERICANOS';
            case 'EUR': return 'EUROS';
        }

        return $code;
    }

    public function getSymbolDocIdentidad($code)
    {
        switch (trim($code)) {
            case '1': return 'DNI';
            case '6': return 'RUC';
        }

        return '';
    }

    /**
     * @param Legend[] $legends
     * @param $code
     *
     * @return string
     */
    public function getValueCode($legends, $code)
    {
        foreach ($legends as $legend) {
            if ($legend->getCode() == $code) {
                return $legend->getValue();
            }
        }

        return '';
    }
}
