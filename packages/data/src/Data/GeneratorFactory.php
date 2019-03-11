<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 10/03/2019
 * Time: 22:22.
 */

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
     * @param $type
     *
     * @return DocumentGeneratorInterface
     */
    public function create($type)
    {
        $shared = $this->getShared();

        return new $type($shared);
    }

    private function getShared()
    {
        if (empty($this->shared)) {
            $this->shared = new SharedStore();
        }

        return $this->shared;
    }
}
