<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/10/2017
 * Time: 21:58.
 */

namespace Greenter\Validator;

use Greenter\Model\DocumentInterface;

/**
 * Interface DocumentValidatorInterface.
 */
interface DocumentValidatorInterface
{
    /**
     * @param DocumentInterface $document
     *
     * @return mixed
     */
    public function validate(DocumentInterface $document);
}
