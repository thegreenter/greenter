<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/08/2017
 * Time: 19:57
 */

namespace Greenter\Factory;

use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Response\StatusResult;
use Greenter\Model\Response\SummaryResult;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Voided\Reversion;

/**
 * Interface CeFactoryInterface
 * @package Greenter\Factory
 */
interface CeFactoryInterface
{
    /**
     * Envia una Guia de Remision.
     *
     * @param Despatch $despatch
     * @return BillResult
     */
    public function sendDispatch(Despatch $despatch);

    /**
     * Envia una Retencion.
     *
     * @param Retention $retention
     * @return BillResult
     */
    public function sendRetention(Retention $retention);

    /**
     * Envia una Percepcion.
     *
     * @param Perception $perception
     * @return BillResult
     */
    public function sendPerception(Perception $perception);

    /**
     * Envia una Resumen de Reversiones.
     *
     * @param Reversion $reversion
     * @return SummaryResult
     */
    public function sendReversion(Reversion $reversion);

    /**
     * Get Status by Ticket.
     *
     * @param string $ticket
     * @return StatusResult
     */
    public function getStatus($ticket);

    /**
     * Get Last XML Signed.
     *
     * @return string
     */
    public function getLastXml();

    /**
     * @param array $params
     */
    public function setParameters($params);
}