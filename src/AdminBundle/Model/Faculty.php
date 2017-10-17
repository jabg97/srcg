<?php

namespace AdminBundle\Model;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Facultades;

class Faculty
{
protected $em;

    
public function __construct($em)
    {
     $this->em = $em;
    }

    public function facultiesQuery()
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('faculty');
        $qb->from('AppBundle:Facultades','faculty');
        return $qb->getQuery();
    }  

public function loadFaculties()
    {
  $repository = $this->em->getRepository('AppBundle:Facultades');
 $list = $repository->findAll();
           return  $list; 
    }

    public function insert($faculty)
    {
      $this->em->persist($faculty);
    $this->em->flush();
}

public function actualizar($codigo,$nombre,$color){
    $repository = $this->em->getRepository('AppBundle:Facultades');
        $faculty = $repository->find($codigo);
        $faculty->setNombre($nombre);
        $faculty->setColor($color);
        $this->em->persist($faculty);
        $this->em->flush();		
    }
    
    public function eliminar($codigo){    
        $repository = $this->em->getRepository('AppBundle:Facultades');
        $faculty = $repository->find($codigo);
        $this->em->remove($faculty);
        $this->em->flush();
    }

    public function validate($codigo,$nombre,$color,$validator)
    {
    $faculty = new Facultades();
    $faculty->create($codigo,$nombre,$color);
    
    $errors = $validator->validate($faculty);

      $data = array();
    
      $data[0] = $errors;
      $data[1] = $faculty;
    
            return $data;
    }

    public function cantidadProgramas($facultad)
    {
    $repository = $this->em->getRepository('AppBundle:Programas');	
     return count($repository->findBy(array('facultad' => $facultad))); 
    }
    public function soloLetras($cadena){
        return preg_match('/[^a-zàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð\s]/i', $cadena);
    }
}