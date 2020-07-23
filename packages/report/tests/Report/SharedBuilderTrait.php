<?php

declare(strict_types=1);

namespace Tests\Greenter\Report;

use Greenter\Data\GeneratorFactory;
use Greenter\Data\SharedStore;

trait SharedBuilderTrait
{
    private function getShared()
    {
        return new SharedStore();
    }

    private function createDocument($type)
    {
        $factory = new GeneratorFactory();
        $factory->shared = $this->getShared();
        $generator = $factory->create($type);
        return $generator->create();
    }
}