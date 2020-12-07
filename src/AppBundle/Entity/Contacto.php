<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Contacto
 */
class Contacto
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    protected $telefono;

    public function __construct()
    {
        $this->telefono = new ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Contacto
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
     * Set the value of telefonos
     *
     * @return  self
     */ 
    public function setTelefonos($telefono)
    {
        $this->telefono[] = $telefono;

        return $this;
    }

    /**
     * Get the value of telefonos
     */ 
    public function getTelefono()
    {
        return $this->telefono;
    }

    public function addTelefono(Telefono $telefono)
    {

        $telefono->setContacto($this);

        $this->telefono->add($telefono);
    }

    public function removeTelefono(Telefono $telefono)
    {
        $this->telefono->removeElement($telefono);
    }

}

