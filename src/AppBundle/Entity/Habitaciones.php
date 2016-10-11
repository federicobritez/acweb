<?php

namespace AppBundle\Entity;

/**
 * Habitaciones
 */
class Habitaciones
{
    /**
     * @var integer
     */
    private $cantCamasSimples;

    /**
     * @var integer
     */
    private $cantCamasDoble;

    /**
     * @var integer
     */
    private $valorHabitacion;

    /**
     * @var integer
     */
    private $estadoHabitacion;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set cantCamasSimples
     *
     * @param integer $cantCamasSimples
     *
     * @return Habitaciones
     */
    public function setCantCamasSimples($cantCamasSimples)
    {
        $this->cantCamasSimples = $cantCamasSimples;

        return $this;
    }

    /**
     * Get cantCamasSimples
     *
     * @return integer
     */
    public function getCantCamasSimples()
    {
        return $this->cantCamasSimples;
    }

    /**
     * Set cantCamasDoble
     *
     * @param integer $cantCamasDoble
     *
     * @return Habitaciones
     */
    public function setCantCamasDoble($cantCamasDoble)
    {
        $this->cantCamasDoble = $cantCamasDoble;

        return $this;
    }

    /**
     * Get cantCamasDoble
     *
     * @return integer
     */
    public function getCantCamasDoble()
    {
        return $this->cantCamasDoble;
    }

    /**
     * Set valorHabitacion
     *
     * @param integer $valorHabitacion
     *
     * @return Habitaciones
     */
    public function setValorHabitacion($valorHabitacion)
    {
        $this->valorHabitacion = $valorHabitacion;

        return $this;
    }

    /**
     * Get valorHabitacion
     *
     * @return integer
     */
    public function getValorHabitacion()
    {
        return $this->valorHabitacion;
    }

    /**
     * Set estadoHabitacion
     *
     * @param integer $estadoHabitacion
     *
     * @return Habitaciones
     */
    public function setEstadoHabitacion($estadoHabitacion)
    {
        $this->estadoHabitacion = $estadoHabitacion;

        return $this;
    }

    /**
     * Get estadoHabitacion
     *
     * @return integer
     */
    public function getEstadoHabitacion()
    {
        return $this->estadoHabitacion;
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

