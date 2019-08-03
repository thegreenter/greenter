# Preguntas Frecuentes

## Facturas

!!! question "Que es el CDR"
CDR son las siglas de _constancia de recepcion_ y es emitida por sunat indicando que una factura ha sido aceptada o rechazada. Para saber a cual estado pertenece la factura emitida, debemos identificar en que rango de la siguiente tabla se encuentra el codigo de respuesta.

| Rango       |      Descripción      |  Que hacer                            |
|-------------|:---------------------:|--------------------------------------:|
| 0100 a 1999 | Excepciones           | Corregir y volver a enviar la factura |
| 2000 a 3999 | Errores (Rechazo)     | Emitir una nueva factura              |
| >4000       | Observaciones         | Corregir en futuras facturas          |

## Resumen diario

!!! question "Como obtener el CDR"
El proceso del resumen diario se compone de 2 fases, el envío y la obtención del CDR; este último no siempre se puede obtener inmediatamente, para ello debemos tener en cuenta el código que Sunat responde.

| Código    |      Descripción         |  Estado del CDR               |
|-----------|:------------------------:|------------------------------:|
| 0         | Procesado correctamente  | Disponible                    |
| 98        | En Proceso               | Necesitamos volver a intentar |
| 99        | Procesado con errores    | Disponible                    |

## WebService

!!! tip "Bad Gateway"
Este es un error al conectarse con el servicio (Sunat u OSE), y lo unico que se puede hacer es informar al administrador del servicio y esperar.

!!! tip "Could not connect to host"
Este mensaje puede ser resultado de varios casos, entre ellos falta de conectividad a internet, y otro mas recurrente por problemas al validar el certificado SSL del servicio a conectar.
Para solucionar esto puede probar una de estas opciones:   
- Instalar el certificado de sunat en el servidor que se esta usando   
- En caso de sistemas linux, actualizar `ca-certificates`   
- Deshabilitar la verificación SSL en `Ws\Services\SoapClient.php`
```php
<?php

$parameters=[
    'stream_context' => stream_context_create([
        'ssl' => [
            'verify_peer' => false,
        ],
    ]),
];
```