# Factura Exonerada

> Las lineas resaltadas son propias de este modelo de factura.

## Código

```php hl_lines="17 33"
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
    ->setMtoOperExoneradas(200)
    ->setMtoIGV(0)
    ->setTotalImpuestos(0)
    ->setValorVenta(200)
    ->setMtoImpVenta(200);

$detail = new SaleDetail();
$detail->setCodProducto('P001')
    ->setUnidad('NIU')
    ->setDescripcion('PROD 1')
    ->setCantidad(2)
    ->setMtoValorUnitario(100)
    ->setMtoValorVenta(200)
    ->setMtoBaseIgv(200)
    ->setPorcentajeIgv(18)
    ->setIgv(0)
    ->setTipAfeIgv('20')
    ->setTotalImpuestos(0)
    ->setMtoPrecioUnitario(100)
;

$invoice->setDetails([$detail])
    ->setLegends([
        (new Legend())
            ->setCode('1000')
            ->setValue('SON DOSCIENTOS CON OO/100 SOLES')
    ]);
```