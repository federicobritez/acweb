<?php

namespace AppBundle\Entity;

/**
 * Servicio
 */
class Servicio
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var float
     */
    private $valorUnitario;

    /**
     * @var integer
     */
    private $maxPlazas;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Servicio
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Servicio
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
     * Set valorUnitario
     *
     * @param float $valorUnitario
     *
     * @return Servicio
     */
    public function setValorUnitario($valorUnitario)
    {
        $this->valorUnitario = $valorUnitario;

        return $this;
    }

    /**
     * Get valorUnitario
     *
     * @return float
     */
    public function getValorUnitario()
    {
        return $this->valorUnitario;
    }

    /**
     * Set maxPlazas
     *
     * @param integer $maxPlazas
     *
     * @return Servicio
     */
    public function setMaxPlazas($maxPlazas)
    {
        $this->maxPlazas = $maxPlazas;

        return $this;
    }

    /**
     * Get maxPlazas
     *
     * @return integer
     */
    public function getMaxPlazas()
    {
        return $this->maxPlazas;
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

