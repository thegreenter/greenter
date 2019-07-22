<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 01:36 PM.
 */

namespace Greenter\Report\Extension;

use Twig\RuntimeLoader\RuntimeLoaderInterface;

/**
 * Class RuntimeLoader.
 */
class RuntimeLoader implements RuntimeLoaderInterface
{
    public function load($class)
    {
        return new $class();
    }
}
