<?php
/**
 * Created by PhpStorm.
 * User: Soporte
 * Date: 11/10/2018
 * Time: 16:40
 */

namespace Greenter\Xml\Filter;

/**
 * Class TributoFunction
 * @internal
 */
class TributoFunction
{
    private static $tributos = [
        '1000' => ['VAT', 'IGV'],
        '1016' => ['VAT', 'IVAP'],
        '2000' => ['EXC', 'ISC'],
        '9995' => ['FRE', 'EXP'],
        '9996' => ['FRE', 'GRA'],
        '9997' => ['VAT', 'EXO'],
        '9998' => ['FRE', 'INA'],
        '9999' => ['OTH', 'OTROS'],
    ];

    public static function getByTributo(?string $code)
    {
        if (isset(self::$tributos[$code])) {
            $values = self::$tributos[$code];
            return [
              'id' => $code,
              'code' => $values[0],
              'name' => $values[1],
            ];
        }

        return null;
    }

    public static function getByAfectacion($afectacion)
    {
        $code = self::getCode($afectacion);

        return self::getByTributo($code);
    }

    private static function getCode($afectacion): string
    {
        $value = (int)$afectacion;

        switch ($value) {
            case 10: return '1000';
            case 17: return '1016';
            case 20: return '9997';
            case 30: return '9998';
            case 40: return '9995';
            default: return '9996';
        }
    }
}