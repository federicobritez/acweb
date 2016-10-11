<?php

namespace AppBundle\Entity;

/**
 * Perfil
 */
class Perfil
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Vista
     */
    private $vista;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Perfil
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set vista
     *
     * @param \AppBundle\Entity\Vista $vista
     *
     * @return Perfil
     */
    public function setVista(\AppBundle\Entity\Vista $vista = null)
    {
        $this->vista = $vista;

        return $this;
    }

    /**
     * Get vista
     *
     * @return \AppBundle\Entity\Vista
     */
    public function getVista()
    {
        return $this->vista;
    }
}

