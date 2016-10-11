<?php

namespace AppBundle\Entity;

/**
 * Acompanante
 */
class Acompanante
{
    /**
     * @var integer
     */
    private $clienteId;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \AppBundle\Entity\GrupoAcompanante
     */
    private $grupoAcompanante;


    /**
     * Set clienteId
     *
     * @param integer $clienteId
     *
     * @return Acompanante
     */
    public function setClienteId($clienteId)
    {
        $this->clienteId = $clienteId;

        return $this;
    }

    /**
     * Get clienteId
     *
     * @return integer
     */
    public function getClienteId()
    {
        return $this->clienteId;
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
     * @return Acompanante
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

