# WebServices - Greenter

[![src greenter](https://img.shields.io/badge/src-greenter-brightgreen.svg)](https://github.com/thegreenter/greenter)
    
Conexión con los servicios web de SUNAT.

## Instalar
```bash
composer require greenter/ws
```

## Ejemplos

### SendBill
Envío de facturas.

```php
<?php
use Greenter\Ws\Services\SoapClient;
use Greenter\Ws\Services\BillSender;

$urlService = 'https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService';
$soap = new SoapClient($urlService);
$soap->setCredentials('20000000001MODDATOS', 'moddatos'); // usuario = ruc + usuario sol
$sender = new BillSender();
$sender->setClient($soap);

$xml = file_get_contents('factura.xml');
$result = $sender->send('20000000001-01-F001-1', $xml);

print_r($result);
```
> El mismo ejemplo sirve para envio de guia de remision, retencion o percepcion; solo 
se debe cambiar la url del servicio.

## Conexiones Disponibles

### Beta

| Servicio               | Ruta                                                                            |
|------------------------|---------------------------------------------------------------------------------|
| Factura                | https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl               |
| Guia                   | https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService?wsdl      |
| Retención y Percepción | https://e-beta.sunat.gob.pe/ol-ti-itemision-otroscpe-gem-beta/billService?wsdl  |

### Producción

| Servicio               | Ruta                                                                            |
|------------------------|---------------------------------------------------------------------------------|
| Factura                | https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService?wsdl                 |
| Guia                   | https://e-guiaremision.sunat.gob.pe/ol-ti-itemision-guia-gem/billService?wsdl   |
| Retención y Percepción | https://e-factura.sunat.gob.pe/ol-ti-itemision-otroscpe-gem/billService?wsdl    |
| Consulta CDR           | https://e-factura.sunat.gob.pe/ol-it-wsconscpegem/billConsultService?wsdl       |
