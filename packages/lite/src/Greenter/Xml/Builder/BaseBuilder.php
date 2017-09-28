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
 * Class BaseBuilder
 * @package Greenter\Xml\Builder
 */
class BaseBuilder
{
    /**
     * Directorio de Cache para las template de Documentos.
     *
     * @var string
     */
    protected $dirCache;

    /**
     * BaseBuilder constructor.
     */
    public function __construct()
    {
        $this->dirCache = sys_get_temp_dir();
    }

    /**
     * Get Content XML from template.
     *
     * @param string $template
     * @param object $doc
     * @return string
     */
    public function render($template, $doc)
    {
        $twig = $this->getRender();
        return $twig->render($template, [
            'doc' => $doc
        ]);
    }

    private function getRender()
    {
        $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../Templates');
        $twig = new \Twig_Environment($loader, array(
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
    public function validate($entity)
    {
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
    protected function addParameters($params)
    {
        if (!$params['cache']) {
            return;
        }

        if (!is_dir($params['cache'])) {
            throw new \Exception('No is a directory valid');
        }

        $this->dirCache = $params['cache'];
    }
}