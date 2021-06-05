# Changelog

Los cambios notables de cada lanzamiento serán documentados en este archivo.

## Unreleased
- #175 Inclusión de tag `<Signature>` en guía remisión.

## 4.3.1 - 2021-03-20
- Corregir lectura de CDR cuando los `namespaces` xml sean diferentes al por defecto.
- Incluir el detalle de `SoapFault` en forma codificada, ya que puede ser una estructura compleja.
- Incluir flujo de `CI` para sincronizar monorepo en `dev-master`.

## 4.3.0 - 2021-03-06
- Incluir validaciones de forma de pago en `greenter/validator`
- Actualizar versión de paquetes para permitir instalación en PHP 8
- Eliminar extension php `fileinfo`
- Actualizar códigos de retorno a la fecha `2021-01-29`

## 4.2.0 - 2021-02-06
- Agregar forma de Pago según resolución **Nº 000193-2020/SUNAT**
- Corrección zona horaria Lima en nombres de archivo para Resumen diario y C. de bajas. 

## 4.1.1 - 2020-11-29
- Los parámetros para métodos `ConsultCdrService::getStatus` y `ConsultCdrService::getStatusCdr` ahora son de tipado estricto. 
- Se incluyó un error personalizado cuando el CDR no es encontrado en la respuesta de SUNAT.
- Corrección de método `php:match` XSLT en `cpe-validator`.
- Soporte para `PHP 8`.

## v4.1.0 - 2020-09-20
- Uso de compresión y decompresión en memoria #145
- Validación de zip vacío en `getStatus` #144
- Configuración de código Unidad `NIU`, en impuesto a la bolsa `ICBPER`.

## v4.0.2 - 2020-08-22
- Configurar zona horaria por defecto a `America/Lima` en xml,report.
- Nuevo paquete `greenter/cpe-validator`, permite realizar las validaciones con los archivos XSL de Sunat SFS.
- Eliminación de validaciones complejas de `greenter/validator`, en favor de `cpe-validator`.

## v4.0.0 - 2020-08-09

- La versión mínima de PHP es `7.2`
- Los paquetes principales ahora se manejaran en `thegreenter/greenter` monorepo.
- Se configuró tipos estrictos en la mayoría de clases.
- Se añadió un nuevo campo: otros descuentos `sumOtrosDescuentos`, para diferenciarlo de `mtoDescuentos` (UBL 2.0).
- Debido a que el monorepo incluye la mayoría de paquetes, se agregó un nuevo paquete `greenter/lite` que representará al anterior `greenter/greenter`. 
- `See::setCachePath()` solo aceptara `string|null`, para deshabilitar el cache enviar `null`.
- `PdfReport::render()` retornará solo `string|null`, donde `null` indica que hubo un error.
- Un nuevo método `See::sendXmlFile($xml)` para enviar xml previamente generados.
- Se formateo el nodo de firma, para incluirlo en una sola línea.
- Un nuevo método `See::setClaveSOL()`, para evitar confusión en las credenciales.
- Se eliminó **Nro Resolución** en los PDF, los que quieran incluirlo, podrán hacerlo desde leyendas.
- Se quitó la clase `Notification` y otros relacionados, finalmente nunca se concluyó alguna implementación útil.   
