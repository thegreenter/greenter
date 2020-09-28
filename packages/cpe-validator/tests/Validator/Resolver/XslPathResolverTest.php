<?php

declare(strict_types=1);

namespace Tests\Greenter\Validator\Resolver;

use Greenter\Validator\Resolver\XslPathResolver;
use PHPStan\Testing\TestCase;

class XslPathResolverTest extends TestCase
{
    public function testNotFoundPath()
    {
        $resolver = new XslPathResolver(__DIR__);

        $path = $resolver->getPath('00');

        $this->assertNull($path);
    }
}