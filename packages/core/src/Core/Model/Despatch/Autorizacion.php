<?php

declare(strict_types=1);

namespace Greenter\Model\Despatch;

/**
 * Autorización especial emitida por una entidad, del remitente (campo 10 de
 * «Guía-Remitente2_0») o del transportista (campo 45), en
 * cac:AgentParty/cac:PartyLegalEntity/cbc:CompanyID.
 */
class Autorizacion
{
    /**
     * Número de autorización especial (cbc:CompanyID), an..50.
     *
     * @var string|null
     */
    private $numero;

    /**
     * Entidad que la emite, catálogo D-37 (cbc:CompanyID@schemeID).
     *
     * @var string|null
     */
    private $codEmisor;

    /**
     * @return string|null
     */
    public function getNumero(): ?string
    {
        return $this->numero;
    }

    /**
     * @param string|null $numero
     *
     * @return Autorizacion
     */
    public function setNumero(?string $numero): Autorizacion
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCodEmisor(): ?string
    {
        return $this->codEmisor;
    }

    /**
     * @param string|null $codEmisor
     *
     * @return Autorizacion
     */
    public function setCodEmisor(?string $codEmisor): Autorizacion
    {
        $this->codEmisor = $codEmisor;

        return $this;
    }
}
