<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Info
 *
 * @ORM\Table(name="info")
 * @ORM\Entity
 * @UniqueEntity(fields={"id"}, message="solo un registro")
 */
class Info
{
    /**
     * @var integer
     *
     * @ORM\Column(name="invitados", type="smallint", unique=true, nullable=false , options={"unsigned"=true} )
     */
    private $invitados;

    /**
     * @var string

     * @ORM\Column(name="password", type="string", length=20, unique=true, nullable=false)
     */
     private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechalimite", type="datetime", unique=true, nullable=false)
     */
    private $fechalimite;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaevento", type="datetime", unique=true, nullable=false)
     */
    private $fechaevento;

    /**
     * @var integer
     *
     * @ORM\Column(name="espacio", type="smallint", unique=true, nullable=false , options={"unsigned"=true})
     */
    private $espacio;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="boolean")
     * @ORM\Id
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="tipo", type="boolean", unique=true, nullable=false)
     */
    private $tipo;


    /**
     * Set invitados
     *
     * @param integer $invitados
     *
     * @return Info
     */
    public function setInvitados($invitados)
    {
        $this->invitados = $invitados;

        return $this;
    }

    /**
     * Get invitados
     *
     * @return integer
     */
    public function getInvitados()
    {
        return $this->invitados;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Info
     */
     public function setPassword($password)
     {
         $this->password = $password;
 
         return $this;
     }
 
     /**
      * Get assword
      *
      * @return string
      */
     public function getPassword()
     {
         return $this->password;
     }

    /**
     * Set fechalimite
     *
     * @param \DateTime $fechalimite
     *
     * @return Info
     */
    public function setFechalimite($fechalimite)
    {
        $this->fechalimite = $fechalimite;

        return $this;
    }

    /**
     * Get fechalimite
     *
     * @return \DateTime
     */
    public function getFechalimite()
    {
        return $this->fechalimite;
    }

    /**
     * Set fechaevento
     *
     * @param \DateTime $fechaevento
     *
     * @return Info
     */
    public function setFechaevento($fechaevento)
    {
        $this->fechaevento = $fechaevento;

        return $this;
    }

    /**
     * Get fechaevento
     *
     * @return \DateTime
     */
    public function getFechaevento()
    {
        return $this->fechaevento;
    }

    /**
     * Set espacio
     *
     * @param integer $espacio
     *
     * @return Info
     */
    public function setEspacio($espacio)
    {
        $this->espacio = $espacio;

        return $this;
    }

    /**
     * Get espacio
     *
     * @return integer
     */
    public function getEspacio()
    {
        return $this->espacio;
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
     * Set tipo
     *
     * @param boolean $tipo
     *
     * @return Invitados
     */
    public function setTipo($tipo = false)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return boolean
     */
    public function getTipo()
    {
        return $this->tipo;
    }
}
