<?php

namespace GraduateBundle\Model;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Invitados;
use AppBundle\Entity\Graduandos;

class Guest
{
protected $em;

    
public function __construct($em)
    {
     $this->em = $em;
    }



public function searchGuests($codigo)
    {
		$repository = $this->em->getRepository('AppBundle:Invitados');
		return $repository->findBy(
             array('graduando'=> $codigo), 
             array('apellido' => 'ASC'));
	}

	public function graduateInfo($codigo)
    {
		$repository = $this->em->getRepository('AppBundle:Graduandos');
		return $repository->find($codigo);
	}

public function loadGuests($codigo,$size,$men)
    {
        $info = array();
$invitation = true;
  
 $list = $this->searchGuests($codigo);
  if ($list == null) {
      for($i = 0; $i < $size; $i++){   
$list[$i] = new Invitados();      
}  
$invitation = false;
  }else{
      $final = count($list);
      $distance = $size-$final;
 for($i = 0; $i < $distance; $i++){  
$list[$final+$i] = new Invitados();      
}  
  }

$info[0] = $list;


$var = explode('-',$men,$size);

  if (count($var) == 1) {
      for($i = 0; $i < $size; $i++){   
$var[$i] = 'N';   
   $mostrar = false;
}  

  }else{
      $mostrar = true;
      $final = count($var);
      $distance = $size-$final;
 for($i = 0; $i < $distance; $i++){  
$var[$final+$i] = 'N';      
}  
  }


	$messages = array();
	$icons = array();
      	for($i = 0; $i < $size; $i++){  
              
      		if($var[$i] == 'R'){
      			$messages[] = "El invitado #".($i+1)." ha sido Registrado.";
      			$icons[] = 'R';			
				}else if($var[$i] == 'A'){
					$messages[] = "El invitado #".($i+1)." ha sido Actualizado.";
					$icons[] = 'A';	
					}else if($var[$i] == 'E'){
					$messages[] = "El invitado #".($i+1)." ha sido Eliminado.";
					$icons[] = 'E';	
				}else if($var[$i] == 'I'){
					$messages[] = "Error! el invitado #".($i+1)." tiene datos incompletos.";
					$icons[] = 'I';	
				}else if($var[$i] == 'V'){
					$messages[] = "Error! el invitado #".($i+1)." no tiene un Documento válido.";
					$icons[] = 'V';	
					}else if($var[$i] == 'P'){
					$messages[] = "El invitado #".($i+1)." ya Existe.";
					$icons[] = 'P';	
				}
				else if($var[$i] == 'N' || $var[$i] == NULL){
					
				}else{
					return null;
				}	
	//echo$messages[$i]."<br>";
			}


  if (count($messages) == 0) {
   $mostrar = false;
  }

$info[1] = $messages;
$info[2] = $icons;
$info[3] = count($messages);
$info[4] =$mostrar;
$info[5] =$invitation;
           return  $info; 
    }


	
public function register($request,$codigo){
  
$respuesta = "";
$size= $request->request->get('cantidad');
$repository = $this->em->getRepository('AppBundle:Graduandos');
$graduando = $repository->find($codigo);
for($i = 1; $i <= $size; $i++){
   $documento =  trim($request->request->get('documento'.$i));
   $nombre =  mb_strtoupper(trim($request->request->get('nombre'.$i)), "UTF-8");
   $apellido =  mb_strtoupper(trim($request->request->get('apellido'.$i)), "UTF-8");
   $documento_anterior = trim($request->request->get('anterior'.$i));
   
if($this->validar($documento,$nombre,$apellido)){
$respuesta .= 'I-';
continue;
}

if($this->numero($documento,$nombre,$apellido)){
	$respuesta .= 'V-';
	continue;
}

$invitado = new Invitados();
$invitado->create($documento,$nombre,$apellido,$documento_anterior,$graduando);

$respuesta .= $this->respuesta($invitado).'-';
}
return substr($respuesta,0,-1);

	}
	
	
	
private function respuesta($invitado){

 if ($invitado->getAnterior() == "") {

if($this->vacio($invitado)){		
	return 'N';
		}

       if($this->existe($invitado)){
	   		return 'P';
	   }else{
		   return $this->crear($invitado);
	   }
    }
		return $this->validar_anterior($invitado);
	}


public function crear($invitado){
	$this->em->persist($invitado);
    $this->em->flush();
			return 'R';	
		}
		
		
		public function actualizar($invitado){
			$qb = $this->em->createQueryBuilder();
$query = $qb->update('AppBundle:Invitados', 'invitados')
        ->set('invitados.documento', '?1')
        ->set('invitados.nombre', '?2')
		->set('invitados.apellido', '?3')
        ->where('invitados.documento = ?4')
        ->setParameter(1, $invitado->getDocumento())
        ->setParameter(2, $invitado->getNombre())
        ->setParameter(3, $invitado->getApellido())
		->setParameter(4, $invitado->getAnterior())
        ->getQuery();
$query->execute();
			return 'A';			
		}
		
		public function eliminar($invitado){
			$repository = $this->em->getRepository('AppBundle:Invitados');
			$guest = $repository->find($invitado->getAnterior());
			$this->em->remove($guest);
			$this->em->flush();
			return 'E';
		}

private function existe($invitado){
	$repository = $this->em->getRepository('AppBundle:Invitados');	
$guest = $repository->find($invitado->getDocumento());
		return $guest != null;
}

private function validar_anterior($invitado){

if($this->vacio($invitado)){		
	return $this->eliminar($invitado);
		}

	$repository = $this->em->getRepository('AppBundle:Invitados');	
$anterior = $repository->find($invitado->getAnterior());
		if($anterior == null){
			return 'N';
		}


if(!$this->igual($invitado,$anterior)){
	return $this->actualizar($invitado);
}
return 'N';
}

private function vacio($invitado){
return empty($invitado->getDocumento()) &&  empty($invitado->getNombre()) && empty($invitado->getApellido());
}
private function igual($invitado,$anterior){
return $anterior->getDocumento() == $invitado->getDocumento() && $anterior->getNombre() == $invitado->getNombre() && $anterior->getApellido() == $invitado->getApellido();
}

private function numero($documento,$nombre,$apellido){
return !ctype_digit($documento) && !empty($nombre) && !empty($apellido);			
		}	

private	function validar($documento,$nombre,$apellido){
return (empty($documento) XOR empty($nombre)) ||  (empty($documento) XOR empty($apellido));		
		}

}