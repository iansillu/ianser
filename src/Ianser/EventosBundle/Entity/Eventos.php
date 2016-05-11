<?php

namespace Ianser\EventosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eventos
 *
 * @ORM\Table(name="Eventos", indexes={@ORM\Index(name="fk_user4", columns={"fkUser"})})
 * @ORM\Entity
 */
class Eventos
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=60, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="dirImagen", type="string", length=300, nullable=false)
     */
    private $dirimagen;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=45, nullable=false)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="ciudad", type="string", length=45, nullable=false)
     */
    private $ciudad;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=800, nullable=false)
     */
    private $descripcion;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=50, nullable=false)
     */
    private $tipo;

    /**
     * @var integer
     *
     * @ORM\Column(name="idEvento", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idevento;

    /**
     * @var \Ianser\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Ianser\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fkUser", referencedColumnName="idUser")
     * })
     */
    private $fkuser;



    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Eventos
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
     * Set dirimagen
     *
     * @param string $dirimagen
     * @return Eventos
     */
    public function setDirimagen($dirimagen)
    {
        $this->dirimagen = $dirimagen;

        return $this;
    }

    /**
     * Get dirimagen
     *
     * @return string 
     */
    public function getDirimagen()
    {
        return $this->dirimagen;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Eventos
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set ciudad
     *
     * @param string $ciudad
     * @return Eventos
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Eventos
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Eventos
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Get idevento
     *
     * @return integer 
     */
    public function getIdevento()
    {
        return $this->idevento;
    }

    /**
     * Set fkuser
     *
     * @param \Ianser\UserBundle\Entity\User $fkuser
     * @return Eventos
     */
    public function setFkuser(\Ianser\UserBundle\Entity\User $fkuser = null)
    {
        $this->fkuser = $fkuser;

        return $this;
    }

    /**
     * Get fkuser
     *
     * @return \Ianser\UserBundle\Entity\User 
     */
    public function getFkuser()
    {
        return $this->fkuser;
    }
}