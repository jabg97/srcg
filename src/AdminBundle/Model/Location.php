<?php

namespace AdminBundle\Model;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Espacios;

class Location
{
protected $em;

    
public function __construct($em)
    {
     $this->em = $em;
    }


    public function locationsQuery()
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('location');
        $qb->from('AppBundle:Espacios','location');
        return $qb->getQuery();
    }  
    
    public function eliminar($codigo){    
        $repository = $this->em->getRepository('AppBundle:Espacios');
        $location = $repository->find($codigo);
        $this->em->remove($location);
        $this->em->flush();
    }
   
public function searchLocation($codigo)
{
$repository = $this->em->getRepository('AppBundle:Espacios');
return $repository->find($codigo);
}

public function loadLocations()
    {
  $repository = $this->em->getRepository('AppBundle:Espacios');
 $list = $repository->findAll();
           return  $list; 
    }

    public function calculateGuests($capacidad)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('COUNT(graduate.codigo)');
        $qb->from('AppBundle:Graduandos','graduate');
        $query = $qb->getQuery();
        $graduates = $query->getSingleScalarResult();

        if ($graduates <= 0) {
            return 0;
        }else{
            return floor($capacidad/$graduates);
        }
    }


}