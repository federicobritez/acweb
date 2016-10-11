<?php

namespace AppBundle\Entity;

/**
 * Cliente
 */
class Cliente
{
    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $apellido;

    /**
     * @var string
     */
    private $telefono1;

    /**
     * @var string
     */
    private $telefono2;

    /**
     * @var string
     */
    private $ciudad;

    /**
     * @var string
     */
    private $pais;

    /**
     * @var string
     */
    private $provincia;

    /**
     * @var integer
     */
    private $dni;

    /**
     * @var string
     */
    private $correo;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\GrupoAcompanante
     */
    private $grupoAcompanante;


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Cliente
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
     * Set apellido
     *
     * @param string $apellido
     *
     * @return Cliente
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set telefono1
     *
     * @param string $telefono1
     *
     * @return Cliente
     */
    public function setTelefono1($telefono1)
    {
        $this->telefono1 = $telefono1;

        return $this;
    }

    /**
     * Get telefono1
     *
     * @return string
     */
    public function getTelefono1()
    {
        return $this->telefono1;
    }

    /**
     * Set telefono2
     *
     * @param string $telefono2
     *
     * @return Cliente
     */
    public function setTelefono2($telefono2)
    {
        $this->telefono2 = $telefono2;

        return $this;
    }

    /**
     * Get telefono2
     *
     * @return string
     */
    public function getTelefono2()
    {
        return $this->telefono2;
    }

    /**
     * Set ciudad
     *
     * @param string $ciudad
     *
     * @return Cliente
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return string
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set pais
     *
     * @param string $pais
     *
     * @return Cliente
     */
    public function setPais($pais)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return string
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     *
     * @return Cliente
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string
     */
    public function getProvincia()
    {
        return $this->provincia;
    }

    /**
     * Set dni
     *
     * @param integer $dni
     *
     * @return Cliente
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return integer
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set correo
     *
     * @param string $correo
     *
     * @return Cliente
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string
     */
    public function getCorreo()
    {
        return $this->correo;
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
     * Set grupoAcompanante
     *
     * @param \AppBundle\Entity\GrupoAcompanante $grupoAcompanante
     *
     * @return Cliente
     */
    public function setGrupoAcompanante(\AppBundle\Entity\GrupoAcompanante $grupoAcompanante = null)
    {
        $this->grupoAcompanante = $grupoAcompanante;

        return $this;
    }

    /**
     * Get grupoAcompanante
     *
     * @return \AppBundle\Entity\GrupoAcompanante
     */
    public function getGrupoAcompanante()
    {
        return $this->grupoAcompanante;
    }
}

