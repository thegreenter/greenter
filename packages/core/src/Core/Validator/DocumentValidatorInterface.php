<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/10/2017
 * Time: 21:58.
 */

declare(strict_types=1);

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
     * @return object
     */
    public function validate(DocumentInterface $document): ?object;
}
