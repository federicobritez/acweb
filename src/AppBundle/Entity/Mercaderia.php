<?php

namespace AppBundle\Entity;

/**
 * Mercaderia
 */
class Mercaderia
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var float
     */
    private $precioUnitario;

    /**
     * @var integer
     */
    private $cantStock;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Mercaderia
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set precioUnitario
     *
     * @param float $precioUnitario
     *
     * @return Mercaderia
     */
    public function setPrecioUnitario($precioUnitario)
    {
        $this->precioUnitario = $precioUnitario;

        return $this;
    }

    /**
     * Get precioUnitario
     *
     * @return float
     */
    public function getPrecioUnitario()
    {
        return $this->precioUnitario;
    }

    /**
     * Set cantStock
     *
     * @param integer $cantStock
     *
     * @return Mercaderia
     */
    public function setCantStock($cantStock)
    {
        $this->cantStock = $cantStock;

        return $this;
    }

    /**
     * Get cantStock
     *
     * @return integer
     */
    public function getCantStock()
    {
        return $this->cantStock;
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

