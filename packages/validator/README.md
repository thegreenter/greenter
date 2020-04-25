# Greenter Validator - Facturacion Electronica

[![src greenter](https://img.shields.io/badge/src-greenter-brightgreen.svg)](https://github.com/thegreenter/greenter)
  
Symfony Validator for [Greenter](https://github.com/thegreenter/greenter) (UBL v2.0, v2.1)

## Install
Using composer from [packagist.org](https://packagist.org/packages/greenter/validator)
```bash
composer require greenter/validator
```

## Example

```php
use Greenter\Validator\SymfonyValidator;

$invoice = createInvoice();

$validator = new SymfonyValidator();
// Para UBL 2.1
// $validator = new SymfonyValidator(null, '2.1');
$errors = $validator->validate($invoice);

var_dump($errors);
```
