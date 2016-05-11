<?php

namespace Ianser\ChatsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mensajes
 *
 * @ORM\Table(name="Mensajes", indexes={@ORM\Index(name="fk_chat2", columns={"fkChat"}), @ORM\Index(name="fk_user2", columns={"fkUser"})})
 * @ORM\Entity
 */
class Mensajes
{
        
    
    /**
     * @var string
     *
     * @ORM\Column(name="texto", type="string", length=10000, nullable=false)
     */
    private $texto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="hora", type="datetime", nullable=false)
     */
    private $hora;

    /**
     * @var integer
     *
     * @ORM\Column(name="idMensaje", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmensaje;

    /**
     * @var \Ianser\ChatsBundle\Entity\Chats
     *
     * @ORM\ManyToOne(targetEntity="Ianser\ChatsBundle\Entity\Chats")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fkChat", referencedColumnName="idChat")
     * })
     */
    private $fkchat;

    /**
     * @var \Ianser\ChatsBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Ianser\UserBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fkUser", referencedColumnName="idUser")
     * })
     */
    private $fkuser;



    /**
     * Set texto
     *
     * @param string $texto
     * @return Mensajes
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string 
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     * @return Mensajes
     */
    public function setHora($hora)
    {
        $this->hora = $hora;

        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime 
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Get idmensaje
     *
     * @return integer 
     */
    public function getIdmensaje()
    {
        return $this->idmensaje;
    }

    /**
     * Set fkchat
     *
     * @param \Ianser\ChatsBundle\Entity\Chats $fkchat
     * @return Mensajes
     */
    public function setFkchat(\Ianser\ChatsBundle\Entity\Chats $fkchat = null)
    {
        $this->fkchat = $fkchat;

        return $this;
    }

    /**
     * Get fkchat
     *
     * @return \Ianser\ChatsBundle\Entity\Chats 
     */
    public function getFkchat()
    {
        return $this->fkchat;
    }

    /**
     * Set fkuser
     *
     * @param \Ianser\UserBundle\Entity\User $fkuser
     * @return Mensajes
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
