<?php

namespace AppBundle\Entity;

/**
 * TipoPago
 */
class TipoPago
{
    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $interes;

    /**
     * @var string
     */
    private $cantCuotas;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return TipoPago
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set interes
     *
     * @param string $interes
     *
     * @return TipoPago
     */
    public function setInteres($interes)
    {
        $this->interes = $interes;

        return $this;
    }

    /**
     * Get interes
     *
     * @return string
     */
    public function getInteres()
    {
        return $this->interes;
    }

    /**
     * Set cantCuotas
     *
     * @param string $cantCuotas
     *
     * @return TipoPago
     */
    public function setCantCuotas($cantCuotas)
    {
        $this->cantCuotas = $cantCuotas;

        return $this;
    }

    /**
     * Get cantCuotas
     *
     * @return string
     */
    public function getCantCuotas()
    {
        return $this->cantCuotas;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}

