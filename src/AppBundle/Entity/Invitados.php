<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Invitados
 *
 * @ORM\Table(name="invitados", indexes={@ORM\Index(name="graduando", columns={"graduando"})})
 * @ORM\Entity
 * @UniqueEntity(fields="documento", message="El invitado '{{ value }}' ya existe")
 */
class Invitados
{
    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=50, nullable=false)
     */
    private $apellido;

    /**
     * @var boolean
     *
     * @ORM\Column(name="asistencia", type="boolean", nullable=false)
     */
    private $asistencia;

     /**
     * @var integer
     */
    private $anterior;


    /**
     * @var integer
     *
     * @ORM\Column(name="documento", type="bigint", options={"unsigned"=true}, nullable=false)
     * @ORM\Id
     */
    private $documento;

    /**
     * @var \AppBundle\Entity\Graduandos
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Graduandos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="graduando", referencedColumnName="codigo")
     * })
     */
     
    private $graduando;


public function create ($documento,$nombre,$apellido,$documento_anterior,$graduando)
    {
$this->documento = $documento;
$this->nombre = $nombre;
$this->apellido = $apellido;
$this->asistencia = false;
$this->anterior = $documento_anterior;
$this->graduando = $graduando;
    }



    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Invitados
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
     *
     * @return Invitados
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
     * Set asistencia
     *
     * @param boolean $asistencia
     *
     * @return Invitados
     */
    public function setAsistencia($asistencia = false)
    {
        $this->asistencia = $asistencia;

        return $this;
    }

    /**
     * Get asistencia
     *
     * @return boolean
     */
    public function getAsistencia()
    {
        return $this->asistencia;
    }


 /**
     * Set anterior
     *
     * @param integer $anterior
     *
     * @return Invitados
     */
    public function setAnterior($anterior)
    {
        $this->anterior = $anterior;

        return $this;
    }

    /**
     * Get anterior
     *
     * @return integer
     */
    public function getAnterior()
    {
        return $this->anterior;
    }

        /**
     * Set documento
     *
     * @param integer $documento
     *
     * @return Invitados
     */
    public function setDocumento($documento)
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * Get documento
     *
     * @return integer
     */
    public function getDocumento()
    {
        return $this->documento;
    }

    /**
     * Set graduando
     *
     * @param \AppBundle\Entity\Graduandos $graduando
     *
     * @return Invitados
     */
    public function setGraduando(\AppBundle\Entity\Graduandos $graduando = null)
    {
        $this->graduando = $graduando;

        return $this;
    }

    /**
     * Get graduando
     *
     * @return \AppBundle\Entity\Graduandos
     */
    public function getGraduando()
    {
        return $this->graduando;
    }
}
