![Greenter](docs/img/logo.png)
# Greenter - Facturación Electrónica

[![Travis-CI](https://img.shields.io/travis/giansalex/greenter.svg?label=travis-ci&branch=master&style=flat-square)](https://travis-ci.org/giansalex/greenter)
[![Coverage Status](https://img.shields.io/coveralls/giansalex/greenter.svg?label=coveralls&style=flat-square&branch=master)](https://coveralls.io/github/giansalex/greenter?branch=master)
[![Codacy Badge](https://img.shields.io/codacy/grade/eccd5a16d035464cbe40b1cf9d0f9f43.svg?style=flat-square)](https://www.codacy.com/app/giansalex/greenter?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=giansalex/greenter&amp;utm_campaign=Badge_Grade)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/giansalex/greenter.svg?branch=master&style=flat-square)](https://scrutinizer-ci.com/g/giansalex/greenter/?branch=master)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/giansalex/greenter.svg?branch=master&style=flat-square)](https://scrutinizer-ci.com/g/giansalex/greenter/?branch=master)
[![Build Status](https://img.shields.io/scrutinizer/build/g/giansalex/greenter.svg?branch=master&style=flat-square)](https://scrutinizer-ci.com/g/giansalex/greenter/build-status/master)
[![Maintainability](https://api.codeclimate.com/v1/badges/4cf428e28ba4ae6fb234/maintainability)](https://codeclimate.com/github/giansalex/greenter)
[![Packagist](https://img.shields.io/packagist/v/greenter/greenter.svg?style=flat-square)](https://packagist.org/packages/greenter/greenter)    
[![Throughput Graph](https://graphs.waffle.io/giansalex/greenter/throughput.svg)](https://waffle.io/giansalex/greenter/metrics/throughput)     
PHP Implementación de la Facturación Electrónica Sunat - Perú

---

<p align="center">
  <img alt="Sunat Facturacion Electronica" src="https://raw.githubusercontent.com/giansalex/greenter/master/docs/img/sunat.ico">
</p>

# Install
```bash
composer require greenter/greenter
```
Para propositos de prueba, visite [Greenter Sampple](https://github.com/giansalex/greenter-sample).

Caracteristicas
---------------

### Documentos Soportados.

* Factura Electrónica
* Boleta Electrónica
* Nota de Crédito Electrónica
* Nota de Débito Electrónica
* Resumen Diario de Boletas
    > Version 2.1 apartir del 01/01/2018
* Comunicación de Bajas
* Guia Remisión Electrónica
* Retención Electrónica
* Percepción Electrónica
* Resumen de Reversiones

### Web Services
- Envio y empaquetado de los documentos electrónicos
- Consulta de tickets
- Consulta de Cdr

### XML
- Estandar UBL v2.0, v2.1
- Signature xmldsig

### Representación Impresa.
- Generación de [HTML Report](https://github.com/giansalex/greenter-report)
- Generación de [PDF](https://github.com/giansalex/greenter-htmltopdf)

### API REST
API REST with [Lycet](https://github.com/giansalex/lycet) based on Symfony.

### Used Packages
- [greenter/core](https://github.com/giansalex/greenter-core)
- [greenter/xml](https://github.com/giansalex/greenter-xml)
- [greenter/ws](https://github.com/giansalex/greenter-ws)
- [greenter/xmldsig](https://github.com/giansalex/xmldsig)

### Other Packages
- [greenter/report](https://github.com/giansalex/greenter-report)
- [greenter/htmltopdf](https://github.com/giansalex/greenter-htmltopdf)
- [greenter/validation](https://github.com/giansalex/greenter-validation)
