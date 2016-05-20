<?php

namespace Ianser\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuariochats
 *
 * @ORM\Table(name="UsuarioChats", indexes={@ORM\Index(name="fk_usuariochats", columns={"fkUser"}), @ORM\Index(name="fk_chat", columns={"fkChat"})})
 * @ORM\Entity
 */
class Usuariochats
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idUsuarioChats", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idusuariochats;

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
     * @var \Ianser\UserBundle\Entity\Chats
     *
     * @ORM\ManyToOne(targetEntity="Ianser\ChatsBundle\Entity\Chats")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fkChat", referencedColumnName="idChat")
     * })
     */
    private $fkchat;



    /**
     * Get idusuariochats
     *
     * @return integer 
     */
    public function getIdusuariochats()
    {
        return $this->idusuariochats;
    }

    /**
     * Set fkuser
     *
     * @param \Ianser\UserBundle\Entity\User $fkuser
     * @return Usuariochats
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
     * Set fkchat
     *
     * @param \Ianser\ChatsBundle\Entity\Chats $fkchat
     * @return Usuariochats
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
}
