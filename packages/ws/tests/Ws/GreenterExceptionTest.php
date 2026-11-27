<?php

declare(strict_types=1);

namespace Tests\Greenter\Ws;

use Greenter\Exception\GreenterException;
use Greenter\Ws\Builder\DocumentNoSupportException;
use Greenter\Ws\Reader\XmlReaderException;
use LogicException;
use PHPUnit\Framework\TestCase;

class GreenterExceptionTest extends TestCase
{
    /**
     * @dataProvider exceptionProvider
     */
    public function testImplementsGreenterException(string $class): void
    {
        $exception = new $class('error');

        $this->assertInstanceOf(GreenterException::class, $exception);
        $this->assertInstanceOf(LogicException::class, $exception);
    }

    public function exceptionProvider(): array
    {
        return [
            [DocumentNoSupportException::class],
            [XmlReaderException::class],
        ];
    }
}
