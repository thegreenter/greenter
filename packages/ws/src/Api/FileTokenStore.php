<?php

declare(strict_types=1);

namespace Greenter\Api;

use DateTimeImmutable;
use Greenter\Services\Api\BasicToken;
use Greenter\Services\Api\TokenStoreInterface;
use RuntimeException;

/**
 * Almacena el token de la API GRE en archivos, para reutilizarlo entre peticiones/procesos.
 *
 * Cada token se guarda como JSON en un archivo propio (nombre derivado de un hash del id),
 * se escribe de forma atómica y con permisos restringidos, ya que el token es una credencial.
 */
class FileTokenStore implements TokenStoreInterface
{
    private const FILE_PREFIX = 'greenter-token-';

    private string $directory;
    private int $filePermissions;

    /**
     * @param string $directory       Directorio donde se guardan los tokens (se crea si no existe).
     * @param int    $filePermissions Permisos de los archivos de token.
     */
    public function __construct(string $directory, int $filePermissions = 0600)
    {
        $this->directory = rtrim($directory, '/\\');
        $this->filePermissions = $filePermissions;
    }

    public function get(?string $id): ?BasicToken
    {
        $file = $this->getPath($id);
        if (!is_file($file)) {
            return null;
        }

        $content = @file_get_contents($file);
        if ($content === false) {
            return null;
        }

        $data = json_decode($content, true);
        if (!is_array($data)
            || !isset($data['value'], $data['expire'])
            || !is_string($data['value'])
            || !is_int($data['expire'])
        ) {
            return null;
        }

        if ($data['expire'] <= time()) {
            return null;
        }

        return new BasicToken($data['value'], (new DateTimeImmutable())->setTimestamp($data['expire']));
    }

    public function set(?string $id, BasicToken $token): void
    {
        $file = $this->getPath($id);
        $expire = $token->getExpire();
        if ($token->getValue() === null || $expire === null) {
            // Sin valor o sin expiración no es seguro reutilizarlo.
            @unlink($file);

            return;
        }

        $this->ensureDirectory();

        $content = json_encode([
            'value' => $token->getValue(),
            'expire' => $expire->getTimestamp(),
        ]);
        if ($content === false) {
            throw new RuntimeException('No se pudo serializar el token.');
        }

        $tmp = tempnam($this->directory, self::FILE_PREFIX);
        if ($tmp === false) {
            throw new RuntimeException(sprintf('No se pudo crear un archivo temporal en "%s".', $this->directory));
        }

        if (file_put_contents($tmp, $content, LOCK_EX) === false) {
            @unlink($tmp);
            throw new RuntimeException(sprintf('No se pudo escribir el token en "%s".', $tmp));
        }

        @chmod($tmp, $this->filePermissions);

        if (!@rename($tmp, $file)) {
            @unlink($tmp);
            throw new RuntimeException(sprintf('No se pudo guardar el token en "%s".', $file));
        }
    }

    private function ensureDirectory(): void
    {
        if (!is_dir($this->directory)
            && !@mkdir($this->directory, 0700, true)
            && !is_dir($this->directory)
        ) {
            throw new RuntimeException(sprintf('No se pudo crear el directorio "%s".', $this->directory));
        }

        if (!is_writable($this->directory)) {
            throw new RuntimeException(sprintf('El directorio "%s" no tiene permisos de escritura.', $this->directory));
        }
    }

    private function getPath(?string $id): string
    {
        return $this->directory.DIRECTORY_SEPARATOR.self::FILE_PREFIX.sha1((string) $id).'.json';
    }
}
