<?php

namespace AppBundle\Entity;

/**
 * ServiciosReservables
 */
class ServiciosReservables
{
    /**
     * @var \DateTime
     */
    private $tiempoConfirmacion;

    /**
     * @var float
     */
    private $minimoSenia;

    /**
     * @var \AppBundle\Entity\Servicio
     */
    private $servicio;


    /**
     * Set tiempoConfirmacion
     *
     * @param \DateTime $tiempoConfirmacion
     *
     * @return ServiciosReservables
     */
    public function setTiempoConfirmacion($tiempoConfirmacion)
    {
        $this->tiempoConfirmacion = $tiempoConfirmacion;

        return $this;
    }

    /**
     * Get tiempoConfirmacion
     *
     * @return \DateTime
     */
    public function getTiempoConfirmacion()
    {
        return $this->tiempoConfirmacion;
    }

    /**
     * Set minimoSenia
     *
     * @param float $minimoSenia
     *
     * @return ServiciosReservables
     */
    public function setMinimoSenia($minimoSenia)
    {
        $this->minimoSenia = $minimoSenia;

        return $this;
    }

    /**
     * Get minimoSenia
     *
     * @return float
     */
    public function getMinimoSenia()
    {
        return $this->minimoSenia;
    }

    /**
     * Set servicio
     *
     * @param \AppBundle\Entity\Servicio $servicio
     *
     * @return ServiciosReservables
     */
    public function setServicio(\AppBundle\Entity\Servicio $servicio)
    {
        $this->servicio = $servicio;

        return $this;
    }

    /**
     * Get servicio
     *
     * @return \AppBundle\Entity\Servicio
     */
    public function getServicio()
    {
        return $this->servicio;
    }
}

