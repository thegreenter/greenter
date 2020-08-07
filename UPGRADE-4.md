# Greenter 4.0

La versión mínima de **PHP** será `7.2` y `greenter/greenter` ahora será el paquete principal que contendrá la mayoría de paquetes relacionados a Greenter, 
el equivalente de la anterior versión estará ubicado en `greenter/lite`, 
que contiene los requerimientos mínimos para realizar el proceso de facturación electrónica. 

Para actualizar a esta versión, necesitas modificar en `composer.json`.
```json
{
   "greenter/lite": "^4.0"
}
```
Luego ejecutar

```bash
composer update
```

> Los otros paquetes (ejm: `greenter/report`) podrán instalarse individualmente como en la anterior versión.

## `See::setCachePath`

Se ha cambiado la forma de deshabilitar `setCachePath`, que ahora solo acepta `string|null`.

_Antes_
```php
$see->setCachePath(false);
```

_Ahora_
```php
$see->setCachePath(null);
```
## `PdfReport::render()`

Se cambió la forma de validar si ha ocurrido un error al convertir a PDF.

_Antes_
```php

$result = $pdf->render($invoice);

if ($result === false) {
   // error
}
``` 

_Ahora_

```php

$result = $pdf->render($invoice);

if ($result === null) {
   // error
}
``` 

## `See::sendXmlFile`

Si se necesita enviar un XML previamente generado, se agregó el método `sendXmlFile`.

```php

$xml = file_get_contents('20000000001-01-F001-1.xml');

$result = $see->sendXmlFile($xml);

if ($result->isSucess()) {
   // mismo procedimiento que el método See::send()
}
```
