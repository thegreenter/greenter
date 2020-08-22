# Changelog

Los cambios notables de cada lanzamiento serán documentados en este archivo.

## Unreleased
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
- Se eliminó **Nro Resuolucion** en los PDF, los que quieran incluirlo, podrán hacerlo desde leyendas.
- Se quitó la clase `Notification` y otros relacionados, finalmente nunca se concluyó alguna implementación útil.   
