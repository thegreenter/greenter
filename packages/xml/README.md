# XML - Greenter

[![Travis-CI](https://img.shields.io/travis/giansalex/greenter-xml.svg?label=build&branch=master&style=flat-square)](https://travis-ci.org/giansalex/greenter-xml)
[![Coverage Status](https://img.shields.io/coveralls/giansalex/greenter-xml.svg?label=coveralls&style=flat-square&branch=master)](https://coveralls.io/github/giansalex/greenter-xml?branch=master)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/bc6f0b348aec4b5db956815ccbc32daa)](https://www.codacy.com/app/giansalex/greenter-xml?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=giansalex/greenter-xml&amp;utm_campaign=Badge_Grade)  
Construcción de XML basados en el estandar UBL v2.0, v2.1

# Install
```bash
composer require greenter/xml
```

### Documentos Soportados.

* Factura Electrónica v2.0
* Boleta Electrónica v2.0
* Nota de Crédito Electrónica v2.0
* Nota de Débito Electrónica v2.0
* Resumen Diario de Boletas v2.1
* Comunicación de Bajas v2.0
* Guia Remisión Electrónica v2.1
* Retención Electrónica v2.0
* Percepción Electrónica v2.0
* Resumen de Reversiones v2.0

## Example

```php
use Greenter\Xml\Builder\InvoiceBuilder;

$invoice = crateInvoice();

$builder = new InvoiceBuilder();
$xml = $builder->build($invoice);

echo $xml;
```

## Reference
- [Ubl 2.0](http://www.datypic.com/sc/ubl20/)
- [Ubl 2.1](http://www.datypic.com/sc/ubl21/)
