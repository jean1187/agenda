<?php

namespace Agenda\ContactosBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Agenda\BackendBundle\Entity\Numeros
 *
 * @ORM\Table(name="numeros")
 * @ORM\Entity
 */
class Numeros
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
     * @var string $numero
     *
     * @ORM\Column(name="numero", type="string", length=11, nullable=false)
     */
    private $numero;

    /**
     * @var Agenda
     *
     * @ORM\ManyToOne(targetEntity="Agenda" , cascade={"persist", "remove"}, inversedBy="numeros", cascade={"ALL"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="agenda_id", referencedColumnName="id" )
     * })
     */
    private $agenda;



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
     * Set numero
     *
     * @param string $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set agenda
     *
     * @param Agenda\BackendBundle\Entity\Agenda $agenda
     */
    public function setAgenda(\Agenda\ContactosBundle\Entity\Agenda $agenda)
    {
        $this->agenda = $agenda;
    }

    /**
     * Get agenda
     *
     * @return Agenda\BackendBundle\Entity\Agenda 
     */
    public function getAgenda()
    {
        return $this->agenda;
    }
}