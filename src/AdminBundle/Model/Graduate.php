<?php

namespace AdminBundle\Model;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Graduandos;
use AppBundle\Entity\Usuarios;
use Doctrine\ORM\Query\ResultSetMapping;

class Graduate
{
protected $em;

    
public function __construct($em)
    {
     $this->em = $em;
    }

    public function guestList()
    {
        $repository = $this->em->getRepository('AppBundle:Graduandos');
 $list = $repository->findBy(array(), array('apellido' => 'ASC'));
 $repository = $this->em->getRepository('AppBundle:Invitados');
 $arreglo = array();
 for($i=0; $i <  count($list); $i++) {
    $graduando = $list[$i];
     $invitados =$repository->findBy(array('graduando' => $graduando->getCodigo()), array('apellido' => 'ASC'));
     if ($invitados!=null) {
        $arreglo[] = array($graduando, $invitados);
     }   
        }   
	 return $arreglo;
    }
   
    public function CareerStatistics()
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('(career.codigo) AS programa','(career.nombre) AS nombre','COUNT(graduate.codigo) AS graduandos');
        $qb->from('AppBundle:Graduandos','graduate');
        $qb->innerJoin('AppBundle:Programas', 'career', 'WITH', 'graduate.programa = career.codigo');
        $qb->groupBy('career.codigo');
        $query = $qb->getQuery();
        return $query->execute();
    }


    public function FacultyStatistics()
    {
  
         $qb = $this->em->createQueryBuilder();
        $qb->select('(faculty.codigo) AS facultad','(faculty.nombre) AS nombre','(faculty.color) AS color','COUNT(graduate.codigo) AS graduandos');
        $qb->from('AppBundle:Graduandos','graduate');
        $qb->innerJoin('AppBundle:Programas', 'career', 'WITH', 'graduate.programa = career.codigo');
        $qb->innerJoin('AppBundle:Facultades', 'faculty', 'WITH', 'career.facultad = faculty.codigo');
        $qb->groupBy('faculty.codigo');
        $query = $qb->getQuery();
        return $query->execute();

    }

    public function graduatesQuery()
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('graduate.codigo','graduate.nombre','graduate.apellido','user.email as email','career.codigo as codigo_programa','career.nombre as nombre_programa');
        $qb->from('AppBundle:Graduandos','graduate');
        $qb->innerJoin('AppBundle:Usuarios', 'user', 'WITH', 'graduate.codigo = user.codigo');        
        $qb->innerJoin('AppBundle:Programas', 'career', 'WITH', 'graduate.programa = career.codigo');
        return $qb->getQuery();
    }  



public function validateFormat($encabezado)
    {
$data = explode(";",$encabezado);
$size = count($data);
if($size == 5 || $size == 6){
        $result =(mb_strtolower(utf8_encode(trim($data[0])), 'UTF-8') == "codigo" || mb_strtolower(utf8_encode(trim($data[0])), 'UTF-8') == "id")
        && (mb_strtolower(utf8_encode(trim($data[1])), 'UTF-8') == "nombre" || mb_strtolower(utf8_encode(trim($data[1])), 'UTF-8') == "nombres")
        && (mb_strtolower(utf8_encode(trim($data[2])), 'UTF-8') == "apellido" || mb_strtolower(utf8_encode(trim($data[2])), 'UTF-8') == "apellidos")
        && (mb_strtolower(utf8_encode(trim($data[3])), 'UTF-8') == "plan"  || mb_strtolower(utf8_encode(trim($data[3])), 'UTF-8') == "programa")
        && (mb_strtolower(utf8_encode(trim($data[4])), 'UTF-8') == "email" || mb_strtolower(utf8_encode(trim($data[4])), 'UTF-8') == "correo");
   if($size == 6){
        $result = $result && (mb_strtolower(utf8_encode(trim($data[5])), 'UTF-8') == "password" || mb_strtolower(utf8_encode(trim($data[5])), 'UTF-8') == "contraseña" || mb_strtolower(utf8_encode(trim($data[5])), 'UTF-8') == "pass");
        return array($result,false);
        } 
return array($result,true);
}
return array(false,false);
    }

    public function removeAll(){
        $qb = $this->em->createQueryBuilder();
        $query = $qb->delete('AppBundle:Invitados', 'invitados')->getQuery();
        $query->execute();
        
        $query = $qb->delete('AppBundle:Graduandos', 'graduandos')->getQuery();
        $query->execute();
        
        $query = $qb->delete('AppBundle:Usuarios ', 'usuarios')
                ->where("usuarios.rol = 'ROLE_USER'")->getQuery();
        $query->execute();
        $this->em->flush();
    }
public function validateData($data,$automatico,$validator)
    {
        $this->removeAll();     
        $errors = array();
        $validation = array();
$graduates = array();
$users = array();
for ($i=1; $i < count($data); $i++) { 
    $row = explode(";",$data[$i]);
    $codigo =  trim($row[0]);
   $nombre =  mb_strtoupper(utf8_encode(trim($row[1])), "UTF-8");
   $apellido =  mb_strtoupper(utf8_encode(trim($row[2])), "UTF-8");
   $programa = trim($row[3]);
   $email = utf8_encode(trim($row[4]));

   if ($automatico) {
        $password =  $codigo;
   }else{
       $password =  utf8_encode(trim($row[5]));
       if ($password == ""){
        $password =  $codigo;
       }
   }

$graduate = new Graduandos();
$graduate->create($codigo,$nombre,$apellido,$programa);

$user = new Usuarios();
$user->create($codigo,$email,$password,"ROLE_USER");

$array1 = $validator->validate($graduate);

$array2 = $validator->validate($user);

if((count($array1)+count($array2)) > 0){
$errors[] = array($array1,$array2);
}else{
    $pro = $this->existePrograma($programa);
        if($pro == null){
            $validation[] = 1;
        }
        $graduate->setPrograma($pro);
$users[] = $user;
$graduates[] = $graduate;
}

}

return array($errors,$graduates,$users,$validation);

}

public function validate($codigo,$nombre,$apellido,$programa,$email,$password,$validator)
{
$graduate = new Graduandos();
$graduate->create($codigo,$nombre,$apellido,$programa);

$user = new Usuarios();
$user->create($codigo,$email,$password,"ROLE_USER");

$array1 = $validator->validate($graduate);

$array2 = $validator->validate($user);

 $errors = array($array1,$array2);

 
  $data = array();

  $data[0] = $errors;
  $data[1] = $graduate;
  $data[2] = $user;

        return $data;

}

public function import($graduates,$users)
    {
        for($i=0; $i < count($users); $i++) { 
      $this->em->persist($graduates[$i]);
      $this->em->persist($users[$i]);
    $this->em->flush();
        }

}

public function insert($graduate,$user)
    {
      $this->em->persist($graduate);
      $this->em->persist($user);
    $this->em->flush();
}

public function existePrograma($cod_programa)
    {
$repository = $this->em->getRepository('AppBundle:Programas');	
return $repository->find($cod_programa);
}

public function existeEmail($codigo,$email)
{
    $qb = $this->em->createQueryBuilder();
    $qb->select('COUNT(user.codigo)');
    $qb->from('AppBundle:Usuarios','user');
    $qb->where('user.email = :email');
    $qb->andWhere('user.codigo != :codigo');
    $qb->setParameters(array('email' => $email, 'codigo' => $codigo));
    $query = $qb->getQuery();
    $users = $query->getSingleScalarResult();
return $users > 0;
}

public function soloLetras($cadena){
    return preg_match('/[^a-zàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð\s]/i', $cadena);
}
public function validarEmail($email){
    return filter_var($email, FILTER_VALIDATE_EMAIL) 
    && preg_match('/@.+\./', $email);
}
public function actualizar($codigo,$nombre,$apellido,$email,$programa){
		$repository = $this->em->getRepository('AppBundle:Graduandos');
			$graduate = $repository->find($codigo);
            $graduate->setNombre($nombre);
            $graduate->setApellido($apellido);
            $graduate->setPrograma($programa);
            $this->em->persist($graduate);

            
            $repository = $this->em->getRepository('AppBundle:Usuarios');
			$user = $repository->find($codigo);
            $user->setEmail($email);
            $this->em->persist($user);
            $this->em->flush();	
		}
		
		public function eliminar($codigo){
           $qb = $this->em->createQueryBuilder();
            $query = $qb->delete('AppBundle:Invitados ', 'invitados')
        ->where("invitados.graduando = ?1")
        ->setParameter(1,$codigo)
        ->getQuery();
$query->execute();
$this->em->flush();

			$repository = $this->em->getRepository('AppBundle:Usuarios');
			$user = $repository->find($codigo);
			$this->em->remove($user);
			$this->em->flush();
            
            $repository = $this->em->getRepository('AppBundle:Graduandos');
			$graduate = $repository->find($codigo);
			$this->em->remove($graduate);
			$this->em->flush();
		}

}