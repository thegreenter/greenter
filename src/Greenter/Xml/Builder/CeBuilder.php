<?php
/**
 * Created by PhpStorm.
 * User: Administrador
 * Date: 09/08/2017
 * Time: 01:30 PM
 */

namespace Greenter\Xml\Builder;

use Greenter\Model\Company\Company;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Perception\Perception;
use Greenter\Model\Retention\Retention;
use Greenter\Model\Voided\Reversion;
use Greenter\Xml\Exception\ValidationException;
use Symfony\Component\Validator\Validation;
use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Class CeBuilder
 * @package Greenter\Xml\Builder
 */
class CeBuilder implements CeBuilderInterface
{

    /**
     * Directorio de Cache para las template de Documentos.
     * @var string
     */
    private $dirCache;

    /**
     * Datos de la Compañia.
     *
     * @var Company
     */
    private $company;


    /**
     * CeBuilder constructor.
     */
    public function __construct()
    {
        $this->dirCache = sys_get_temp_dir();
    }

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
     * @param Company $company
     * @return CeBuilder
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;
        return $this;
    }

    /**
     * Set argumentos.
     *
     * @param array $params
     * @throws \Exception
     */
    public function setParameters($params)
    {
        if (!$params['cache']) {
            return;
        }

        if (!is_dir($params['cache'])) {
            throw new \Exception('No is a directory valid');
        }

        $this->dirCache = $params['cache'];
    }

    /**
     * Get Content XML from template.
     *
     * @param string $template
     * @param object $doc
     * @return string
     */
    private function render($template, $doc)
    {
        $twig = $this->getRender();
        return $twig->render($template, [
            'doc' => $doc,
            'emp' => $this->company,
        ]);
    }

    private function getRender()
    {
        $loader = new Twig_Loader_Filesystem(__DIR__ . '/../Templates');
        $twig = new Twig_Environment($loader, array(
            'cache' => $this->dirCache,
        ));

        return $twig;
    }

    /**
     * Validate Entity.
     *
     * @param object $entity
     * @throws ValidationException
     */
    private function validate($entity)
    {
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $errs = $validator->validate($entity);
        if ($errs->count() > 0) {
            throw new ValidationException($errs);
        }
    }
}