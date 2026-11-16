<?php

declare(strict_types=1);

namespace Greenter\Model\Sale;

/**
 * Contrato de colaboración empresarial sin contabilidad independiente
 * (campos 182 a 187 de «Factura2_0», 66 a 71 de «NotaCredito2_0» y 64 a 69 de
 * «NotaDebito2_0», cac:ContractDocumentReference).
 */
class Contrato
{
    /**
     * Tipo de contrato (cbc:DocumentTypeCode): 1 ventas, cuando el emisor es el
     * partícipe que vende como parte del contrato; 2 adquisiciones, cuando vende
     * a un partícipe del contrato.
     *
     * @var string|null
     */
    private $tipo;

    /**
     * Número o denominación del contrato (cbc:ID).
     *
     * @var string|null
     */
    private $numero;

    /**
     * Tipo o descripción del contrato (cbc:DocumentDescription).
     *
     * @var string|null
     */
    private $descripcion;

    /**
     * Porcentaje de participación en el contrato
     * (cac:IssuerParty/cac:PartyLegalEntity/cac:ShareholderParty/cbc:PartecipationPercent).
     *
     * @var float|null
     */
    private $porcentaje;

    /**
     * @return string|null
     */
    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    /**
     * @param string|null $tipo
     *
     * @return Contrato
     */
    public function setTipo(?string $tipo): Contrato
    {
        $this->tipo = $tipo;

        return $this;
    }

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
     * @return Contrato
     */
    public function setNumero(?string $numero): Contrato
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    /**
     * @param string|null $descripcion
     *
     * @return Contrato
     */
    public function setDescripcion(?string $descripcion): Contrato
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getPorcentaje(): ?float
    {
        return $this->porcentaje;
    }

    /**
     * @param float|null $porcentaje
     *
     * @return Contrato
     */
    public function setPorcentaje(?float $porcentaje): Contrato
    {
        $this->porcentaje = $porcentaje;

        return $this;
    }
}
