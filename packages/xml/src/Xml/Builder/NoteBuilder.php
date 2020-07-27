<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 01/10/2017
 * Time: 13:43.
 */

declare(strict_types=1);

namespace Greenter\Xml\Builder;

use Greenter\Builder\BuilderInterface;
use Greenter\Model\DocumentInterface;
use Greenter\Model\Sale\Note;
use Greenter\Xml\Filter\TributoFunction;
use Twig\TwigFunction;

/**
 * Class NoteBuilder.
 */
class NoteBuilder extends TwigBuilder implements BuilderInterface
{
    /**
     * @param array $options
     */
    public function __construct($options = [])
    {
        parent::__construct($options);

        $this->twig->addFunction(new TwigFunction('getTributoAfect', [TributoFunction::class, 'getByAfectacion']));
    }

    /**
     * Create xml for document.
     *
     * @param DocumentInterface $document
     *
     * @return string
     */
    public function build(DocumentInterface $document): string
    {
        /** @var Note $note */
        $note = /*.(Note).*/$document;
        $prefix = $note->getTipoDoc() === '07' ? 'notacr' : 'notadb';
        $template = $prefix.$note->getUblVersion().'.xml.twig';

        return $this->render($template, $document);
    }
}
