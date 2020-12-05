<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Telefono
 */
class Telefono
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $numero;

    /**
     * @var \AppBundle\Entity\Contacto
     */
    private $contacto;

    /**
     * @var \AppBundle\Entity\Etiqueta
     */
    private $etiqueta;

    
    protected $telefono;

    public function __construct() {
        $this->telefono = new ArrayCollection();
    }

    public function __toString() {
        return $this->numero;
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
     * Set numero
     *
     * @param integer $numero
     *
     * @return Telefono
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return integer
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set contacto
     *
     * @param \AppBundle\Entity\Contacto $contacto
     *
     * @return Telefono
     */
    public function setContacto(\AppBundle\Entity\Contacto $contacto = null)
    {
        $this->contacto = $contacto;

        return $this;
    }

    /**
     * Get contacto
     *
     * @return \AppBundle\Entity\Contacto
     */
    public function getContacto()
    {
        return $this->contacto;
    }

    /**
     * Set etiqueta
     *
     * @param \AppBundle\Entity\Etiqueta $etiqueta
     *
     * @return Telefono
     */
    public function setEtiqueta(\AppBundle\Entity\Etiqueta $etiqueta = null)
    {
        $this->etiqueta = $etiqueta;

        return $this;
    }

    /**
     * Get etiqueta
     *
     * @return \AppBundle\Entity\Etiqueta
     */
    public function getEtiqueta()
    {
        return $this->etiqueta;
    }
}

