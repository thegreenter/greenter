<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 01/10/2017
 * Time: 15:31.
 */

namespace Greenter\Factory;

use Greenter\Model\DocumentInterface;
use Greenter\Model\Response\BaseResult;

/**
 * Interface FactoryInterface.
 */
interface FactoryInterface
{
    /**
     * @param DocumentInterface $document
     *
     * @return BaseResult
     */
    public function send(DocumentInterface $document);
}
