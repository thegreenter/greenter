# XML - Greenter

[![Travis-CI](https://img.shields.io/travis/giansalex/greenter-xml.svg?label=build&branch=master&style=flat-square)](https://travis-ci.org/giansalex/greenter-xml)
[![Coverage Status](https://img.shields.io/coveralls/giansalex/greenter-xml.svg?label=coveralls&style=flat-square&branch=master)](https://coveralls.io/github/giansalex/greenter-xml?branch=master)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/bc6f0b348aec4b5db956815ccbc32daa)](https://www.codacy.com/app/giansalex/greenter-xml?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=giansalex/greenter-xml&amp;utm_campaign=Badge_Grade)  
Construcción de XML basados en el estandar UBL v2.0

# Install
```bash
composer require greenter/xml
```

### Documentos Soportados.

* Factura Electrónica
* Boleta Electrónica
* Nota de Crédito Electrónica
* Nota de Débito Electrónica
* Resumen Diario de Boletas (v1, v2)
* Comunicación de Bajas
* Guia Remisión Electrónica
* Retención Electrónica
* Percepción Electrónica
* Resumen de Reversiones

## Example

```php
use Greenter\Xml\Builder\InvoiceBuilder;

$invoice = crateInvoice();

$builder = new InvoiceBuilder();
$xml = $builder->build($invoice);

echo $xml;
```