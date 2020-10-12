<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 10/03/2019
 * Time: 22:22.
 */

declare(strict_types=1);

namespace Greenter\Data;

/**
 * Class GeneratorFactory.
 */
class GeneratorFactory
{
    /**
     * @var SharedStore
     */
    public $shared;

    /**
     * @param string $type
     *
     * @return DocumentGeneratorInterface
     */
    public function create(string $type): ?DocumentGeneratorInterface
    {
        $shared = $this->getShared();

        return new $type($shared);
    }

    private function getShared(): SharedStore
    {
        if ($this->shared === null) {
            $this->shared = new SharedStore();
        }

        return $this->shared;
    }
}
