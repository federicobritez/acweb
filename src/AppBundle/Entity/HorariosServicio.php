<?php

namespace AppBundle\Entity;

/**
 * HorariosServicio
 */
class HorariosServicio
{
    /**
     * @var \DateTime
     */
    private $horaInicio;

    /**
     * @var \DateTime
     */
    private $horaFin;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Servicio
     */
    private $servicio;


    /**
     * Set horaInicio
     *
     * @param \DateTime $horaInicio
     *
     * @return HorariosServicio
     */
    public function setHoraInicio($horaInicio)
    {
        $this->horaInicio = $horaInicio;

        return $this;
    }

    /**
     * Get horaInicio
     *
     * @return \DateTime
     */
    public function getHoraInicio()
    {
        return $this->horaInicio;
    }

    /**
     * Set horaFin
     *
     * @param \DateTime $horaFin
     *
     * @return HorariosServicio
     */
    public function setHoraFin($horaFin)
    {
        $this->horaFin = $horaFin;

        return $this;
    }

    /**
     * Get horaFin
     *
     * @return \DateTime
     */
    public function getHoraFin()
    {
        return $this->horaFin;
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

    /**
     * Set servicio
     *
     * @param \AppBundle\Entity\Servicio $servicio
     *
     * @return HorariosServicio
     */
    public function setServicio(\AppBundle\Entity\Servicio $servicio = null)
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

