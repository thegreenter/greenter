<?php

declare(strict_types=1);

namespace Tests\Greenter\Report;

use Greenter\Data\GeneratorFactory;

trait SharedBuilderTrait
{
    private function createDocument($type)
    {
        $factory = new GeneratorFactory();
        $generator = $factory->create($type);
        return $generator->create();
    }
}