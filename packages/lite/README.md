# Greenter Lite

[![src greenter](https://greenter.dev/img/greenter_badge.svg)](https://github.com/thegreenter/greenter)

Versión de Greenter que solo incluye los paquetes minimos requeridos para generar y enviar comprobantes electrónicos.

## Token persistente (API GRE)

Por defecto `Greenter\Api` guarda el token de SUNAT en memoria, por lo que en PHP-FPM se solicita
un token nuevo en cada petición. Para reutilizarlo hasta que expire, configure un almacenamiento persistente:

```php
use Greenter\Api;
use Greenter\Api\FileTokenStore;
use Greenter\Api\Psr16TokenStore;

$api = (new Api())
    ->setApiCredentials($clientId, $clientSecret)
    ->setClaveSOL($ruc, $usuario, $clave)
    ->setCertificate($certificado)
    // Archivos (sin dependencias). Use un directorio privado, fuera del document root.
    ->setTokenStore(new FileTokenStore('/var/cache/greenter/tokens'));

// O cualquier caché PSR-16 (Redis, APCu, Laravel, Symfony...), requiere `psr/simple-cache`.
$api->setTokenStore(new Psr16TokenStore($cache));
```

También puede implementar `Greenter\Services\Api\TokenStoreInterface` para usar otro almacenamiento.

## Recursos
- [Documentación](https://greenter.dev/)
- [Reportar un error](https://github.com/thegreenter/greenter/issues) o enviar un [pull request](https://github.com/thegreenter/greenter/pulls) al [repositorio principal de greenter](https://github.com/thegreenter/greenter).
