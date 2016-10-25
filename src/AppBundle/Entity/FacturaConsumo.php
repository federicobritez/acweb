<?php

namespace AppBundle\Entity;

/**
 * FacturaConsumo
 */
class FacturaConsumo
{
    /**
     * @var integer
     */
    private $numeroTarjeta;

    /**
     * @var string
     */
    private $validaHasta;

    /**
     * @var string
     */
    private $nombreApellidoTarjeta;

    /**
     * @var integer
     */
    private $dniTitular;

    /**
     * @var string
     */
    private $cuil;

    /**
     * @var integer
     */
    private $codSeguridad;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\ConsumosCliente
     */
    private $consumosCliente;


    /**
     * Set numeroTarjeta
     *
     * @param integer $numeroTarjeta
     *
     * @return FacturaConsumo
     */
    public function setNumeroTarjeta($numeroTarjeta)
    {
        $this->numeroTarjeta = $numeroTarjeta;

        return $this;
    }

    /**
     * Get numeroTarjeta
     *
     * @return integer
     */
    public function getNumeroTarjeta()
    {
        return $this->numeroTarjeta;
    }

    /**
     * Set validaHasta
     *
     * @param string $validaHasta
     *
     * @return FacturaConsumo
     */
    public function setValidaHasta($validaHasta)
    {
        $this->validaHasta = $validaHasta;

        return $this;
    }

    /**
     * Get validaHasta
     *
     * @return string
     */
    public function getValidaHasta()
    {
        return $this->validaHasta;
    }

    /**
     * Set nombreApellidoTarjeta
     *
     * @param string $nombreApellidoTarjeta
     *
     * @return FacturaConsumo
     */
    public function setNombreApellidoTarjeta($nombreApellidoTarjeta)
    {
        $this->nombreApellidoTarjeta = $nombreApellidoTarjeta;

        return $this;
    }

    /**
     * Get nombreApellidoTarjeta
     *
     * @return string
     */
    public function getNombreApellidoTarjeta()
    {
        return $this->nombreApellidoTarjeta;
    }

    /**
     * Set dniTitular
     *
     * @param integer $dniTitular
     *
     * @return FacturaConsumo
     */
    public function setDniTitular($dniTitular)
    {
        $this->dniTitular = $dniTitular;

        return $this;
    }

    /**
     * Get dniTitular
     *
     * @return integer
     */
    public function getDniTitular()
    {
        return $this->dniTitular;
    }

    /**
     * Set cuil
     *
     * @param string $cuil
     *
     * @return FacturaConsumo
     */
    public function setCuil($cuil)
    {
        $this->cuil = $cuil;

        return $this;
    }

    /**
     * Get cuil
     *
     * @return string
     */
    public function getCuil()
    {
        return $this->cuil;
    }

    /**
     * Set codSeguridad
     *
     * @param integer $codSeguridad
     *
     * @return FacturaConsumo
     */
    public function setCodSeguridad($codSeguridad)
    {
        $this->codSeguridad = $codSeguridad;

        return $this;
    }

    /**
     * Get codSeguridad
     *
     * @return integer
     */
    public function getCodSeguridad()
    {
        return $this->codSeguridad;
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
     * Set consumosCliente
     *
     * @param \AppBundle\Entity\ConsumosCliente $consumosCliente
     *
     * @return FacturaConsumo
     */
    public function setConsumosCliente(\AppBundle\Entity\ConsumosCliente $consumosCliente = null)
    {
        $this->consumosCliente = $consumosCliente;

        return $this;
    }

    /**
     * Get consumosCliente
     *
     * @return \AppBundle\Entity\ConsumosCliente
     */
    public function getConsumosCliente()
    {
        return $this->consumosCliente;
    }
}

