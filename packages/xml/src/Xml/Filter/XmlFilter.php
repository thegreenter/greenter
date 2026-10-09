<?php

declare(strict_types=1);

namespace Greenter\Xml\Filter;

/**
 * Class XmlFilter.
 * @internal
 */
class XmlFilter
{
    /**
     * Prepara un valor para ser incluido dentro de una sección CDATA.
     *
     * La secuencia `]]>` cerraría la sección, se divide en dos secciones CDATA consecutivas.
     *
     * @param mixed $value
     *
     * @return string
     */
    public function cdata($value): string
    {
        return str_replace(']]>', ']]]]><![CDATA[>', (string)$value);
    }
}
