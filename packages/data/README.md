# Documents Data - Greenter

[![src greenter](https://img.shields.io/badge/src-greenter-brightgreen.svg)](https://github.com/thegreenter/greenter)

Documents Data examples for Greenter.

# Install
Via Composer from [packagist.org](https://packagist.org/packages/greenter/data).
```bash
composer require --dev greenter/data
```

# Ejemplo

```php
<?php
use Greenter\Data\Generator\InvoiceStore;

$factory = new \Greenter\Data\GeneratorFactory();
$generator = $factory->create(InvoiceStore::class);

$document = $generator->create();

var_dump($document);
```