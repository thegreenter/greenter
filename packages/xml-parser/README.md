XML Parser - Greenter
======================
[![Travis-CI](https://img.shields.io/travis/giansalex/greenter-xml-parser.svg?branch=master&style=flat-square)](https://travis-ci.org/giansalex/greenter-xml-parser)
[![Packagist](https://img.shields.io/packagist/v/greenter/xml-parser.svg?style=flat-square)](https://packagist.org/packages/greenter/xml-parser)

XML Parsers for [Greenter](https://github.com/giansalex/greenter).

# Install
Via composer from [packagist.org](https://packagist.org/packages/greenter/xml-parser)

```bash
composer require greenter/xml-parser
```

## Example
```php
use Greenter\Xml\Parser\InvoiceParser;
require 'vendor/autoload.php';

$parser = new InvoiceParser();
$xml = file_get_contents('20000000001-01-F001-1.xml');
$invoice = $parser->parse($xml); // get an invoice.

var_dump($invoice);
```
Other parsers on [api documentation](https://codedoc.pub/giansalex/greenter-xml-parser/master/index.html).

# Supported Documents

- Factura Electrónica
- Boleta Electrónica
- Nota de Crédito Electrónica
- Nota de Débito Electrónica
- Recibo por Honorarios Electrónico
- Guia de Remisión Electrónica
- Retencion Electrónica
- Percepcion Electrónica
- Comunicacion de Baja
- Resumen Diario de Boletas
