<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 01:25 PM
 */

namespace Greenter\Xml\Builder;

use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Voided\Reversion;

/**
 * Interface CeBuilderInterface
 * @package Greenter\Xml\Builder
 */
interface CeBuilderInterface
{
    /**
     * Genera un comprobante de retencion.
     *
     * @param Retention $retention
     * @return string
     */
    public function buildRetention(Retention $retention);

    /**
     * Genera un comprobante de percepcion.
     *
     * @param Perception $perception
     * @return string
     */
    public function buildPerception(Perception $perception);

    /**
     * Genera una guia de remision.
     *
     * @param Despatch $despatch
     * @return string
     */
    public function buildDespatch(Despatch $despatch);

    /**
     * Genera una resumen de reversiones.
     *
     * @param Reversion $reversion
     * @return string
     */
    public function buildReversion(Reversion $reversion);

    /**
     * Set argumentos.
     *
     * @param array $params
     */
    public function setParameters($params);
}