# HTML Report - Greenter
[![src greenter](https://img.shields.io/badge/src-greenter-brightgreen.svg)](https://github.com/thegreenter/greenter)  

Representación en formato HTML del comprobante electrónico empleado en la facturación electrónica - SUNAT - Perú.
> Para generar el PDF puede utilizar [wkhtmltopdf](https://wkhtmltopdf.org/) y/o [greenter/htmltopdf](https://github.com/thegreenter/htmltopdf).

## Install
Via Composer desde [packagist.org](https://packagist.org/packages/greenter/report)
```bash
composer require greenter/report
```

## Example
```php
$invoice = new Invoice();
// $invoice->set...

$report = new HtmlReport();

$report->setTemplate('invoice.html.twig');

$html = $report->render($invoice, [
    'system' => [
        'logo' => $logo,
        'hash' => 'qqnr2dN4p/HmaEA/CJuVGo7dv5g=',
    ],
    'user' => [
        'header' => 'Telf: <b>(056) 123375</b>',
        'resolucion' => '212321',
    ]
]);

echo $html;
```

## Preview

![Factura](docs/factura.png)

## Documents
- [x] Factura Electrónica  
- [x] Boleta Electrónica  
- [x] Nota de Crédito Electrónica  
- [x] Nota de Débito Electrónica  
- [x] Guía de Remisión Electrónica  
- [x] Retención Electrónica  
- [x] Percepción Electrónica
- [x] Resumen diario de Boletas
- [x] Comunicación de Bajas
- [x] Resumen diario de Reversiones

## Features
- Generación de Codigo QR
- Logo (PNG, JPEG, GIF)
- Obteneción del Hash de la firma digital
- Agregar cabecera y pie de pagina personalizado
- Agregar datos extras al comprobante
- Crear nuevas plantillas según sus propios requerimientos
