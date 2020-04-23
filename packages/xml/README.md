# XML - Greenter

[![Travis-CI](https://img.shields.io/travis/giansalex/greenter-xml.svg?branch=master&style=flat-square)](https://travis-ci.org/giansalex/greenter-xml)
[![Coverage Status](https://img.shields.io/coveralls/giansalex/greenter-xml.svg?style=flat-square&branch=master)](https://coveralls.io/github/giansalex/greenter-xml?branch=master)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/bc6f0b348aec4b5db956815ccbc32daa)](https://www.codacy.com/app/giansalex/greenter-xml?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=giansalex/greenter-xml&amp;utm_campaign=Badge_Grade)  
Generador de XML basados en el estandar UBL v2.0, v2.1 para la eleaboración de comprobantes electrónicos según normativa de SUNAT. Esta libreria forma parte de [Greenter](https://github.com/thegreenter/greenter)

# Install
```bash
composer require greenter/xml
```

### Lista de Comprobantes.

Comprobante                 |  UBL 2.0           | UBL 2.1            |
----------------------------|:------------------:|:------------------:|
Factura Electrónica         | :white_check_mark: | :white_check_mark: |
Boleta Electrónica          | :white_check_mark: | :white_check_mark: |
Nota de Crédito Electrónica | :white_check_mark: | :white_check_mark: |
Nota de Débito Electrónica  | :white_check_mark: | :white_check_mark: |
Resumen Diario de Boletas   | :white_check_mark: |                    |
Comunicación de Bajas       | :white_check_mark: |                    |
Guia Remisión Electrónica   |                    | :white_check_mark: |
Retención Electrónica       | :white_check_mark: |                    |
Percepción Electrónica      | :white_check_mark: |                    |
Resumen de Reversiones      | :white_check_mark: |                    |

## Example

```php
use Greenter\Xml\Builder\InvoiceBuilder;

$invoice = createInvoice(); // create a custom new Invoice()

$builder = new InvoiceBuilder();
$xml = $builder->build($invoice);

echo $xml;
```

## Reference
- [Ubl 2.0](http://www.datypic.com/sc/ubl20/)
- [Ubl 2.1](http://www.datypic.com/sc/ubl21/)
