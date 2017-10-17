<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AdminBundle\Model\Graduate;
use AdminBundle\Model\Career;
use AdminBundle\Model\Location;
use AdminBundle\Model\Event;
use AdminBundle\Model\Faculty;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ActionController extends Controller
{
   
    public function send($data,$graduate,$user)
    {
        $message = (new \Swift_Message('Contraseña'))
        ->setFrom('horariotps39@gmail.com')
        ->setTo($user->getEmail())
        ->setBody(
            $this->renderView(
                'AdminBundle:Email:info.html.twig',
                array(
                    'graduate' => $graduate,
                    'codigo'=> $data[0],
                    'lugar' => $data[1],
                    'anio' => $data[2],
                    'fecha_evento' => $data[3],
                    'hora_evento' => $data[4],
                    'direccion' => $data[5],
                    'password' => $user->getPlainPassword())
            ),
            'text/html'
        )
        /*
         * If you also want to include a plaintext version of the message
        ->addPart(
            $this->renderView(
                'Emails/registration.txt.twig',
                array('name' => $name)
            ),
            'text/plain'
        )
        */
    ;

    $this->get('mailer')->send($message);

    }

     /**
     * @Route("/emailTest/{code}", name="emailTest", defaults={"code" = null}, requirements={"code" = "[0-9]{9,9}"})
     * @Method({"GET"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function emailTestAction(Request $request,$code = null)
    {
        if ($code == NULL) {
            return new Response("Ingrese un codigo (emailTest/2010****)");  
        }
        $data= $this->get('srcg.get_event_info')->eventDate();
        $graduate = $this->get('doctrine')->getManager()
        ->getRepository('AppBundle:Graduandos')->find($code);
        $user = $this->get('doctrine')->getManager()
        ->getRepository('AppBundle:Usuarios')->find($code);
        
        if ($graduate == NULL) {
            return new Response("No existe un graduando con codigo ".$code); 
        }

        $this->send($data,$graduate,$user);
       return $this->render(
            'AdminBundle:Email:info.html.twig',
            array(
            'graduate' => $graduate,
            'codigo'=> $data[0],
            'lugar' => $data[1],
            'anio' => $data[2],
            'fecha_evento' => $data[3],
            'hora_evento' => $data[4],
            'direccion' => $data[5],
            'password' => $user->getPassword())
       );
      
    }

   

 /**
     * @Route("/list", name="guestList")
     * @Method({"GET"})
     * @Security("has_role('ROLE_ADMIN')")
     */
     public function listAction(Request $request)
     {   

        $graduate = new Graduate($this->get('doctrine')->getManager());
        $info = $graduate->guestList();
 $mpdfService = $this->get('vel.mpdf');
 $mpdfService->createMpdfInstance(
         $format = 'Letter',
         $fontSize = 0, //default
         $fontFamily = '', //default
         $marginLeft = 15,
         $marginRight = 15,
         $marginTop = 16,
         $marginBottom = 16,
         $marginHeader = 9,
         $marginFooter = 9,
         $orientation = 'P' // P for portrait, L for landscape
       );
 
       $anio = (new \DateTime())->format('Y');
 $mpdfService->getMpdf()->setHTMLFooter('<h4 style="color:#5f5f5f;">UNIVERSIDAD DEL VALLE '.$anio.'</h4>');
 $mpdfService->getMpdf()->setHeader('<h3 style="color:#5f5f5f;">LISTA DE <span style="color:#d11c23;"> INVITADOS</span></h3>');
 
 $html =  $this->render('AdminBundle:Default:list.html.twig',
            array(
                'info' => $info,
                'last' => count($info)-1,
            ));     
          // return $html;  

            $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
            return $mpdfService->generatePDFResponseFromHTML($html);
 
     }

 /**
     * @Route("/updateEvent", name="updateEvent")
      * @Method({"POST"})
      * @Security("has_role('ROLE_ADMIN')")
     */
     public function updateEventAction(Request $request)
     {
      $fecha_limite =  trim($request->request->get('fecha_limite'));
    $fecha_evento =  trim($request->request->get('fecha_evento'));
    $tipo =  trim($request->request->get('tipo'));
    $espacio = explode('-:-',trim($request->request->get('espacio')))[0];
    $password = trim($request->request->get('password')); 
    $location = new Location($this->get('doctrine')->getManager());
    $place = $location->searchLocation($espacio);

    
      
    
    if ($place == null) {
        return new RedirectResponse($this->generateUrl('adminEvent', array('message' => 'location'))); 
    }


  
        $inv =  trim($request->request->get('invitados'));
        $linv= strlen($inv);
        if ($inv == "" || $linv < 1 || $linv > 4) {
            return new RedirectResponse($this->generateUrl('adminEvent', array('message' => 'format'))); 
        }
        $lpassword= strlen($password);
    if ($password == "" || $lpassword < 1 || $lpassword > 20) {
        return new RedirectResponse($this->generateUrl('adminEvent', array('message' => 'format'))); 
    }


    $event = new Event($this->get('doctrine')->getManager());
    $info = $event->loadInfo();
    $info->setFechaLimite(\DateTime::createFromFormat('Y-m-d H:i',$fecha_limite));
    $info->setFechaEvento(\DateTime::createFromFormat('Y-m-d H:i',$fecha_evento));
    $info->setTipo($tipo);
    $info->setPassword($password);
    $info->setEspacio($place->getCodigo());
    $info->setInvitados($inv);

    $event->updateInfo($info);

    return new RedirectResponse($this->generateUrl('adminEvent', array('message' => 'success'))); 
 }

 /**
 * @Route("/removeAllGraduates", name="removeAllGraduates")
  * @Method({"POST"})
   * @Security("has_role('ROLE_ADMIN')")
  */
  public function removeGraduatesAction(Request $request)
  { 
    $graduate = new Graduate($this->get('doctrine')->getManager());
    $graduate->removeAll(); 
     return new RedirectResponse($this->generateUrl('adminGraduate', array('message' => 'success')));               
}
     /**
    * @Route("/csv", name="graduateCSV")
     * @Method({"POST"})
      * @Security("has_role('ROLE_ADMIN')")
     */
    public function csvAction(Request $request)
    {

if($request->files->get('csv') == NULL){
    return new RedirectResponse($this->generateUrl('adminGraduate', array('message' => 'empty')));         
}

$name = $request->files->get('csv')->getPathName();

$data = file($name);
$header = $data[0];


$graduate = new Graduate($this->get('doctrine')->getManager());

$result = $graduate->validateFormat($header);


if(count($data) < 2 || !$result[0]){
    return new RedirectResponse($this->generateUrl('adminGraduate', array('message' => 'format')));         
}
 $automatico = $result[1];


$info = $graduate->validateData($data,$automatico,$this->get('validator'));


if(count($info[0]) > 0){
 $session = $this->get('session');
$session->set('error_graduate',$info[0]);
    return new RedirectResponse($this->generateUrl('adminGraduate', array('message' => 'data')));         
}

  if(count($info[1]) != count($info[2])){
     return new RedirectResponse($this->generateUrl('adminGraduate', array('message' => 'format'))); 
        }
    if(count($info[3]) > 0){
         return new RedirectResponse($this->generateUrl('adminGraduate', array('message' => 'career'))); 
         }


$encoder = $this->get('security.password_encoder');

 for($i=0; $i < count($info[2]); $i++) { 
      $info[2][$i]->setPassword($encoder->encodePassword($this->getUser(),  $info[2][$i]->getPlainPassword()));
        }

$graduate->import($info[1],$info[2]);

return new RedirectResponse($this->generateUrl('adminGraduate', array('message' => 'success'))); 
}

 /**
    * @Route("/insertGraduate", name="insertGraduate")
     * @Method({"POST"})
      * @Security("has_role('ROLE_ADMIN')")
     */
    public function insertGraduateAction(Request $request)
    {

$graduate = new Graduate($this->get('doctrine')->getManager());

$codigo =  trim($request->request->get('codigo'));
   $nombre =  mb_strtoupper(trim($request->request->get('nombre')), "UTF-8");
   $apellido =  mb_strtoupper(trim($request->request->get('apellido')), "UTF-8");
   $email = trim($request->request->get('email'));
   $password = trim($request->request->get('password'));
   $programa = trim($request->request->get('programa'));
   if ($password == "") {
        $password =  $codigo;
   }

$data = $graduate->validate($codigo,$nombre,$apellido,$programa,$email,$password,$this->get('validator'));


   if (count($data[0][0]) + count($data[0][1]) > 0) {
       $session = $this->get('session');
$session->set('error_graduate',$data[0]);
        return new RedirectResponse($this->generateUrl('adminGraduate', array('message' => 'error')));
    }else{
      $pro = $graduate->existePrograma($programa);
        if($pro == null){
        return new RedirectResponse($this->generateUrl('adminGraduate', array('message' => 'career'))); 
        }else{
            $data[1]->setPrograma($pro);
            $encoder = $this->get('security.password_encoder');
        $data[2]->setPassword($encoder->encodePassword($this->getUser(), $password));
       $graduate->insert($data[1],$data[2]);
      
       $info = $this->get('srcg.get_event_info')->eventDate();
       $this->send($info,$data[1],$data[2]);

            return new RedirectResponse($this->generateUrl('adminGraduate', array('message' => 'success')));
        }
        
    }
}



/**
    * @Route("/updateGraduate", name="updateGraduate")
     * @Method({"POST"})
      * @Security("has_role('ROLE_ADMIN')")
     */
    public function updateGraduateAction(Request $request)
    {
      if ($request->isXMLHttpRequest()){  
         $codigo =  trim($request->request->get('codigo'));
     $action = trim($request->request->get('action'));
       
       $graduate = new Graduate($this->get('doctrine')->getManager());
       
        
     if ($action == "edit"){
        $nombre =  mb_strtoupper(trim($request->request->get('nombre')), "UTF-8");
        $apellido =  mb_strtoupper(trim($request->request->get('apellido')), "UTF-8");
        $email = trim($request->request->get('email'));
        $programa = trim($request->request->get('programa'));
        if($nombre == '' || $apellido == '' || $email == '' || $programa == ''){
        return new JsonResponse(array("fail","Los datos del graduando \"".$codigo."\" estan incompletos"));             
        }

if($graduate->soloLetras($nombre) || $graduate->soloLetras($apellido)){
        return new JsonResponse(array("fail","Los datos del graduando \"".$codigo."\" son inválidos"));             
        }

            if(!$graduate->validarEmail($email)){
                return new JsonResponse(array("fail","El email \"".$email."\" tiene un formato inválido"));             
            }

         $pro = $graduate->existePrograma($programa);
        if($pro == null){
        return new JsonResponse(array("fail","El programa académico no existe")); 
        }
        
        if($graduate->existeEmail($codigo,$email)){
            return new JsonResponse(array("fail","El email \"".$email."\" ya esta en uso")); 
            }

        $graduate->actualizar($codigo,$nombre,$apellido,$email,$pro); 
         return new JsonResponse(array("success","El graduando \"".$codigo."\" ha sido modificado")); 
     }else if ($action == "delete"){
         $graduate->eliminar($codigo); 
return new JsonResponse(array("success","El graduando  \"".$codigo."\" ha sido eliminado"));
     }
       return new JsonResponse(array("fail","Peticion indefinida")); 
    }
   throw $this->createNotFoundException();   
}

 /**
    * @Route("/insertCareer", name="insertCareer")
     * @Method({"POST"})
      * @Security("has_role('ROLE_ADMIN')")
     */
     public function insertCareerAction(Request $request)
     {
 
 $career = new Career($this->get('doctrine')->getManager());
 
 $codigo =  trim($request->request->get('codigo'));
    $nombre =  mb_strtoupper(trim($request->request->get('nombre')), "UTF-8");
    $facultad = trim($request->request->get('facultad'));
 
 $data = $career->validate($codigo,$nombre,$facultad,$this->get('validator'));
 
    if (count($data[0]) > 0) {
        $session = $this->get('session');
 $session->set('error_career',$data[0]);
         return new RedirectResponse($this->generateUrl('adminCareer', array('message' => 'error')));
     }else{
       $facu = $career->existeFacultad($facultad);
         if($facu == null){
         return new RedirectResponse($this->generateUrl('adminCareer', array('message' => 'faculty'))); 
         }else{
            $data[1]->setFacultad($facu);
        $career->insert($data[1]);
             return new RedirectResponse($this->generateUrl('adminCareer', array('message' => 'success')));
         }       
     }
 }
 


/**
    * @Route("/updateCareer", name="updateCareer")
     * @Method({"POST"})
      * @Security("has_role('ROLE_ADMIN')")
     */
     public function updateCareerAction(Request $request)
     {
       if ($request->isXMLHttpRequest()){  
        $codigo =  trim($request->request->get('codigo'));
        
      $action = trim($request->request->get('action'));
        
      $career = new Career($this->get('doctrine')->getManager());
        
         
      if ($action == "edit"){
        $nombre =  mb_strtoupper(trim($request->request->get('nombre')), "UTF-8");
        $facultad = trim($request->request->get('facultad'));
         if($nombre == '' || $facultad == ''){
         return new JsonResponse(array("fail","Los Datos del programa académico \"".$codigo."\" estan incompletos"));             
         }
 
 if($career->soloLetras($nombre)){
         return new JsonResponse(array("fail","Los Datos del programa académico \"".$codigo."\" son inválidos"));             
         }
 
         $facu = $career->existeFacultad($facultad);
         if($facu == null){
         return new JsonResponse(array("fail","La facultad no existe")); 
         }
         $career->actualizar($codigo,$nombre,$facu); 
          return new JsonResponse(array("success","El programa académico \"".$codigo."\" ha sido modificado")); 
      }else if ($action == "delete"){
        $cantidad = $career->cantidadGraduandos($codigo);
        if ($cantidad > 0) {
            return new JsonResponse(array("fail","El programa académico \"".$codigo."\" esta relacionado con \"".$cantidad."\" graduandos"));                     
         }
        
        $career->eliminar($codigo); 
 return new JsonResponse(array("success","El programa académico  \"".$codigo."\" ha sido eliminado"));
      }
        return new JsonResponse(array("fail","Peticion indefinida")); 
     }
    throw $this->createNotFoundException();   
 }
 

 /**
 * @Route("/insertFaculty", name="insertFaculty")
  * @Method({"POST"})
   * @Security("has_role('ROLE_ADMIN')")
  */
  public function insertFacultyAction(Request $request)
  {

$faculty = new Faculty($this->get('doctrine')->getManager());

$codigo =  trim($request->request->get('codigo'));
 $nombre =  mb_strtoupper(trim($request->request->get('nombre')), "UTF-8");
 $color = "#".mb_strtoupper(trim($request->request->get('color')), "UTF-8");

$data = $faculty->validate($codigo,$nombre,$color,$this->get('validator'));

 if (count($data[0]) > 0) {
     $session = $this->get('session');
$session->set('error_faculty',$data[0]);
      return new RedirectResponse($this->generateUrl('adminFaculty', array('message' => 'error')));
  }else{
     $faculty->insert($data[1]);
          return new RedirectResponse($this->generateUrl('adminFaculty', array('message' => 'success')));
          
  }
}



/**
 * @Route("/updateFaculty", name="updateFaculty")
  * @Method({"POST"})
   * @Security("has_role('ROLE_ADMIN')")
  */
  public function updateFacultyAction(Request $request)
  {
    if ($request->isXMLHttpRequest()){  
     $codigo =  trim($request->request->get('codigo'));
      $action = trim($request->request->get('action'));
   $faculty = new Faculty($this->get('doctrine')->getManager());
      
   if ($action == "edit"){
    $nombre =  mb_strtoupper(trim($request->request->get('nombre')), "UTF-8");
    $color = "#".mb_strtoupper(trim($request->request->get('color')), "UTF-8");
      if($nombre == '' || $color == '#'){
      return new JsonResponse(array("fail","Los datos de la facultad \"".$codigo."\" estan incompletos"));             
      }

if($faculty->soloLetras($nombre)){
      return new JsonResponse(array("fail","Los datos de la facultad \"".$codigo."\" son inválidos"));             
      }

      $faculty->actualizar($codigo,$nombre,$color); 
       return new JsonResponse(array("success","La facultad \"".$codigo."\" ha sido modificado")); 
   }else if ($action == "delete"){
    $cantidad = $faculty->cantidadProgramas($codigo);
    if ($cantidad > 0) {
        return new JsonResponse(array("fail","La facultad \"".$codigo."\" esta relacionada con \"".$cantidad."\" programas académicos"));                     
     }
     $faculty->eliminar($codigo); 
return new JsonResponse(array("success","La facultad \"".$codigo."\" ha sido eliminado"));
   }
   return new JsonResponse(array("fail","Peticion indefinida")); 
}
 throw $this->createNotFoundException();   
}



/**
 * @Route("/removeLocation", name="removeLocation")
  * @Method({"POST"})
   * @Security("has_role('ROLE_ADMIN')")
  */
  public function removeLocationAction(Request $request)
  { 
     $codigo =  trim($request->request->get('codigo'));
      $action = trim($request->request->get('action'));
      $location = new Location($this->get('doctrine')->getManager());
      $event = new Event($this->get('doctrine')->getManager());
      $url = $this->get('kernel')->getRootDir().'/../web'; 
       $espacio = $event->loadInfo()->getEspacio();
        if ($codigo == $espacio) {
            return new RedirectResponse($this->generateUrl('adminLocation', array('message' => 'selected')));               
        }
    $location->eliminar($codigo); 
    
     if (file_exists($url."/documents/map/".$codigo.'.pdf')) {
        unlink($url."/documents/map/".$codigo.'.pdf');
    } 

    if (file_exists($url."/img/main/map/".$codigo.'.jpg')) {
        unlink($url."/img/main/map/".$codigo.'.jpg');
    } 
     return new RedirectResponse($this->generateUrl('adminLocation', array('message' => 'success')));               
}


}

