<?php

namespace Ianser\EventosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Eventosxgenero
 *
 * @ORM\Table(name="EventosXGenero", indexes={@ORM\Index(name="fk_evento2", columns={"fkEvento"})})
 * @ORM\Entity
 */
class Eventosxgenero
{
    /**
     * @var string
     *
     * @ORM\Column(name="genero", type="string", length=30, nullable=false)
     */
    private $genero;

    /**
     * @var integer
     *
     * @ORM\Column(name="idEventoXGenero", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ideventoxgenero;

    /**
     * @var \Ianser\EventosBundle\Entity\Eventos
     *
     * @ORM\ManyToOne(targetEntity="Ianser\EventosBundle\Entity\Evento")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fkEvento", referencedColumnName="idEvento")
     * })
     */
    private $fkevento;



    /**
     * Set genero
     *
     * @param string $genero
     * @return Eventosxgenero
     */
    public function setGenero($genero)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return string 
     */
    public function getGenero()
    {
        return $this->genero;
    }

    /**
     * Get ideventoxgenero
     *
     * @return integer 
     */
    public function getIdeventoxgenero()
    {
        return $this->ideventoxgenero;
    }

    /**
     * Set fkevento
     *
     * @param \Ianser\EventosBundle\Entity\Eventos $fkevento
     * @return Eventosxgenero
     */
    public function setFkevento(\Ianser\EventosBundle\Entity\Eventos $fkevento = null)
    {
        $this->fkevento = $fkevento;

        return $this;
    }

    /**
     * Get fkevento
     *
     * @return \Ianser\EventosBundle\Entity\Eventos 
     */
    public function getFkevento()
    {
        return $this->fkevento;
    }
}
