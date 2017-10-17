<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Facultades
 *
 * @ORM\Table(name="facultades")
 * @ORM\Entity
 * @UniqueEntity(fields={"codigo"}, message="La facultad '{{ value }}' ya existe")
 * @UniqueEntity(fields={"nombre"}, message="El nombre '{{ value }}'' ya esta en uso")
 * @UniqueEntity(fields={"color"}, message="El color '{{ value }}'' ya esta en uso")
 */
class Facultades
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
     *      maxMessage = "El nombre '{{ value }}' debe tener maximoo {{ limit }} caracteres"
     * )

* @Assert\Regex(
     *     pattern="/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/",
     *     match=true,
     *     message="El nombre '{{ value }}' solo debe tener letras "
     * )

     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=7, unique=true,  nullable=false)
    * @Assert\NotBlank(
     *     message="El color de facultad no puede estar vacio."
     * )

     * @Assert\NotNull(
     *     message="El color de facultad no puede estar vacio."
     * )

* @Assert\Length(
     *      min = 7,
     *      max = 7,
     *      exactMessage = "El color de facultad '{{ value }}' debe tener exactamente {{ limit }} caracteres",
     * )

      * @Assert\Regex(
     *     pattern="/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/",
     *     match=true,
     *     message="El color de facultad '{{ value }}' tiene un formato invalido"
    * )
    
     */
    private $color;

    /**
     * @var integer
     *
     * @ORM\Column(name="codigo", type="smallint", options={"unsigned"=true}, nullable=false)
     * @ORM\Id
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

     */
    private $codigo;

    public function create ($codigo,$nombre,$color)
    {
$this->codigo = $codigo;
$this->nombre = $nombre;
$this->color = $color;

    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Facultades
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
     * Set color
     *
     * @param string $color
     *
     * @return Facultades
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
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
}
