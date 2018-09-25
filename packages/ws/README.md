# WebServices - Greenter

[![Travis-CI](https://img.shields.io/travis/giansalex/greenter-ws.svg?label=build&branch=master&style=flat-square)](https://travis-ci.org/giansalex/greenter-ws)
[![Coverage Status](https://img.shields.io/coveralls/giansalex/greenter-ws.svg?label=coveralls&style=flat-square&branch=master)](https://coveralls.io/github/giansalex/greenter-ws?branch=master)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/64cabd82882a461dbf82bdeb6accbc13)](https://www.codacy.com/app/giansalex/greenter-ws?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=giansalex/greenter-ws&amp;utm_campaign=Badge_Grade)  
Conexión con los servicios web de SUNAT.

# Install
```bash
composer require greenter/ws
```

### Conexiones Disponibles
**Beta**

| Servicio               | Ruta                                                                            |
|------------------------|---------------------------------------------------------------------------------|
| Factura                | https://e-beta.sunat.gob.pe/ol-ti-itcpfegem-beta/billService?wsdl               |
| Guia                   | https://e-beta.sunat.gob.pe/ol-ti-itemision-guia-gem-beta/billService?wsdl      |
| Retención y Percepción | https://e-beta.sunat.gob.pe/ol-ti-itemision-otroscpe-gem-beta/billService?wsdl  |

**Producción**

| Servicio               | Ruta                                                                            |
|------------------------|---------------------------------------------------------------------------------|
| Factura                | https://e-factura.sunat.gob.pe/ol-ti-itcpfegem/billService?wsdl                 |
| Guia                   | https://e-guiaremision.sunat.gob.pe/ol-ti-itemision-guia-gem/billService?wsdl   |
| Retención y Percepción | https://e-factura.sunat.gob.pe/ol-ti-itemision-otroscpe-gem/billService?wsdl    |
| Consulta CDR           | https://e-factura.sunat.gob.pe/ol-it-wsconsvalidcpe/billValidService?wsdl       |
