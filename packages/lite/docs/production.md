# Greenter en Producción
En esta sección de indican los pasos para convertirse en Emisor Electrónico.

!!! warning "UBL 2.1"

    Apartir de **octubre del 2018**, los nuevos emisores electrónicos estan obligados a emitir sus comprobantes
    empleando el estándar UBL 2.1 

## Pasos
- Creación de usuario secundario con los permisos para Facturación Electrónica.
- Registrar el certificado digital en el portal de SUNAT, en formato `.cer` (Public key).
- Greenter requiere el certificado digital en formato `.pem` (Private & Public Key), si tiene un certificado `.pfx`
 puede convertirlo siguiendo esta [guía](https://github.com/giansalex/xmldsig/blob/master/CONVERT.md).
- Configurar la url del servicio de Producción.

```php hl_lines="5"
<?php
use Greenter\Ws\Services\SunatEndpoints;

$see = new \Greenter\See();
$see->setService(SunatEndpoints::FE_PRODUCCION);
$see->setCertificate(file_get_contents(__DIR__.'/valid-cer.pem'));
$see->setCredentials('20000000001DNOMBLOI', 'psdlbmrt'); // clave SOL

```

!!! info "Usuario Secundario"

    Despues de crear el usuario secundario, tiene que esperar hasta un plazo de 24 horas para
    que este activo y pueda usarlo.
