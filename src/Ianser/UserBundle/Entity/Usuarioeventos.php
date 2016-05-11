<?php

namespace Ianser\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuarioeventos
 *
 * @ORM\Table(name="UsuarioEventos", indexes={@ORM\Index(name="fk_user3", columns={"fkUser"}), @ORM\Index(name="fk_evento1", columns={"fkEvento"})})
 * @ORM\Entity
 */
class Usuarioeventos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idUsuarioEvento", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idusuarioevento;

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
     * @var \Ianser\EventosBundle\Entity\Eventos
     *
     * @ORM\ManyToOne(targetEntity="Ianser\EventosBundle\Entity\Eventos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fkEvento", referencedColumnName="idEvento")
     * })
     */
    private $fkevento;



    /**
     * Get idusuarioevento
     *
     * @return integer 
     */
    public function getIdusuarioevento()
    {
        return $this->idusuarioevento;
    }

    /**
     * Set fkuser
     *
     * @param \Ianser\UserBundle\Entity\User $fkuser
     * @return Usuarioeventos
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

    /**
     * Set fkevento
     *
     * @param \Ianser\EventosBundle\Entity\Eventos $fkevento
     * @return Usuarioeventos
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
