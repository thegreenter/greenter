# HTML Report - Greenter
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/836cd69234a343eab65b5588939c5019)](https://www.codacy.com/app/giansalex/greenter-report?utm_source=github.com&utm_medium=referral&utm_content=giansalex/greenter-report&utm_campaign=badger)
[![Travis-CI](https://travis-ci.org/giansalex/greenter-report.svg?branch=master)](https://travis-ci.org/giansalex/greenter-report)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/giansalex/greenter-report/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/giansalex/greenter-report/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/giansalex/greenter-report/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/giansalex/greenter-report/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/giansalex/greenter-report/badges/build.png?b=master)](https://scrutinizer-ci.com/g/giansalex/greenter-report/build-status/master)  

Representación en formato HTML del comprobante electrónico empleado en la facturación electrónica - SUNAT - Perú.
> Para generar el PDF puede utilizar [wkhtmltopdf](https://wkhtmltopdf.org/) y/o [greenter/htmltopdf](https://github.com/giansalex/greenter-htmltopdf).

## Preview

![Factura](docs/factura.png)

## Documents
- [x] Factura Electrónica  
- [x] Boleta Electrónica  
- [x] Nota de Crédito Electrónica  
- [x] Nota de Débito Electrónica  
- [ ] Guía de Remisión Electrónica  
- [ ] Retención Electrónica  
- [ ] Percepción Electrónica  

## Features
- Generación de Codigo QR
- Obteneción del Hash de la firma digital
- Agregar cabecera y pie de pagina personalizado
- Agregar datos extras al comprobante
- Crear nuevas plantillas según sus propios requerimientos