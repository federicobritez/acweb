<?php

namespace AppBundle\Entity;

/**
 * GrupoAcompanante
 */
class GrupoAcompanante
{
    /**
     * @var integer
     */
    private $idclienteResponsable;

    /**
     * @var string
     */
    private $alias;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set idclienteResponsable
     *
     * @param integer $idclienteResponsable
     *
     * @return GrupoAcompanante
     */
    public function setIdclienteResponsable($idclienteResponsable)
    {
        $this->idclienteResponsable = $idclienteResponsable;

        return $this;
    }

    /**
     * Get idclienteResponsable
     *
     * @return integer
     */
    public function getIdclienteResponsable()
    {
        return $this->idclienteResponsable;
    }

    /**
     * Set alias
     *
     * @param string $alias
     *
     * @return GrupoAcompanante
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
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

