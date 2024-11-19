<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 12:27 PM.
 */

declare(strict_types=1);

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
        '18' => [
            '01' => 'PÚBLICO',
            '02' => 'PRIVADO'
        ],
        '19' => [
            '1' => 'ADICIONAR',
            '2' => 'MODIFICAR',
            '3' => 'ANULADO'
        ],
        '20' => [
            '01' => 'Venta',
            '02' => 'Compra',
            '04' => 'Traslado entre establecimientos de la misma empresa',
            '08' => 'Importación',
            '09' => 'Exportación',
            '13' => 'Otros',
            '14' => 'Venta sujeta a confirmación del comprador',
            '18' => 'Traslado emisor itinerante CP',
            '19' => 'Traslado a zona primaria'
        ],
        '54' => [
            '001' => 'Azúcar y melaza de caña',
            '002' => 'Arroz',
            '003' => 'Alcohol etílico',
            '004' => 'Recursos hidrobiológicos',
            '005' => 'Maíz amarillo duro',
            '007' => 'Caña de azúcar',
            '008' => 'Madera',
            '009' => 'Arena y piedra.',
            '010' => 'Residuos, subproductos, desechos, recortes, desperdicios y formas primarias derivadas de los mismos',
            '011' => 'Bienes gravados con el IGV por renuncia a la exoneración',
            '012' => 'Intermediación laboral y tercerización',
            '013' => 'Animales vivos',
            '014' => 'Carnes y despojos comestibles',
            '015' => 'Abonos, cueros y pieles de origen animal',
            '016' => 'Aceite de pescado',
            '017' => 'Harina, polvo y “pellets” de pescado, crustáceos, moluscos y demás invertebrados acuáticos',
            '019' => 'Arrendamiento de bienes',
            '020' => 'Mantenimiento y reparación de bienes muebles',
            '021' => 'Movimiento de carga',
            '022' => 'Otros servicios empresariales',
            '023' => 'Leche',
            '024' => 'Comisión mercantil',
            '025' => 'Fabricación de bienes por encargo',
            '026' => 'Servicio de transporte de personas',
            '027' => 'Servicio de transporte de carga',
            '028' => 'Transporte de pasajeros',
            '030' => 'Contratos de construcción',
            '031' => 'Oro gravado con el IGV',
            '032' => 'Páprika y otros frutos de los generos capsicum o pimienta',
            '034' => 'Minerales metálicos no auríferos',
            '035' => 'Bienes exonerados del IGV',
            '036' => 'Oro y demás minerales metálicos exonerados del IGV',
            '037' => 'Demás servicios gravados con el IGV',
            '039' => 'Minerales no metálicos',
            '040' => 'Bien inmueble gravado con IGV',
            '041' => 'Plomo',
            '099' => 'Ley 30737'
        ],
        '59' => [
            '001' => 'Depósito en cuenta',
            '002' => 'Giro',
            '003' => 'Transferencia de fondos',
            '004' => 'Orden de pago',
            '005' => 'Tarjeta de débito',
            '006' => 'Tarjeta de crédito emitida en el país por una empresa del sistema financiero',
            '007' => 'Cheques con la cláusula de "NO NEGOCIABLE", "INTRANSFERIBLES", "NO A LA ORDEN" u otra equivalente, a que se refiere el inciso g) del artículo 5° de la ley',
            '008' => 'Efectivo, por operaciones en las que no existe obligación de utilizar medio de pago',
            '009' => 'Efectivo, en los demás casos',
            '010' => 'Medios de pago usados en comercio exterior',
            '011' => 'Documentos emitidos por las EDPYMES y las cooperativas de ahorro y crédito no autorizadas a captar depósitos del público',
            '012' => 'Tarjeta de crédito emitida en el país o en el exterior por una empresa no perteneciente al sistema financiero, cuyo objeto principal sea la emisión y administración de tarjetas de crédito',
            '013' => 'Tarjetas de crédito emitidas en el exterior por empresas bancarias o financieras no domiciliadas',
            '101' => 'Transferencias - Comercio exterior',
            '102' => 'Cheques bancarios - Comercio exterior',
            '103' => 'Orden de pago simple - Comercio exterior',
            '104' => 'Orden de pago documentario - Comercio exterior',
            '105' => 'Remesa simple - Comercio exterior',
            '106' => 'Remesa documentaria - Comercio exterior',
            '107' => 'Carta de crédito simple - Comercio exterior',
            '108' => 'Carta de crédito documentario - Comercio exterior',
            '999' => 'Otros medios de pago'
        ]
    ];

    public function getValueCatalog($value, $code): ?string
    {
        return $this->store[$code][$value] ?? '';
    }
}
