<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 10/03/2019
 * Time: 23:26
 */

declare(strict_types=1);

namespace Tests\Greenter\Xml\Builder;

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