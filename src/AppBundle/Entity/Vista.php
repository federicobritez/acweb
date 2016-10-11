<?php

namespace AppBundle\Entity;

/**
 * Vista
 */
class Vista
{
    /**
     * @var string
     */
    private $nombrePlantilla;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set nombrePlantilla
     *
     * @param string $nombrePlantilla
     *
     * @return Vista
     */
    public function setNombrePlantilla($nombrePlantilla)
    {
        $this->nombrePlantilla = $nombrePlantilla;

        return $this;
    }

    /**
     * Get nombrePlantilla
     *
     * @return string
     */
    public function getNombrePlantilla()
    {
        return $this->nombrePlantilla;
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

