<?php

declare(strict_types=1);

namespace Tests\Greenter\Exception;

use Greenter\Exception\GreenterException;
use Greenter\Services\InvalidServiceResponseException;
use LogicException;
use PHPUnit\Framework\TestCase;

class GreenterExceptionTest extends TestCase
{
    public function testInvalidServiceResponse(): void
    {
        $exception = new InvalidServiceResponseException('Respuesta inválida');

        $this->assertInstanceOf(GreenterException::class, $exception);
        $this->assertInstanceOf(LogicException::class, $exception);
    }
}
