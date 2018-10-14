# Factura con Descuentos

> Las lineas resaltadas son propias de este modelo de factura.

## Código

```php hl_lines="19 30 31 32 33 34 35 36"
<?php
use Greenter\Model\Sale\Charge;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;

$invoice = new Invoice();
$invoice->setUblVersion('2.1')
    ->setTipoOperacion('0101')
    ->setTipoDoc('01')
    ->setSerie('F001')
    ->setCorrelativo('123')
    ->setFechaEmision(new \DateTime())
    ->setTipoMoneda('PEN')
    ->setClient($this->getClient())
    ->setCompany($this->getCompany())
    ->setMtoOperGravadas(180)
    ->setMtoIGV(32.40)
    ->setMtoDescuentos(20)
    ->setTotalImpuestos(32.40)
    ->setValorVenta(180)
    ->setMtoImpVenta(212.40);

$detail = new SaleDetail();
$detail->setCodProducto('P001')
    ->setUnidad('NIU')
    ->setDescripcion('PROD 1')
    ->setCantidad(2)
    ->setMtoValorUnitario(100)
    ->setDescuentos([
        (new Charge())
            ->setCodTipo('00') // Catalog. 53
            ->setMontoBase(200)
            ->setFactor(0.10)
            ->setMonto(20)
    ])
    ->setMtoValorVenta(180)
    ->setMtoBaseIgv(180)
    ->setPorcentajeIgv(18)
    ->setIgv(32.40)
    ->setTipAfeIgv('10')
    ->setTotalImpuestos(32.40)
    ->setMtoPrecioUnitario(118)
;

$invoice->setDetails([$detail])
    ->setLegends([
        (new Legend())
            ->setCode('1000')
            ->setValue('SON DOSCIENTOS TREINTA Y SEIS CON OO/100 SOLES')
    ]);
```