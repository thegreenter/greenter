<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 01:30 PM
 */

namespace Greenter\Xml\Builder;

use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Voided\Reversion;
use Greenter\Xml\Exception\ValidationException;

/**
 * Class CeBuilder
 * @package Greenter\Xml\Builder
 */
class CeBuilder extends BaseBuilder implements CeBuilderInterface
{
    /**
     * Genera un comprobante de retencion.
     *
     * @param Retention $retention
     * @throws ValidationException
     * @return string
     */
    public function buildRetention(Retention $retention)
    {
        $this->validate($retention);

        return $this->render('retention.html.twig', $retention);
    }

    /**
     * Genera un comprobante de percepcion.
     *
     * @param Perception $perception
     * @throws ValidationException
     * @return string
     */
    public function buildPerception(Perception $perception)
    {
        $this->validate($perception);

        return $this->render('perception.html.twig', $perception);
    }

    /**
     * Genera una guia de remision.
     *
     * @param Despatch $despatch
     * @throws ValidationException
     * @return string
     */
    public function buildDespatch(Despatch $despatch)
    {
        $this->validate($despatch);

        return $this->render('despatch.html.twig', $despatch);
    }

    /**
     * Genera una resumen de reversiones.
     *
     * @param Reversion $reversion
     * @throws ValidationException
     * @return string
     */
    public function buildReversion(Reversion $reversion)
    {
        $this->validate($reversion);

        return $this->render('voided.html.twig', $reversion);
    }

    /**
     * Set argumentos.
     *
     * @param array $params
     * @throws \Exception
     */
    public function setParameters($params)
    {
        $this->addParameters($params);
    }
}