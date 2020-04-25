# XML - Greenter

[![src greenter](https://img.shields.io/badge/src-greenter-brightgreen.svg)](https://github.com/thegreenter/greenter)
  
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
