# ![Greenter](https://cdn.giansalex.dev/images/github/greenter-ico.png) Greenter
![CI](https://github.com/thegreenter/greenter/workflows/CI/badge.svg) [![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fthegreenter%2Fgreenter.svg?type=shield)](https://app.fossa.io/projects/git%2Bgithub.com%2Fthegreenter%2Fgreenter?ref=badge_shield)
    
Esta libreria le permite implementar la **Facturación Electrónica** en Perú, desde los sistemas desarrollados por el 
contribuyente, la cual esta normado por SUNAT.   
Greenter realiza la mayoria de tareas del proceso, genera el XML según el estándar UBL, firma con el certificado digital que sunat exige,
comprime el archivo XML en formato zip, conexión al webservice de SUNAT y procesa el CDR (Comprobante de Recepción).

Puede ver una demostración en [@greenter/demo](https://github.com/thegreenter/demo).

[![Quality gate](https://sonarcloud.io/api/project_badges/quality_gate?project=thegreenter_greenter)](https://sonarcloud.io/dashboard?id=thegreenter_greenter)

## Requerimientos
- PHP 7.2 o superior
- Extensiones PHP Activadas: `soap`, `dom`, `zip`, `zlib`, `openssl`.

## Documentación
- Lee esta [guia](https://fe-primer.greenter.dev/) para conocer mas sobre facturación electrónica.
- Empieza con este [ejemplo basico con greenter](https://greenter.dev/starter/).
- Tienes dudas o necesitas ayuda puedes hacerlo desde [aqui](https://community.greenter.dev/).

## API REST
API REST con [Lycet](https://github.com/giansalex/lycet) empleando Symfony Framework.

## License
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bgithub.com%2Fthegreenter%2Fgreenter.svg?type=large)](https://app.fossa.io/projects/git%2Bgithub.com%2Fthegreenter%2Fgreenter?ref=badge_large)