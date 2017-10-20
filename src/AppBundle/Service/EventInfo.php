<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;

class EventInfo 
{
private $meses;
protected $em;

    
public function __construct($em)
    {
     $this->em = $em;
$this->meses  = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
    }

    public function sendEmail()
    {
      $repository = $this->em->getRepository('AppBundle:Info');
      $info =  $repository->find(1);
    return $info->getEmail();
    }


    public function eventDate()
    {

  $repository = $this->em->getRepository('AppBundle:Info');
  $info =  $repository->find(1);

            $evento = $info->getFechaEvento(); 
            $espacio = $info->getEspacio();



$repository = $this->em->getRepository('AppBundle:Espacios');
 
 $data = array();
 
 $location = $repository->find($espacio);
 $data[0] =  $location->getCodigo();
  $data[1] =  mb_strtoupper($location->getNombre(), "UTF-8");

$dia = $evento->format('d');
$nom_mes =$this->meses[$evento->format('m')-1];
$data[2] = $evento->format('Y');


$data[3] = $dia." DE ".$nom_mes." DEL ".$data[2];
$data[4] = $evento->format('h:i A');
$data[5] = mb_strtoupper($location->getDireccion(), "UTF-8");

return $data;
    }

public function limitDate()
    {
        
  $repository = $this->em->getRepository('AppBundle:Info');
            $limite = $repository->find(1)->getFechaLimite(); 
$data = array();

$dia = $limite->format('d');
$nom_mes =$this->meses[$limite->format('m')-1];
$anio = $limite->format('Y');


$data[0] = $dia." DE ".$nom_mes." DEL ".$anio;
$data[1] = $limite->format('h:i A');

return $data;
    }


    public function limitGuests()
    {
        
  $repository = $this->em->getRepository('AppBundle:Info');
return $repository->find(1)->getInvitados(); 
    }
    
    public function registerGuest($guest)
    {
    $guest->setAsistencia(1);
    $this->em->persist($guest);
  $this->em->flush();
    }
    public function invitation()
    {
        
  $repository = $this->em->getRepository('AppBundle:Info');
return $repository->find(1)->getTipo(); 
    }

    public function getPassword(){       
  $repository = $this->em->getRepository('AppBundle:Info');
return $repository->find(1)->getPassword(); 
    }

    public function validate($documento)
    {     
  $repository = $this->em->getRepository('AppBundle:Invitados');
return $repository->find($documento); 
    }

    public function syncData()
    {     
  $qb = $this->em->createQueryBuilder();
  $qb->select('graduate.codigo','graduate.nombre','graduate.apellido','career.nombre as programa');
  $qb->from('AppBundle:Graduandos','graduate');
  $qb->innerJoin('AppBundle:Programas', 'career', 'WITH', 'graduate.programa = career.codigo'); 
  $qb->orderBy('graduate.apellido', 'ASC');
  $graduates = $qb->getQuery()->getResult();
  $info = array();

  foreach ($graduates as $graduate){ 
    $qb = $this->em->createQueryBuilder();
    $qb->select('guest.documento','guest.nombre','guest.apellido','guest.asistencia');
    $qb->from('AppBundle:Invitados','guest');
    $qb->where('guest.graduando = :codigo');
    $qb->setParameters(array('codigo' => $graduate['codigo']));
    $qb->orderBy('guest.apellido', 'ASC');
    $guests = $qb->getQuery()->getResult();

          if ($guests!=null) {
          $info[] = array($graduate,$guests);
        }   
}
return $info; 
    }

    public function searchGraduate($buscar)
    {  
    $query = $this->em->getRepository("AppBundle:Graduandos")->createQueryBuilder('graduate')
    ->where('graduate.nombre LIKE :buscar')
    ->orWhere('graduate.apellido LIKE :buscar')
    ->setParameter('buscar', '%'.$buscar.'%')
    ->getQuery();
    return $query->getResult();
}


}