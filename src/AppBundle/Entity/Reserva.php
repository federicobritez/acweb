<?php

namespace AppBundle\Entity;

/**
 * Reserva
 */
class Reserva
{
    /**
     * @var \DateTime
     */
    private $fechaReserva;

    /**
     * @var \DateTime
     */
    private $fechaDesde;

    /**
     * @var \DateTime
     */
    private $fechaHasta;

    /**
     * @var integer
     */
    private $cantPersonas;

    /**
     * @var float
     */
    private $valorTotal;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Servicio
     */
    private $servicio;

    /**
     * @var \AppBundle\Entity\EstadoReserva
     */
    private $estadoReserva;

    /**
     * @var \AppBundle\Entity\Cliente
     */
    private $cliente;


    /**
     * Set fechaReserva
     *
     * @param \DateTime $fechaReserva
     *
     * @return Reserva
     */
    public function setFechaReserva($fechaReserva)
    {
        $this->fechaReserva = $fechaReserva;

        return $this;
    }

    /**
     * Get fechaReserva
     *
     * @return \DateTime
     */
    public function getFechaReserva()
    {
        return $this->fechaReserva;
    }

    /**
     * Set fechaDesde
     *
     * @param \DateTime $fechaDesde
     *
     * @return Reserva
     */
    public function setFechaDesde($fechaDesde)
    {
        $this->fechaDesde = $fechaDesde;

        return $this;
    }

    /**
     * Get fechaDesde
     *
     * @return \DateTime
     */
    public function getFechaDesde()
    {
        return $this->fechaDesde;
    }

    /**
     * Set fechaHasta
     *
     * @param \DateTime $fechaHasta
     *
     * @return Reserva
     */
    public function setFechaHasta($fechaHasta)
    {
        $this->fechaHasta = $fechaHasta;

        return $this;
    }

    /**
     * Get fechaHasta
     *
     * @return \DateTime
     */
    public function getFechaHasta()
    {
        return $this->fechaHasta;
    }

    /**
     * Set cantPersonas
     *
     * @param integer $cantPersonas
     *
     * @return Reserva
     */
    public function setCantPersonas($cantPersonas)
    {
        $this->cantPersonas = $cantPersonas;

        return $this;
    }

    /**
     * Get cantPersonas
     *
     * @return integer
     */
    public function getCantPersonas()
    {
        return $this->cantPersonas;
    }

    /**
     * Set valorTotal
     *
     * @param float $valorTotal
     *
     * @return Reserva
     */
    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;

        return $this;
    }

    /**
     * Get valorTotal
     *
     * @return float
     */
    public function getValorTotal()
    {
        return $this->valorTotal;
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
     * @return Reserva
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

    /**
     * Set estadoReserva
     *
     * @param \AppBundle\Entity\EstadoReserva $estadoReserva
     *
     * @return Reserva
     */
    public function setEstadoReserva(\AppBundle\Entity\EstadoReserva $estadoReserva = null)
    {
        $this->estadoReserva = $estadoReserva;

        return $this;
    }

    /**
     * Get estadoReserva
     *
     * @return \AppBundle\Entity\EstadoReserva
     */
    public function getEstadoReserva()
    {
        return $this->estadoReserva;
    }

    /**
     * Set cliente
     *
     * @param \AppBundle\Entity\Cliente $cliente
     *
     * @return Reserva
     */
    public function setCliente(\AppBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \AppBundle\Entity\Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }
}

