<?php

namespace AppBundle\Entity;

/**
 * FormasDePago
 */
class FormasDePago
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Servicio
     */
    private $servicio;

    /**
     * @var \AppBundle\Entity\TipoPago
     */
    private $tipoPago;


    /**
     * Set id
     *
     * @param integer $id
     *
     * @return FormasDePago
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @return FormasDePago
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

    /**
     * Set tipoPago
     *
     * @param \AppBundle\Entity\TipoPago $tipoPago
     *
     * @return FormasDePago
     */
    public function setTipoPago(\AppBundle\Entity\TipoPago $tipoPago)
    {
        $this->tipoPago = $tipoPago;

        return $this;
    }

    /**
     * Get tipoPago
     *
     * @return \AppBundle\Entity\TipoPago
     */
    public function getTipoPago()
    {
        return $this->tipoPago;
    }
}

