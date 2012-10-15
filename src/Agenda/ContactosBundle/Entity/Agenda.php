<?php

namespace Agenda\ContactosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agenda\BackendBundle\Entity\Agenda
 *
 * @ORM\Table(name="agenda")
 * @ORM\Entity
 */
class Agenda
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $nombres
     *
     * @ORM\Column(name="nombres", type="string", length=80, nullable=false)
     */
    private $nombres;

    /**
     * @var string $apellidos
     *
     * @ORM\Column(name="apellidos", type="string", length=80, nullable=false)
     */
    private $apellidos;

    /**
     * @var string $email
     *
     * @ORM\Column(name="email", type="string", length=60, nullable=true)
     */
    private $email;

    /**
     * @var Usuario
     *
     * @ORM\ManyToOne(targetEntity="Agenda\UsuariosBundle\Entity\Usuario" )
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id" )
     * })
     */
    private $usuario;

    
   /**
     * @ORM\OneToMany(targetEntity="Numeros", mappedBy="agenda", cascade={"persist", "remove"})
     */
    private $numeros;

    public function __construct()
    {
      $this->numeros = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function __toString()
    {
        return $this->getNombres();
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
     * Set nombres
     *
     * @param string $nombres
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }

    /**
     * Get nombres
     *
     * @return string 
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set apellidos
     *
     * @param string $apellidos
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set usuario
     *
     * @param Agenda\BackendBundle\Entity\Usuario $usuario
     */
    public function setUsuario(\Agenda\UsuariosBundle\Entity\Usuario $usuario)
    {
        $this->usuario = $usuario;
    }

    /**
     * Get usuario
     *
     * @return Agenda\BackendBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
    
    public function addNumero(\Agenda\ContactosBundle\Entity\Numeros $numero)
    {
        $numero->setAgenda($this);
        $this->numeros[]=$numero;
    }
    public function getNumeros()
    {
        return $this->numeros;
    }
    
    
}