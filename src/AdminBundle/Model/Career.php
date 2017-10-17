<?php

namespace AdminBundle\Model;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Programas;

class Career
{
protected $em;

    
public function __construct($em)
    {
     $this->em = $em;
    }



public function loadCareers()
    {
        $repository = $this->em->getRepository('AppBundle:Programas');
 $list = $repository->findBy(array(), array('facultad' => 'ASC'));

    $repository = $this->em->getRepository('AppBundle:Facultades');
    $end = count($list);
    $carreras = array();
   $arreglo = array();
  
   if($end == 0){
    return $arreglo;
        }
        $ultimo = $list[0]->getFacultad()->getCodigo();
   for($i=0; $i < $end; $i++) {
    $faculty = $list[$i]->getFacultad();  
    if($faculty->getCodigo() != $ultimo){
        $faculty = $list[$i-1]->getFacultad();  
        $arreglo[] = array($faculty->getCodigo().") ".$faculty->getNombre(),$carreras);
        $carreras = array();
        $ultimo = $list[$i]->getFacultad()->getCodigo();
    }             
    $carreras[] = $list[$i];
    
         }
         if(count($carreras) > 0){
            $arreglo[] = array($faculty->getCodigo().") ".$faculty->getNombre(),$carreras);
                }      
	 return $arreglo;
    }


 public function careersQuery()
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('career');
        $qb->from('AppBundle:Programas','career');
        $qb->join('career.facultad', 'faculty');
        return $qb->getQuery();
    }  

    public function validate($codigo,$nombre,$facultad,$validator)
    {
    $career = new Programas();
    $career->create($codigo,$nombre,$facultad);
    
    $errors = $validator->validate($career);

      $data = array();
    
      $data[0] = $errors;
      $data[1] = $career;
    
            return $data;
    }

    public function soloLetras($cadena){
        return preg_match('/[^a-zàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð\s]/i', $cadena);
    }

    public function insert($career)
    {
      $this->em->persist($career);
    $this->em->flush();
}

public function actualizar($codigo,$nombre,$facultad){
    $repository = $this->em->getRepository('AppBundle:Programas');
        $career = $repository->find($codigo);
        $career->setNombre($nombre);
        $career->setFacultad($facultad);
        $this->em->persist($career);
        $this->em->flush();		
    }
    
    public function eliminar($codigo){    
        $repository = $this->em->getRepository('AppBundle:Programas');
        $career = $repository->find($codigo);
        $this->em->remove($career);
        $this->em->flush();
    }

public function existeFacultad($cod_facultad)
    {
$repository = $this->em->getRepository('AppBundle:Facultades');	
return $repository->find($cod_facultad);
}
public function cantidadGraduandos($programa)
{
$repository = $this->em->getRepository('AppBundle:Graduandos');	
return count($repository->findBy(array('programa' => $programa))); 
}
    
}