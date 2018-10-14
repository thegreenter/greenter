# Factura con Detracciones

> Las lineas resaltadas son propias de este modelo de factura.

## Código

```php hl_lines="10 25 26 27 28 29 30 31 32 56 57"
<?php
use Greenter\Model\Sale\Detraction;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Sale\SaleDetail;

$invoice = new Invoice();
$invoice
    ->setUblVersion('2.1')
    ->setTipoOperacion('1001') // detracción
    ->setTipoDoc('01')
    ->setSerie('F001')
    ->setCorrelativo('123')
    ->setFechaEmision(new \DateTime())
    ->setTipoMoneda('PEN')
    ->setClient($this->getClient())
    ->setCompany($this->getCompany())
    ->setMtoOperGravadas(200)
    ->setMtoIGV(36)
    ->setValorVenta(200)
    ->setTotalImpuestos(36)
    ->setMtoImpVenta(236)
    ->setDetraccion(
    // MONEDA SIEMPRE EN SOLES
        (new Detraction())
            // Carnes y despojos comestibles
            ->setCodBienDetraccion('014') // catalog. 54
            // Deposito en cuenta
            ->setCodMedioPago('001') // catalog. 59
            ->setCtaBanco('0004-3342343243')
            ->setPercent(4.00)
            ->setMount(9.44)
    );

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
            ->setCode('2006')
            ->setValue('Operación sujeta a detracción')
    ]);
```