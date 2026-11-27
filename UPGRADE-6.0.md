# Greenter 6.0

Cambios incompatibles previstos para v6 y cómo prepararse desde 5.x. Las APIs deprecadas en 5.x
siguen funcionando hasta v6; al usarlas se emite un aviso `E_USER_DEPRECATED` (silenciado, visible con
herramientas como `symfony/phpunit-bridge` o un `set_error_handler`).

- La versión mínima de **PHP** será `8.1`.
- `twig/twig` `^3.27` o superior.

## `FeFactory` y `See::getFactory()`

Se eliminan. Para el último XML firmado usar `See::getLastXml()`; para construir, firmar y enviar
usar `DocumentProcessor`.

_Antes_
```php
$result = $see->send($invoice);
$xml = $see->getFactory()->getLastXml();
```

_Ahora_
```php
$result = $see->send($invoice);
$xml = $see->getLastXml();
```

### `DocumentProcessor`

Recibe sus dependencias en el constructor y no guarda estado entre envíos, una misma instancia
se puede compartir (ejm: como servicio en un contenedor de dependencias).

```php
use Greenter\Factory\WsSenderResolver;
use Greenter\Factory\XmlBuilderResolver;
use Greenter\Processor\DocumentProcessor;
use Greenter\Processor\SignedXmlSigner;
use Greenter\Ws\Services\SoapClient;
use Greenter\Ws\Services\SunatEndpoints;

$client = SoapClient::createSecure();
$client->setService(SunatEndpoints::FE_BETA);
$client->setCredentials('20000000001MODDATOS', 'moddatos');

$processor = new DocumentProcessor(
    new XmlBuilderResolver(['cache' => __DIR__.'/cache', 'autoescape' => 'html']),
    SignedXmlSigner::fromCertificate(file_get_contents('certificate.pem')),
    new WsSenderResolver($client)
);

$xml = $processor->getXmlSigned($invoice);
$result = $processor->sendXml(get_class($invoice), $invoice->getName(), $xml);
```

Desde 5.x también está disponible con la configuración de `See` o `Api`: `$see->getProcessor()`.

## Propiedades públicas de `BaseSunat`

`compressor`, `decompressor` y `cdrReader` dejan de ser públicas (aplica a `BillSender`, `SummarySender`,
`ExtService`, `ConsultCdrService` y `GreSender`).

_Antes_
```php
$sender->compressor = new MyCompressor();
```

_Ahora_
```php
$sender->setCompressor(new MyCompressor());
```

## Errores

- Errores de negocio (rechazos de SUNAT, `SoapFault`, errores HTTP del API GRE): se informan en el
  resultado, `BaseResult::isSuccess()` y `BaseResult::getError()`.
- Errores técnicos o de uso (documento sin builder, XML inválido, respuesta con formato inesperado):
  excepciones que implementan `Greenter\Exception\GreenterException`.

```php
use Greenter\Exception\GreenterException;

try {
    $result = $see->send($invoice);
} catch (GreenterException $e) {
    // error técnico
}

if (!$result->isSuccess()) {
    // error de negocio
    echo $result->getError()->getCode(), ' ', $result->getError()->getMessage();
}
```

## Verificación TLS

El cliente SOAP verificará el certificado TLS de SUNAT por defecto (en 5.x: `SoapClient::createSecure()`).
