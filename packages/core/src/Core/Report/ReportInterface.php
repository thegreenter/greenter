<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 04/10/2017
 * Time: 19:59.
 */

declare(strict_types=1);

namespace Greenter\Report;

use Greenter\Model\DocumentInterface;

/**
 * Interface ReportInterface.
 */
interface ReportInterface
{
    /**
     * @param DocumentInterface $document
     * @param array             $parameters
     *
     * @return string
     */
    public function render(DocumentInterface $document, array $parameters = []): ?string;
}
