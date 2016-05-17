<?php

namespace Ianser\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity
 */
class User implements UserInterface
{

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=45, nullable=false)
     */
    private $username;
    
    /**
     * @var string
     *
     * @ORM\Column(name="roles", type="string", length=100, nullable=false)
     */
    private $roles;
    
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=80, nullable=false)
     */
    private $email;

    
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=45, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=45, nullable=false)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido2", type="string", length=45, nullable=false)
     */
    private $apellido2;

    
    /**
     * @var string
     *
     * @ORM\Column(name="ciudad", type="string", length=100, nullable=false)
     */
    private $ciudad;

    /**
     * @var integer
     *
     * @ORM\Column(name="idUser", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iduser;

    
    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100, nullable=false)
     */
    private $password;
    
    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=300, nullable=false)
     */
    private $salt;
    
    public function setPassword($password){
        $this->password= $password;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function setSalt($salt){
        $this->salt= $salt;
    }

    public function getSalt()
    {
        return $this->salt;
    }
    
    
    /**
     * Set nombre
     *
     * @param string $nombre
     * @return User
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
     * Set apellido
     *
     * @param string $apellido
     * @return User
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set apellido2
     *
     * @param string $apellido2
     * @return User
     */
    public function setApellido2($apellido2)
    {
        $this->apellido2 = $apellido2;

        return $this;
    }

    /**
     * Get apellido2
     *
     * @return string 
     */
    public function getApellido2()
    {
        return $this->apellido2;
    }

    /**
     * Set ciudad
     *
     * @param string $ciudad
     * @return User
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
     * Get iduser
     *
     * @return integer 
     */
    public function getIduser()
    {
        return $this->iduser;
    }
    
    function eraseCredentials(){}
    
    function setRoles($roles){
        $this->roles= $roles;
    }
    
    function getRoles(){
        return array($this->roles);
    }

    function setUserName($username){
        $this->username= $username;
    }
    function getUserName(){
        return $this->username;
    }
    function getEmail(){
        return $this->email;
    }
    function setEmail($email){
        $this->email= $email;
    }
    public function __toString() {
        return $this->nombre;
    }
}
