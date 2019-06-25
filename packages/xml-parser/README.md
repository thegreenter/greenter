# XML Parser - Greenter

[![Travis-CI](https://img.shields.io/travis/giansalex/greenter-xml-parser.svg?branch=master&style=flat-square)](https://travis-ci.org/giansalex/greenter-xml-parser)
[![Packagist](https://img.shields.io/packagist/v/greenter/xml-parser.svg?style=flat-square)](https://packagist.org/packages/greenter/xml-parser)

Convierte XML a clases PHP definidas en [Greenter](https://github.com/giansalex/greenter).

# Instalar
Via composer desde [packagist.org](https://packagist.org/packages/greenter/xml-parser)

```bash
composer require greenter/xml-parser
```

## Ejemplo
```php
use Greenter\Xml\Parser\InvoiceParser;
require 'vendor/autoload.php';

$parser = new InvoiceParser();
$xml = file_get_contents('20000000001-01-F001-1.xml');
$invoice = $parser->parse($xml); // get an invoice.

var_dump($invoice);
```

# Documentos Soportados

- Factura Electrónica (UBL 2.0)
- Boleta Electrónica (UBL 2.0)
- Nota de Crédito Electrónica (UBL 2.0)
- Nota de Débito Electrónica (UBL 2.0)
- Recibo por Honorarios Electrónico (UBL 2.0)
- Guia de Remisión Electrónica (UBL 2.0)
- Retencion Electrónica (UBL 2.0)
- Percepcion Electrónica (UBL 2.0)
- Comunicacion de Baja (UBL 2.0)
- Resumen Diario de Boletas (UBL 2.0)
