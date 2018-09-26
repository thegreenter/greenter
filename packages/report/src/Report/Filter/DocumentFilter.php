<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 12:27 PM.
 */

namespace Greenter\Report\Filter;

/**
 * Class DocumentFilter.
 */
class DocumentFilter
{
    /**
     * @var array
     */
    private $store = [
        '01' => [
            '01' => 'FACTURA',
            '03' => 'BOLETA DE VENTA',
            '07' => 'NOTA DE CRÉDITO',
            '08' => 'NOTA DE DÉBITO',
            '09' => 'GUÍA DE REMISIÓN REMITENTE',
            '20' => 'RETENCIÓN',
            '31' => 'GUÍA DE REMISIÓN TRANSPORTISTA',
            '40' => 'PERCEPCIÓN',
        ],
        '02' => [
            'PEN' => 'S/',
            'USD' => '$',
            'EUR' => '€',
        ],
        '021' => [
            'PEN' => 'SOLES',
            'USD' => 'DÓLARES AMERICANOS',
            'EUR' => 'EUROS',
        ],
        '06' => [
            '0' => 'N/D',
            '1' => 'DNI',
            '6' => 'RUC',
        ],
        '19' => [
            '1' => 'ADICIONAR',
            '2' => 'MODIFICAR',
            '3' => 'ANULADO'
        ]
    ];

    public function getValueCatalog($value, $code)
    {
        if (!isset($this->store[$code])) {
            return '';
        }

        $items = $this->store[$code];

        return isset($items[$value]) ? $items[$value] : '';
    }
}
