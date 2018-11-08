![Greenter](docs/img/logo.png)
<img src="https://raw.githubusercontent.com/giansalex/greenter/master/docs/img/sunat.ico" align=right>
# Greenter - Facturación Electrónica

[![Travis-CI](https://img.shields.io/travis/giansalex/greenter.svg?label=travis-ci&branch=master&style=flat-square)](https://travis-ci.org/giansalex/greenter)
[![Coverage Status](https://img.shields.io/coveralls/giansalex/greenter.svg?label=coveralls&style=flat-square&branch=master)](https://coveralls.io/github/giansalex/greenter?branch=master)
[![Codacy Badge](https://img.shields.io/codacy/grade/eccd5a16d035464cbe40b1cf9d0f9f43.svg?style=flat-square)](https://www.codacy.com/app/giansalex/greenter?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=giansalex/greenter&amp;utm_campaign=Badge_Grade)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/giansalex/greenter.svg?branch=master&style=flat-square)](https://scrutinizer-ci.com/g/giansalex/greenter/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/giansalex/greenter.svg?branch=master&style=flat-square)](https://scrutinizer-ci.com/g/giansalex/greenter/?branch=master)
[![Build Status](https://img.shields.io/scrutinizer/build/g/giansalex/greenter.svg?branch=master&style=flat-square)](https://scrutinizer-ci.com/g/giansalex/greenter/build-status/master)
[![Maintainability](https://api.codeclimate.com/v1/badges/4cf428e28ba4ae6fb234/maintainability)](https://codeclimate.com/github/giansalex/greenter)
[![Packagist](https://img.shields.io/packagist/v/greenter/greenter.svg?style=flat-square)](https://packagist.org/packages/greenter/greenter)    
Esta libreria le permite realizar la implementación de la **Facturación Electrónica** en Perú, desde los sistemas desarrollados por el 
contribuyente, la cual esta normado por SUNAT.   
Greenter realiza la mayoria de tareas del proceso, genera el XML según el estándar UBL, firma con el certificado digital que sunat exige,
comprime el archivo XML en formato zip, conexión al webservice de SUNAT y procesa el CDR (Comprobante de Recepción).
   
[![Throughput Graph](https://graphs.waffle.io/giansalex/greenter/throughput.svg)](https://waffle.io/giansalex/greenter/metrics/throughput)     


## Requerimientos
- PHP 5.6 o superior
- Extensiones PHP Activadas: `soap`, `dom`, `zip`, `zlib`, `openssl`.

## Instalar
```bash
composer require greenter/greenter
```
Puede ver una demostración en [Greenter Sampple](https://github.com/giansalex/greenter-sample).

## Caracteristicas

### Documentos Soportados.

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

[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://paypal.me/giansalex)   
> También puedes contactarte vía correo.

### API
- [Api Reference](https://giansalex.github.io/greenter-apidoc/)

### Web Services
- Envío y empaquetado de los comprobantes electrónicos
- Consulta de tickets (Resumen diario, Comunicación de Bajas)
- Consulta de Cdr

### XML
- Estandar UBL v2.0, v2.1
- Firma con certificado digital

### Representación Impresa.
- Generación de [HTML Report](https://github.com/giansalex/greenter-report)
- Generación de [PDF](https://github.com/giansalex/greenter-htmltopdf)

### API REST
API REST con [Lycet](https://github.com/giansalex/lycet) empleando Symfony Framework.

### Librerias Relacionadas
- [greenter/report](https://github.com/giansalex/greenter-report)
- [greenter/htmltopdf](https://github.com/giansalex/greenter-htmltopdf)
- [greenter/validator](https://github.com/giansalex/greenter-validator)
- [greenter/ubl-validator](https://github.com/giansalex/ubl-validator)
