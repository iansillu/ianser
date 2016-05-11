<?php

namespace Ianser\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Userroles
 *
 * @ORM\Table(name="UserRoles", indexes={@ORM\Index(name="fk_userroles", columns={"fkUser"})})
 * @ORM\Entity
 */
class Userroles
{
    /**
     * @var string
     *
     * @ORM\Column(name="Roles", type="string", length=40, nullable=false)
     */
    private $roles;

    /**
     * @var integer
     *
     * @ORM\Column(name="idUserRoles", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iduserroles;

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
     * Set roles
     *
     * @param string $roles
     * @return Userroles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return string 
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Get iduserroles
     *
     * @return integer 
     */
    public function getIduserroles()
    {
        return $this->iduserroles;
    }

    /**
     * Set fkuser
     *
     * @param \Ianser\UserBundle\Entity\User $fkuser
     * @return Userroles
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
