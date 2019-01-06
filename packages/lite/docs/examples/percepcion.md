# Factura con Percepción

> Las lineas resaltadas son propias de este modelo de factura.

## Código

```php hl_lines="9 22 23 24 25 26 27 49 50"
<?php
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\SalePerception;

$invoice = new Invoice();
$invoice->setUblVersion('2.1')
    ->setTipoOperacion('2001') // Percepciones
    ->setTipoDoc('01')
    ->setSerie('F001')
    ->setCorrelativo('123')
    ->setFechaEmision(new \DateTime())
    ->setTipoMoneda('PEN')
    ->setClient($this->getClient())
    ->setCompany($this->getCompany())
    ->setMtoOperGravadas(200)
    ->setMtoIGV(36)
    ->setTotalImpuestos(36)
    ->setValorVenta(200)
    ->setMtoImpVenta(236)
    ->setPerception((new SalePerception())
        ->setCodReg('51')
        ->setPorcentaje(0.02)
        ->setMtoBase(200)
        ->setMto(4.00)
        ->setMtoTotal(204.00));
$detail = new SaleDetail();
$detail->setCodProducto('P001')
    ->setUnidad('NIU')
    ->setDescripcion('PROD 1')
    ->setCantidad(2)
    ->setMtoValorUnitario(100)
    ->setMtoValorVenta(200)
    ->setMtoBaseIgv(200)
    ->setPorcentajeIgv(18)
    ->setIgv(36)
    ->setTipAfeIgv('10')
    ->setTotalImpuestos(36)
    ->setMtoPrecioUnitario(118)
;

$invoice->setDetails([$detail])
    ->setLegends([
        (new Legend())
            ->setCode('1000')
            ->setValue('SON DOSCIENTOS TREINTA Y SEIS CON OO/100 SOLES'),
        (new Legend())
            ->setCode('2000')
            ->setValue('COMPROBANTE DE PERCEPCIÓN')
    ]);
```
