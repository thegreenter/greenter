# Greenter Validator - Facturacion Electronica

 [![Travis-CI](https://img.shields.io/travis/giansalex/greenter-validator.svg?label=travis-ci&branch=master&style=flat-square)](https://travis-ci.org/giansalex/greenter-validator)
 [![Codacy Badge](https://api.codacy.com/project/badge/Grade/b237d274d88d47fbab43ddac252d73a9)](https://www.codacy.com/app/giansalex/greenter-validator?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=giansalex/greenter-validator&amp;utm_campaign=Badge_Grade)    
Symfony Validator for [Greenter](https://github.com/giansalex/greenter) (UBL v2.0, v2.1)

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
