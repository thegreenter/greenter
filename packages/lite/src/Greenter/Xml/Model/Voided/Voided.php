<?php
/**
 * Created by PhpStorm.
 * User: Giansalex
 * Date: 15/07/2017
 * Time: 22:00
 */

namespace Greenter\Xml\Model\Voided;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Voided
 * @package Greenter\Xml\Model\Voided
 */
class Voided
{
    /**
     * @Assert\Date()
     * @var \DateTime
     */
    private $fecGeneracion;

    /**
     * @Assert\NotBlank()
     * @Assert\Date()
     * @var \DateTime
     */
    private $fecComunicacion;

    /**
     * @Assert\All({
     *     @Assert\Valid()
     * })
     * @var VoidedDetail[]
     */
    private $documents;

    public function __construct()
    {
        $this->fecGeneracion = new \DateTime();
    }

    /**
     * @return \DateTime
     */
    public function getFecGeneracion()
    {
        return $this->fecGeneracion;
    }

    /**
     * @param \DateTime $fecGeneracion
     */
    public function setFecGeneracion($fecGeneracion)
    {
        $this->fecGeneracion = $fecGeneracion;
    }

    /**
     * @return \DateTime
     */
    public function getFecComunicacion()
    {
        return $this->fecComunicacion;
    }

    /**
     * @param \DateTime $fecComunicacion
     */
    public function setFecComunicacion($fecComunicacion)
    {
        $this->fecComunicacion = $fecComunicacion;
    }

    /**
     * @return VoidedDetail[]
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param VoidedDetail[] $documents
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;
    }
}