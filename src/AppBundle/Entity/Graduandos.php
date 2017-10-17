<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Graduandos
 *
 * @ORM\Table(name="graduandos", indexes={@ORM\Index(name="programa", columns={"programa"})})
 * @ORM\Entity
 * @UniqueEntity(fields="codigo", message="El graduando '{{ value }}' ya existe")
 */
class Graduandos
{
    /**
     * @var string

     * @ORM\Column(name="nombre", type="string", length=50, nullable=false)

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
     * @ORM\Column(name="apellido", type="string", length=50, nullable=false)

* @Assert\NotBlank(
     *     message="El apellido no puede estar vacio."
     * )

     * @Assert\NotNull(
     *     message="El apellido no puede estar vacio."
     * )

* @Assert\Length(
     *      min = 1,
     *      max = 50,
     *      minMessage = "El apellido '{{ value }}' debe tener minimo {{ limit }} caracteres",
     *      maxMessage = "El apellido '{{ value }}' debe tener maximoo {{ limit }} caracteres"
     * )

* @Assert\Regex(
     *     pattern="/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð ,.'-]+$/",
     *     match=true,
     *     message="El apellido '{{ value }}' solo debe tener letras "
     * )

     */
    private $apellido;

    /**
     * @var integer
     *
     * @ORM\Column(name="codigo", type="bigint" , options={"unsigned"=true}, nullable=false)
     * @ORM\Id

* @Assert\NotBlank(
     *     message="El codigo de graduando no puede estar vacio."
     * )

     * @Assert\NotNull(
     *     message="El codigo de graduando no puede estar vacio."
     * )

* @Assert\Length(
     *      min = 9,
     *      max = 9,
     *      exactMessage = "El codigo de graduando '{{ value }}' debe tener exactamente {{ limit }} digitos",
     * )


     * @Assert\Range(
     *      min = 100000000,
     *      max = 999999999,
     *      minMessage = "El codigo de graduando debe ser minimo {{ limit }} ",
     *      maxMessage = "El codigo de graduando debe ser maximo {{ limit }} "
    * )

      * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     match=true,
     *     message="El codigo de graduando '{{ value }}'o solo debe tener numeros"
     * )

     */
    private $codigo;

    /**
     * @var \AppBundle\Entity\Programas
     *
     * 
     * @Assert\NotBlank(
     *     message="El codigo de programa no puede estar vacio."
     * )

     * @Assert\NotNull(
     *     message="El codigo de programa no puede estar vacio."
     * )

* @Assert\Length(
     *      min = 4,
     *      max = 4,
     *      exactMessage = "El codigo de programa '{{ value }}' debe tener exactamente {{ limit }} digitos",
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

     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Programas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="programa", referencedColumnName="codigo")
     * })
     */
    private $programa;


public function create ($codigo,$nombre,$apellido,$programa)
    {
$this->codigo = $codigo;
$this->nombre = $nombre;
$this->apellido = $apellido;
$this->programa = $programa;

    }


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Graduandos
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
     * @return Graduandos
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
     * Get codigo
     *
     * @return integer
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set programa
     *
     * @param \AppBundle\Entity\Programas $programa
     *
     * @return Graduandos
     */
    public function setPrograma(\AppBundle\Entity\Programas $programa = null)
    {
        $this->programa = $programa;

        return $this;
    }

    /**
     * Get programa
     *
     * @return \AppBundle\Entity\Programas
     */
    public function getPrograma()
    {
        return $this->programa;
    }
}
