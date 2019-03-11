# Documents Data - Greenter

[![Travis-CI](https://img.shields.io/travis/giansalex/greenter-data.svg?branch=master&style=flat-square)](https://travis-ci.org/giansalex/greenter-data)  
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