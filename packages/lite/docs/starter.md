# Empezando con Greenter

Después de [instalar greenter](https://giansalex.github.io/greenter/#install) podrá empezar a emitir comprobantes electrónicos.

## Requerimientos
- Certificado en formato PEM
- Credenciales Clave SOL

## Configuración
Para propósitos de prueba, descargaremos este [certificado](https://raw.githubusercontent.com/giansalex/xmldsig/master/tests/certificate.pem) y utilizaremos las
credenciales por defecto, user `20000000001MODDATOS`, password `moddatos`.

!!! info "Certificado .PFX"

    Si cuenta con un certificado .PFX, para convertirlo a formato .PEM necesita
    la clave y seguir el siguiente [ejemplo](https://github.com/giansalex/xmldsig/blob/master/CONVERT.md#convert-to-pem)
    
Crearemos el archivo `config.php` y agregaremos lo siguiente:
```php
<?php
use Greenter\Ws\Services\SunatEndpoints;

$see = new \Greenter\See();
$see->setService(SunatEndpoints::FE_BETA);
$see->setCertificate(file_get_contents(__DIR__.'/certificate.pem'));
$see->setCredentials('20000000001MODDATOS', 'moddatos');

return $see;
```

## Factura Electrónica

Elaboraremos nuestra primera factura electrónica, para ello creamos el archivo `factura.php` y agregaremos el siguiente código:
```php hl_lines="68"
<?php
use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Ws\Services\SunatEndpoints;

require __DIR__.'/vendor/autoload.php';

$see = require __DIR__.'/config.php';

// Cliente
$client = new Client();
$client->setTipoDoc('6')
    ->setNumDoc('20000000001')
    ->setRznSocial('EMPRESA 1');

// Emisor
$address = new Address();
$address->setUbigueo('150101')
    ->setDepartamento('LIMA')
    ->setProvincia('LIMA')
    ->setDistrito('LIMA')
    ->setUrbanizacion('NONE')
    ->setDireccion('AV LS');

$company = new Company();
$company->setRuc('20000000001')
    ->setRazonSocial('EMPRESA SAC')
    ->setNombreComercial('EMPRESA')
    ->setAddress($address);

// Venta
$invoice = (new Invoice())
    ->setTipoDoc('01')
    ->setSerie('F001')
    ->setCorrelativo('1')
    ->setFechaEmision(new DateTime())
    ->setTipoMoneda('PEN')
    ->setClient($client)
    ->setMtoOperGravadas(200.00)
    ->setMtoOperExoneradas(0.00)
    ->setMtoOperInafectas(0.00)
    ->setMtoIGV(36.00)
    ->setMtoImpVenta(2236.00)
    ->setCompany($company);

$item = (new SaleDetail())
    ->setCodProducto('P001')
    ->setUnidad('NIU')
    ->setCantidad(2)
    ->setDescripcion('PRODUCTO 1')
    ->setIgv(18.00)
    ->setTipAfeIgv('10')
    ->setMtoValorVenta(100.00)
    ->setMtoValorUnitario(50.00)
    ->setMtoPrecioUnitario(56.00);

$legend = (new Legend())
    ->setCode('1000')
    ->setValue('SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES');

$invoice->setDetails([$item])
        ->setLegends([$legend]);
        
$result = $see->send($invoice);

if ($result->isSuccess()) {
    echo $result->getCdrResponse()->getDescription();
} else {
    var_dump($result->getError());
}
```

Estructura del proyecto

```text
/
├── vendor/
├── certificate.pem
├── composer.json
├── config.php
├── factura.php

```

## Ejecutar
Finalmente invocaremos el script desde la linea de comandos (cmd, bash).
```bash
php factura.php
```
y si todo sale bien obtendremos como respuesta.
```bash
La Factura numero F001-1, ha sido aceptada
```

El código fuente puede encontrarlo en este [enlace](https://github.com/giansalex/greenter-fiststeps).

[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WSYJNMDD6D79W)