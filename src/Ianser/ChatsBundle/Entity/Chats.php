<?php

namespace Ianser\ChatsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chats
 *
 * @ORM\Table(name="Chats", indexes={@ORM\Index(name="fk_evento", columns={"fkEvento"})})
 * @ORM\Entity
 */
class Chats
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idChat", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idchat;

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
     * Get idchat
     *
     * @return integer 
     */
    public function getIdchat()
    {
        return $this->idchat;
    }

    /**
     * Set fkevento
     *
     * @param \Ianser\EventosBundle\Entity\Eventos $fkevento
     * @return Chats
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
