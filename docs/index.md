# Greenter

[![Travis-CI](https://img.shields.io/travis/giansalex/greenter.svg?label=travis-ci&branch=master&style=flat-square)](https://travis-ci.org/giansalex/greenter)
[![Coverage Status](https://img.shields.io/coveralls/giansalex/greenter.svg?label=coveralls&style=flat-square&branch=master)](https://coveralls.io/github/giansalex/greenter?branch=master)
[![Codacy Badge](https://img.shields.io/codacy/grade/eccd5a16d035464cbe40b1cf9d0f9f43.svg?style=flat-square)](https://www.codacy.com/app/giansalex/greenter?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=giansalex/greenter&amp;utm_campaign=Badge_Grade)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/giansalex/greenter.svg?branch=master&style=flat-square)](https://scrutinizer-ci.com/g/giansalex/greenter/?branch=master)
[![Build Status](https://img.shields.io/scrutinizer/build/g/giansalex/greenter.svg?branch=master&style=flat-square)](https://scrutinizer-ci.com/g/giansalex/greenter/build-status/master)
[![Packagist](https://img.shields.io/packagist/v/greenter/greenter.svg?style=flat-square)](https://packagist.org/packages/greenter/greenter)

     
Esta libreria le permite realizar la implementación de la **Facturación Electrónica** en Perú, desde los sistemas desarrollados por el 
contribuyente, la cual esta normado por SUNAT.   
Greenter realiza la mayoria de tareas del proceso, genera el XML según el estándar UBL, firma con el certificado digital que sunat exige,
comprime el archivo XML en formato zip, conexión al webservice de SUNAT y procesa el CDR (Comprobante de Recepción).
   

<p align="center">
  <img alt="Sunat Facturacion Electronica" src="https://github.com/giansalex/greenter/raw/master/docs/img/logo.png">
</p>

!!! info "API REST"

    Puede hacer uso de [Lycet](https://github.com/giansalex/lycet), un API REST basado en Greenter.

## Requerimientos
- PHP 5.6 o superior
- Extensiones PHP Activadas: `soap`, `dom`, `zip`, `zlib`, `openssl`.

## Instalación
Instala [Composer](https://getcomposer.org/download/) y ejecuta el siguiente comando para obtener la última versión:

```bash
composer require greenter/greenter
```

Puede ver una demostración en [giansalex/greenter-sample](https://github.com/giansalex/greenter-sample).

## Caracteristicas

### Comprobantes Soportados

* Factura Electrónica
* Boleta Electrónica
* Nota de Crédito Electrónica
* Nota de Débito Electrónica
* Resumen Diario de Boletas
* Comunicación de Bajas
* Guia Remisión Electrónica
* Retención Electrónica
* Percepción Electrónica
* Resumen de Reversiones


### Detalles
- XML estándar ==UBL v2.0, v2.1==
- Consulta de tickets
- Consulta de CDR

## Contribución
Siéntase en la libertad de hacer un fork de los diferentes repositorios, corregir o aportar mejoras, todo pull request será bienvenido.

## Notas de Interes

### Representación Impresa
- Generación de [HTML Report](https://github.com/giansalex/greenter-report)
- Generación de [PDF](https://github.com/giansalex/greenter-htmltopdf)

### Tools
- [UBL Validator](https://github.com/giansalex/ubl-validator-cli) 

[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://paypal.me/giansalex)
También puede contactarse vía correo.