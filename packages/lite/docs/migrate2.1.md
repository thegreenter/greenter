# Migrar a UBL 2.1

En el archivo `composer.json`, ajustar la version de `greenter/greenter` a la version `3.0`.

```json
{
    "require": {
        "greenter/greenter": "^3.0"
    }
}
```

Luego ejecutar
```sh
composer update greenter/greenter
```

## Nuevos Campos

El principal cambio para indicar que el comprobante utilize **UBL 2.1**, es seteando el campo `ublVersion` que existe en `Invoice` y `Note`.
```php hl_lines="6 11"
<?php
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\Note;

$invoice = new Invoice();
$invoice->setUblVersion('2.1');

// ....

$note = new Note();
$note->setUblVersion('2.1');

// ...
```

Revisar el changelog en [@giansalex/greenter-core](https://github.com/giansalex/greenter-core/blob/master/CHANGELOG.md#oct-2018-10-14-ubl-21), para obtener más detalles.

!!! info "Ejemplo"

    En el [ejemplo](https://giansalex.github.io/greenter/starter/) de primeros pasos, verá los nuevos campos resaltados en el código.
    