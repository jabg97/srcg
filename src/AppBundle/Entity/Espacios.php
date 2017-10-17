<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Espacios
 *
 * @ORM\Table(name="espacios")
 * @ORM\Entity
 * @UniqueEntity(fields="codigo", message="El espacio '{{ value }}' ya existe")
* @UniqueEntity(fields={"nombre"}, message="El nombre '{{ value }}'' ya esta en uso")
 * @UniqueEntity(fields={"direccion"}, message="La direccion '{{ value }}'' ya esta en uso")
 */
class Espacios
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

     * @ORM\Column(name="direccion", type="string", length=50, nullable=false , unique=true)

* @Assert\NotBlank(
     *     message="La direccion no puede estar vacia."
     * )

     * @Assert\NotNull(
     *     message="La direccion no puede estar vacia."
     * )

* @Assert\Length(
     *      min = 1,
     *      max = 50,
     *      minMessage = "La direccion '{{ value }}' debe tener minimo {{ limit }} caracteres",
     *      maxMessage = "La direccion '{{ value }}' debe tener maximoo {{ limit }} caracteres"
     * )

     */
    private $direccion;

    /**
     * @var integer
     *
     * @ORM\Column(name="capacidad", type="smallint", nullable=false , options={"unsigned"=true})
      * @Assert\NotBlank(
     *     message="La capacidad del establecimiento no puede estar vacia."
     * )

     * @Assert\NotNull(
     *     message="La capacidad del establecimiento no puede estar vacia."
     * )

* @Assert\Length(
     *      min = 1,
     *      max = 6,
     *      minMessage = "La capacidad '{{ value }}' debe tener minimo {{ limit }} digitos",
     *      maxMessage = "La capacidad '{{ value }}' debe tener maximo {{ limit }} digitos"
    * )

* @Assert\Range(
     *      min = 1,
     *      max = 999999,
     *      minMessage = "La capacidad debe ser minimo {{ limit }} ",
     *      maxMessage = "La capacidad debe ser aximo {{ limit }} "
    * )

      * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     match=true,
     *     message="La capacidad del establecimiento '{{ value }}' solo debe tener numeros"
     * )
     */
    private $capacidad;

    /**
     * @var integer
     *
     * @ORM\Column(name="zonas", type="smallint", nullable=false , options={"unsigned"=true})
    
     * @Assert\NotBlank(
     *     message="La cantidad de zonas no puede estar vacia."
     * )

     * @Assert\NotNull(
     *     message="La cantidad de zonas no puede estar vacia."
     * )

* @Assert\Range(
     *      min = 1,
     *      max = 3,
     *      minMessage = "El establecimiento debe tener minimo {{ limit }} zona",
     *      maxMessage = "El establecimiento debe tener maximo {{ limit }} zonas"
    * )

    * @Assert\Length(
     *      min = 1,
     *      max = 1,
     *      exactMessage = "La cantidad de zonas '{{ value }}' debe tener exactamente {{ limit }} digitos"
     * )

      * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     match=true,
     *     message="La cantidad de zonas '{{ value }}' solo debe tener numeros"
     * )
     */
    private $zonas;

    /**
     * @var integer
     *
     * @ORM\Column(name="filas", type="smallint", nullable=false , options={"unsigned"=true})
     
     * @Assert\NotBlank(
     *     message="La cantidad de filas no puede estar vacia."
     * )

     * @Assert\NotNull(
     *     message="La cantidad de filas no puede estar vacia."
     * )

* @Assert\Length(
     *      min = 1,
     *      max = 3,
     *      minMessage = "La cantidad de filas '{{ value }}' debe tener minimo {{ limit }} digitos",
     *      maxMessage = "La cantidad de filas '{{ value }}' debe tener maximo {{ limit }} digitos"
    * )

   * @Assert\Range(
     *      min = 1,
     *      max = 999,
     *      minMessage = "La cantidad de filas debe ser minimo {{ limit }} ",
     *      maxMessage = "La cantidad de filas debe ser maximo {{ limit }} "
    * )

      * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     match=true,
     *     message="La cantidad de filas '{{ value }}' solo debe tener numeros"
     * )
     */
    private $filas;

    /**
     * @var integer
     *
     * @ORM\Column(name="columnas", type="smallint", nullable=false , options={"unsigned"=true})
      * @Assert\NotBlank(
     *     message="La cantidad de columnas no puede estar vacia."
     * )

     * @Assert\NotNull(
     *     message="La cantidad de columnas no puede estar vacia."
     * )

* @Assert\Length(
     *      min = 1,
     *      max = 3,
     *      minMessage = "La cantidad de columnas '{{ value }}' debe tener minimo {{ limit }} digitos",
     *      maxMessage = "La cantidad de columnas '{{ value }}' debe tener maximo {{ limit }} digitos"
    * )

  * @Assert\Range(
     *      min = 1,
     *      max = 999,
     *      minMessage = "La cantidad de columnas debe ser minimo {{ limit }} ",
     *      maxMessage = "La cantidad de columnas debe ser maximo {{ limit }} "
    * )

      * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     match=true,
     *     message="La cantidad de columnas '{{ value }}' solo debe tener numeros"
     * )
     */
    
    private $columnas;

    /**
     * @var integer
     *
     * @ORM\Column(name="codigo", type="smallint", options={"unsigned"=true})
     * @ORM\Id
      * @Assert\NotBlank(
     *     message="El codigo del establecimiento no puede estar vacio."
     * )

     * @Assert\NotNull(
     *     message="El codigo del establecimiento no puede estar vacio."
     * )

* @Assert\Length(
     *      min = 1,
     *      max = 2,
     *      minMessage = "El codigo del establecimiento '{{ value }}' debe tener minimo {{ limit }} digitos",
     *      maxMessage = "El codigo del establecimiento '{{ value }}' debe tener maximo {{ limit }} digitos"
    * )

    * @Assert\Range(
     *      min = 1,
     *      max = 99,
     *      minMessage = "El codigo del establecimiento  debe ser minimo {{ limit }} ",
     *      maxMessage = "El codigo del establecimiento  debe ser maximo {{ limit }} "
    * )

      * @Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     match=true,
     *     message="El codigo del establecimiento '{{ value }}' solo debe tener numeros"
    * )
    */
    private $codigo;

      /**
     * @Assert\File(
     *     binaryFormat = "false",
     *     maxSize = "512k",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Por favor sube un archivo en formato PDF",
     *     maxSizeMessage = "El tamaño del mapa es muy grande ({{ size }} {{ suffix }}). El Tamaño maximo es {{ limit }} {{ suffix }}."
     * )
     */
     protected $map;

/**
     * @Assert\Image(
     *     binaryFormat = "false",
     *     maxSize = "512k",
     *     minWidth = 600,
     *     maxWidth = 600,
     *     minHeight = 400,
     *     maxHeight = 400,
     *     mimeTypes = {"image/jpeg", "image/pjpeg"},
     *     mimeTypesMessage = "Por favor sube un archivo en formato JPG o JPEG",
     *     sizeNotDetectedMessage = "El tamaño de la imagen no puede ser detectado",
     *     minWidthMessage = "El ancho de la imagen es muy pequeño ({{ width }}px) y debe ser exactamente de {{ min_width }}px.",
     *     maxWidthMessage = "El ancho de la imagen es muy grande ({{ width }}px) y debe ser exactamente de {{ max_width }}px.",
     *     minHeightMessage = "El alto de la imagen es muy pequeño ({{ height }}px) y debe ser exactamente de {{ min_height }}px.",
     *     maxHeightMessage = "El alto de la imagen es muy grande ({{ height }}px) y debe ser exactamente de {{ max_height }}px.",
     *     maxSizeMessage = "El tamaño de la imagen es muy grande ({{ size }} {{ suffix }}). El Tamaño maximo es {{ limit }} {{ suffix }}."
     * )
     */
     protected $image;


    public function setMap(File $map = null)
    {
        $this->map = $map;
    }

    public function getMap()
    {
        return $this->map;
    }

    public function setImage(File $image = null)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }


    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Espacios
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
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Espacios
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set capacidad
     *
     * @param integer $capacidad
     *
     * @return Espacios
     */
    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    /**
     * Get capacidad
     *
     * @return integer
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * Set zonas
     *
     * @param integer $zonas
     *
     * @return Espacios
     */
    public function setZonas($zonas)
    {
        $this->zonas = $zonas;

        return $this;
    }

    /**
     * Get zonas
     *
     * @return integer
     */
    public function getZonas()
    {
        return $this->zonas;
    }

    /**
     * Set filas
     *
     * @param integer $filas
     *
     * @return Espacios
     */
    public function setFilas($filas)
    {
        $this->filas = $filas;

        return $this;
    }

    /**
     * Get filas
     *
     * @return integer
     */
    public function getFilas()
    {
        return $this->filas;
    }

    /**
     * Set columnas
     *
     * @param integer $columnas
     *
     * @return Espacios
     */
    public function setColumnas($columnas)
    {
        $this->columnas = $columnas;

        return $this;
    }

    /**
     * Get columnas
     *
     * @return integer
     */
    public function getColumnas()
    {
        return $this->columnas;
    }

    /**
     * Set codigo
     *
     * @param integer $codigo
     *
     * @return Espacios
     */
     public function setCodigo($codigo)
     {
         $this->codigo = $codigo;
 
         return $this;
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
