<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 20/01/2018
 * Time: 01:36 PM.
 */

namespace Greenter\Report\Extension;

/**
 * Class RuntimeLoader.
 */
class RuntimeLoader implements \Twig_RuntimeLoaderInterface
{
    public function load($class)
    {
        return new $class();
    }
}
