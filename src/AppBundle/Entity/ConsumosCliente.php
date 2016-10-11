<?php

namespace AppBundle\Entity;

/**
 * ConsumosCliente
 */
class ConsumosCliente
{
    /**
     * @var float
     */
    private $montoAbonado;

    /**
     * @var float
     */
    private $saldo;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\TipoPago
     */
    private $tipoPago;

    /**
     * @var \AppBundle\Entity\Servicio
     */
    private $servicio;

    /**
     * @var \AppBundle\Entity\Cliente
     */
    private $cliente;

    /**
     * @var \AppBundle\Entity\Reserva
     */
    private $reserva;


    /**
     * Set montoAbonado
     *
     * @param float $montoAbonado
     *
     * @return ConsumosCliente
     */
    public function setMontoAbonado($montoAbonado)
    {
        $this->montoAbonado = $montoAbonado;

        return $this;
    }

    /**
     * Get montoAbonado
     *
     * @return float
     */
    public function getMontoAbonado()
    {
        return $this->montoAbonado;
    }

    /**
     * Set saldo
     *
     * @param float $saldo
     *
     * @return ConsumosCliente
     */
    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;

        return $this;
    }

    /**
     * Get saldo
     *
     * @return float
     */
    public function getSaldo()
    {
        return $this->saldo;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return ConsumosCliente
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
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
     * Set tipoPago
     *
     * @param \AppBundle\Entity\TipoPago $tipoPago
     *
     * @return ConsumosCliente
     */
    public function setTipoPago(\AppBundle\Entity\TipoPago $tipoPago = null)
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

    /**
     * Set servicio
     *
     * @param \AppBundle\Entity\Servicio $servicio
     *
     * @return ConsumosCliente
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
     * Set cliente
     *
     * @param \AppBundle\Entity\Cliente $cliente
     *
     * @return ConsumosCliente
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

    /**
     * Set reserva
     *
     * @param \AppBundle\Entity\Reserva $reserva
     *
     * @return ConsumosCliente
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
}

