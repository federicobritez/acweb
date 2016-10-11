<?php

namespace AppBundle\Entity;

/**
 * ReservasHabitaciones
 */
class ReservasHabitaciones
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
     * @var \AppBundle\Entity\Habitaciones
     */
    private $habitaciones;


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
     * @return ReservasHabitaciones
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
     * Set habitaciones
     *
     * @param \AppBundle\Entity\Habitaciones $habitaciones
     *
     * @return ReservasHabitaciones
     */
    public function setHabitaciones(\AppBundle\Entity\Habitaciones $habitaciones = null)
    {
        $this->habitaciones = $habitaciones;

        return $this;
    }

    /**
     * Get habitaciones
     *
     * @return \AppBundle\Entity\Habitaciones
     */
    public function getHabitaciones()
    {
        return $this->habitaciones;
    }
}

