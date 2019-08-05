# Factura con ICBPER

> Las lineas resaltadas son propias de este modelo de factura.

## Código

```php hl_lines="19 51 52"
<?php
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;

$invoice = new Invoice();
$invoice->setFecVencimiento(new \DateTime())
    ->setUblVersion('2.1')
    ->setTipoOperacion('0101')
    ->setTipoDoc('01')
    ->setSerie('F001')
    ->setCorrelativo('123')
    ->setFechaEmision(new \DateTime())
    ->setTipoMoneda('PEN')
    ->setClient($this->getClient())
    ->setCompany($this->getCompany())
    ->setMtoOperGravadas(200.20)
    ->setMtoIGV(36.24)
    ->setIcbper(0.40)
    ->setTotalImpuestos(36.64)
    ->setMtoImpVenta(236.64);

    $detail = new SaleDetail();
    $detail
        ->setCodProducto('P001')
        ->setUnidad('NIU')
        ->setCantidad(2)
        ->setDescripcion('PRODUCTO 1')
        ->setMtoBaseIgv(200.00)
        ->setPorcentajeIgv(18.0)
        ->setIgv(36)
        ->setTotalImpuestos(36)
        ->setTipAfeIgv('10')
        ->setMtoValorVenta(200)
        ->setMtoValorUnitario(100)
        ->setMtoPrecioUnitario(118);
    
    $bolsa = new SaleDetail();
    $bolsa
        ->setCodProducto('P002')
        ->setUnidad('NIU')
        ->setCantidad(4)
        ->setDescripcion('BOLSA DE PLASTICO')
        ->setMtoValorUnitario(0.05)
        ->setMtoPrecioUnitario(0.059)
        ->setMtoValorVenta(0.20)
        ->setTipAfeIgv('10')
        ->setMtoBaseIgv(0.20)
        ->setPorcentajeIgv(18.0)
        ->setIgv(0.24)
        ->setIcbper(0.40) // (cantidad)*(factor ICBPER)
        ->setFactorIcbper(0.10)
        ->setTotalImpuestos(0.64)
    ;

$invoice->setDetails([$detail, $bolsa])
    ->setLegends([
        (new Legend())
            ->setCode('1000')
            ->setValue('SON DOSCIENTOS TREINTA Y SEIS CON 64/100 SOLES')
    ]);
```


## Monto ICBPER

La cuantía del impuesto al consumo de las bolsas de plástico es gradual y se aplica por la adquisición unitaria de bolsas de plástico, de acuerdo con el siguiente cronograma: 

Monto   | Año   |
--------|-------|
S/ 0.10 | 2019  |
S/ 0.20 | 2020  |
S/ 0.30 | 2021  |
S/ 0.40 | 2022  |
S/ 0.50 | 2023+ |
