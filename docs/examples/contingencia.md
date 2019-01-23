# Contingencia
Existen situaciones adversas por la que un emisor electrónico no puede emitir comprobantes electronicos, en ese caso 
SUNAT les da la posibilidad de emitir un comprobante fisico, como anteriormente se realizaba.

Para informar a SUNAT de estos comprobantes, a partir del **01-09-2018** se enviá de la misma forma como se hace con
los comprobantes electrónicos.
> Las boletas por contingencia se siguen enviando empleando el resumen diario de boletas.


## Representación Impresa
La representación impresa de los comprobantes de contingencia deben incluir algunas leyendas, el primero: **"Emisor electrónico obligado"** y otra
dependiendo del tipo de comprobante

| Tipo documento   | Leyenda                                             |
|------------------|-----------------------------------------------------|
| Factura y Boleta | "Comprobante de Pago emitido en contingencia"       |
| Nota de Crédito  | "Nota de Crédito emitida en contingencia"           |
| Nota de Débito   | "Nota de Dédito emitida en contingencia"            |
| C. de Retención  | "Comprobante de Retención emitido en contingencia"  |
| C. de Percepción | "Comprobante de Percepción emitido en contingencia" |

## Factura Electrónica
El cambio con respecto a la emision normal de un comprobante electrónico es la serie, que es numérica.

```php
<?php
//...

$invoice->setSerie('0001');

//...
```

## Referencia

[Procedimiento de contingencia - SUNAT](http://cpe.sunat.gob.pe/informacion_general/procedimiento_contingencia)