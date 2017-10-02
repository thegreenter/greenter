<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 09/08/2017
 * Time: 19:23
 */

namespace Greenter\Xml\Builder;

use Greenter\Xml\Exception\ValidationException;
use Symfony\Component\Validator\Validation;

/**
 * Class TwigBuilder
 * @package Greenter\Xml\Builder
 */
class TwigBuilder
{
    /**
     * Directorio de Cache para las template de Documentos.
     *
     * @var string
     */
    protected $dirCache;

    /**
     * Get Content XML from template.
     *
     * @param string $template
     * @param object $doc
     * @return string
     */
    public function render($template, $doc)
    {
        $this->validate($doc);

        $twig = $this->getRender();
        return $twig->render($template, [
            'doc' => $doc
        ]);
    }

    private function getRender()
    {
        //TODO: load render one time.
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../Templates');
        $numFilter = new \Twig_SimpleFilter('n_format', function ($number, $decimals = 2) {
            return number_format($number, $decimals, '.', '');
        });
        $twig = new \Twig_Environment($loader, array(
            'cache' => $this->dirCache,
        ));
        $twig->addFilter($numFilter);

        return $twig;
    }

    /**
     * Validate Entity.
     *
     * @param object $entity
     * @throws ValidationException
     */
    public function validate($entity)
    {
        // TODO: init validator one time.
        $validator = Validation::createValidatorBuilder()
            ->addMethodMapping('loadValidatorMetadata')
            ->getValidator();

        $errs = $validator->validate($entity);
        if ($errs->count() > 0) {
            throw new ValidationException($errs);
        }
    }

    /**
     * Set argumentos.
     *
     * @param $params
     * @throws \Exception
     */
    public function setParameters($params)
    {
        if (!$params['cache_dir']) {
            return;
        }

        $this->dirCache = $params['cache_dir'];
    }
}