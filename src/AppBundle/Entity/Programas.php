<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Programas
 *
 * @ORM\Table(name="programas", indexes={@ORM\Index(name="facultad", columns={"facultad"})})
 * @ORM\Entity
* @UniqueEntity(fields={"codigo"}, message="El programa academico '{{ value }}' ya existe")
 * @UniqueEntity(fields={"nombre"}, message="El nombre '{{ value }}' ya esta en uso")
 */
class Programas
{
    /**
     * @var string

     * @ORM\Column(name="nombre", type="string", length=50, nullable=false , unique=true)

* @Assert\NotBlank(
     *     message="El nombre no puede estar vacio."
     * )

     * @Assert\NotNull(
     *     message="El nombre no puede estar vacio."
     * )

* @Assert\Length(
     *      min = 1,
     *      max = 50,
     *      minMessage = "El nombre '{{ value }}' debe tener minimo {{ limit }} caracteres",
     *      maxMessage = "El nombre '{{ value }}' debe tener maximo {{ limit }} caracteres"
     * )

* @Assert\Regex(
     *     pattern="/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/",
     *     match=true,
     *     message="El nombre '{{ value }}' solo debe tener letras "
     * )

     */
    private $nombre;

     /**
     * @var integer
     *
     * @ORM\Column(name="codigo", type="smallint", options={"unsigned"=true}, nullable=false)
     * @ORM\Id
     * @Assert\NotBlank(
     *     message="El codigo de programa no puede estar vacio."
     * )

     * @Assert\NotNull(
     *     message="El codigo de programa no puede estar vacio."
     * )

* @Assert\Length(
     *      min = 4,
     *      max = 4,
     *      exactMessage = "El codigo de programa '{{ value }}' debe tener exactamente {{ limit }} digitos"
     * )


    * @Assert\Range(
     *      min = 1000,
     *      max = 9999,
     *      minMessage = "El codigo de programa debe ser minimo {{ limit }} ",
     *      maxMessage = "El codigo de programa debe ser maximo {{ limit }} "
    * )


      * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     match=true,
     *     message="El codigo de programa '{{ value }}' solo debe tener numeros"
     * )
     */
    private $codigo;

    /**
     * @var \AppBundle\Entity\Facultades
     *
      * @Assert\NotBlank(
     *     message="El codigo de facultad no puede estar vacio."
     * )

     * @Assert\NotNull(
     *     message="El codigo de facultad no puede estar vacio."
     * )

* @Assert\Length(
     *      min = 1,
     *      max = 2,
     *      minMessage = "El codigo '{{ value }}' debe tener minimo {{ limit }} digitos",
     *      maxMessage = "El codigo '{{ value }}' debe tener maximo {{ limit }} digitos"
    * )

     * @Assert\Range(
     *      min = 1,
     *      max = 99,
     *      minMessage = "El codigo de facultad debe ser minimo {{ limit }} ",
     *      maxMessage = "El codigo de facultad debe ser maximo {{ limit }} "
    * )


      * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     match=true,
     *     message="El codigo de facultad '{{ value }}' solo debe tener numeros"
    * )

     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Facultades")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="facultad", referencedColumnName="codigo")
     * })
     */
    private $facultad;
     
    public function create ($codigo,$nombre,$facultad)
    {
$this->codigo = $codigo;
$this->nombre = $nombre;
$this->facultad = $facultad;

    }



    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Programas
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
     * Get codigo
     *
     * @return integer
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set facultad
     *
     * @param \AppBundle\Entity\Facultades $facultad
     *
     * @return Programas
     */
    public function setFacultad(\AppBundle\Entity\Facultades $facultad = null)
    {
        $this->facultad = $facultad;

        return $this;
    }

    /**
     * Get facultad
     *
     * @return \AppBundle\Entity\Facultades
     */
    public function getFacultad()
    {
        return $this->facultad;
    }
}
