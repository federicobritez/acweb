<?php

namespace AppBundle\Entity;

/**
 * FacturaConsumo
 */
class FacturaConsumo
{
    /**
     * @var string
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
     * @var string
     */
    private $dniTitular;

    /**
     * @var string
     */
    private $cuil;

    /**
     * @var string
     */
    private $codSeguridad;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set numeroTarjeta
     *
     * @param string $numeroTarjeta
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
     * @return string
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
     * @param string $dniTitular
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
     * @return string
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
     * @param string $codSeguridad
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
     * @return string
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
}

