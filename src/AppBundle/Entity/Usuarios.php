<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @UniqueEntity(fields={"codigo"}, message="El usuario '{{ value }}'' ya existe")
 * @UniqueEntity(fields={"email"}, message="El email '{{ value }}' ya esta en uso")
 */
class Usuarios implements UserInterface
{

    /**
     * @ORM\Column(type="string", length=100, unique=true, nullable=false)
      
    * @Assert\NotBlank(
     *     message="El email no puede estar vacio."
     * )
     * @Assert\NotNull(
     *     message="El email no puede estar vacio."
     * )
      * @Assert\Email(
     *     message = "El email '{{ value }}' no tiene un formato valido."
     * )
     */
    protected $email;

    /**
     * @ORM\Id;
     * @Assert\NotBlank(
     *     message="El codigo de usuario no puede estar vacio."
     * )
     * @Assert\NotNull(
     *     message="El codigo de usuario no puede estar vacio."
     * )
    * @Assert\Length(
     *      min = 5,
     *      max = 9,
     *      minMessage = "El usuario debe tener minimo {{ limit }} caracteres",
     *      maxMessage = "El usuario debe tener maximo {{ limit }} caracteres"
     * )
     * @Assert\Regex(
     *     pattern="/^[a-z0-9]+$/",
     *     match=true,
     *     message="El usuario tiene un formato invalido"
     * )
     * @ORM\Column(type="string", length=9, nullable=false)
     */
    protected $codigo;

    /**
     * @ORM\Column(type="string", length=10, nullable=false)
     */
    protected $rol;

    /**
    * @Assert\NotBlank(
     *     message="La contraseña no puede estar vacio."
     * )
     * @Assert\NotNull(
     *     message="La contraseña no puede estar vacio."
     * )
     * @Assert\Length(
     *      min = 6,
     *      max = 20,
     *      minMessage = "La contraseña debe tener minimo {{ limit }} caracteres",
     *      maxMessage = "La contraseña debe tener maximoo {{ limit }} caracteres"
     * )
 * @Assert\Regex(
     *     pattern="/^[A-Za-z0-9]+$/",
     *     match=true,
     *     message="La contraseña tiene un formato invalido"
     * )

     */
    protected $plainPassword;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $password;

public function create ($codigo,$email,$plainPassword,$rol)
    {
$this->codigo = $codigo;
$this->email = $email;
$this->plainPassword = $plainPassword;
$this->rol = $rol;
    }


    public function eraseCredentials()
    {
        return null;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function setRol($rol = null)
    {
        $this->rol = $rol;
    }

    public function getRoles()
    {
        return [$this->getRol()];
    }


    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getUsername()
    {
        return $this->codigo;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }


    public function getSalt()
    {
        return null;
    }
}