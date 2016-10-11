<?php

namespace AppBundle\Entity;

/**
 * HorariosReserva
 */
class HorariosReserva
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Reserva
     */
    private $reserva;

    /**
     * @var \AppBundle\Entity\HorariosServicio
     */
    private $horariosServicio;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reserva
     *
     * @param \AppBundle\Entity\Reserva $reserva
     *
     * @return HorariosReserva
     */
    public function setReserva(\AppBundle\Entity\Reserva $reserva = null)
    {
        $this->reserva = $reserva;

        return $this;
    }

    /**
     * Get reserva
     *
     * @return \AppBundle\Entity\Reserva
     */
    public function getReserva()
    {
        return $this->reserva;
    }

    /**
     * Set horariosServicio
     *
     * @param \AppBundle\Entity\HorariosServicio $horariosServicio
     *
     * @return HorariosReserva
     */
    public function setHorariosServicio(\AppBundle\Entity\HorariosServicio $horariosServicio = null)
    {
        $this->horariosServicio = $horariosServicio;

        return $this;
    }

    /**
     * Get horariosServicio
     *
     * @return \AppBundle\Entity\HorariosServicio
     */
    public function getHorariosServicio()
    {
        return $this->horariosServicio;
    }
}

