<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Usuarios;

class SecurityController extends Controller
{

/**
    * @Route("/search", name="searchGraduate")
     * @Method({"POST"})
     */
     public function searchAction(Request $request)
     {
        $data =  mb_strtoupper(trim($request->request->get('data')), 'UTF-8');
        $password =  trim($request->request->get('password'));

        $service = $this->get('srcg.get_event_info');
        
                if ($password != $service->getPassword()) {
                    return new Response(0); 
                }

                $list = $service->searchGraduate($data);
                if(count($list) > 0){
                    $serializer = $this->get('jms_serializer');
                    return new Response($serializer->serialize($list,'json'));
                }          
                return new Response(1);  
    }

    /**
    * @Route("/sync", name="syncData")
     * @Method({"POST"})
     */
    public function syncAction(Request $request)
    {
 
       $password =  trim($request->request->get('password'));

       $service = $this->get('srcg.get_event_info');
       
               if ($password != $service->getPassword()) {
                   return new Response(0); 
               }

               $list = $service->syncData();
               if(count($list) > 0){
                   $serializer = $this->get('jms_serializer');
                   return new Response($serializer->serialize($list,'json'));
               }          
               return new Response(1);  
   }


/**
    * @Route("/validate", name="validateGuest")
     * @Method({"POST"})
     */
     public function validateAction(Request $request)
     {
        $data =  trim($request->request->get('data'));     
        $password =  trim($request->request->get('password'));
        $service = $this->get('srcg.get_event_info');

        if ($password != $service->getPassword()) {
            return new Response(0); 
        }

        $guest = $service->validate($data);
        
            if ($guest == null) {
                return new Response(1); 
            }

            if ($guest->getAsistencia()) {
                return new Response(2); 
            }
        
            $service->registerGuest($guest);
            return new Response(3);  
 }

    /**
    * @Route("/login/{message}", name="login", defaults={"message" = null}, requirements={"message" = "[a-z]{3,6}"} )
    * @Method({"GET"})
     */
    public function loginAction(Request $request,$message = null)
    {

         if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
      return $this->render('AppBundle:Security:active.html.twig');
    }else{
        if($message == 'end' || $message == 'update' || $message == null){

            $helper = $this->get('security.authentication_utils');

$data= $this->get('srcg.get_event_info')->limitDate();

       return $this->render('AppBundle:Security:login.html.twig',
           array(
               'last_username' => $helper->getLastUsername(),
               'error'         => $helper->getLastAuthenticationError(),
               'message' => $message,
               'fecha_limite' => $data[0],
               'hora_limite' => $data[1],
           )
       );

        }else{
throw $this->createNotFoundException();
        }
      }       
    }



    /**
     * @Route("/password/change", name="changePassword")
     * @Method({"POST"})
    * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_USER')")
     */
    public function changePasswordAction(Request $request)
    {

$encoder = $this->get('security.password_encoder');


$passA = trim($request->request->get('passA'));
$passN = trim($request->request->get('passN'));
$passR = trim($request->request->get('passR'));


              if (strlen($passA) < 1 || strlen($passA) > 20 || strlen($passN) < 1 || strlen($passN) > 20 || strlen($passR) < 1 || strlen($passR) > 20 ) {
             if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
             return new RedirectResponse($this->generateUrl('adminPass', array('error' => 'error')));
             }else if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
             return new RedirectResponse($this->generateUrl('graduatePass', array('error' => 'error')));
             }
             }
   
    if ($passA == $passN) {
              if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
             return new RedirectResponse($this->generateUrl('adminPass', array('error' => 'equals')));
             }else if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
             return new RedirectResponse($this->generateUrl('graduatePass', array('error' => 'equals')));
             }
             }

             if ($passN != $passR) {
                  if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
             return new RedirectResponse($this->generateUrl('adminPass', array('error' => 'different')));
             }else if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
             return new RedirectResponse($this->generateUrl('graduatePass', array('error' => 'different')));
             }
             }



$usuario = $this->getUser();
 if ($encoder->isPasswordValid($usuario, $passA)) {
$nueva = $encoder->encodePassword($usuario, $passN);

     $this->change($usuario->getUsername(),$nueva);

     $this->get('security.token_storage')->setToken(null);
         return new RedirectResponse($this->generateUrl('login', array('message' => 'update')));
        }else{

             if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
             return new RedirectResponse($this->generateUrl('adminPass', array('error' => 'fail')));
             }else if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
             return new RedirectResponse($this->generateUrl('graduatePass', array('error' => 'fail')));
             }

        }
    }
 
private function change($codigo,$password)
    {    
        $em = $this->get('doctrine')->getManager();
$repository = $em->getRepository('AppBundle:Usuarios');
$user = $repository->find($codigo);
$user->setPassword($password);
$em->persist($user);
$em->flush();
    }

    /**
    * @Route("/go", name="go")
    * @Method({"GET"})
    * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_USER')")
     */
    public function goAction(Request $request)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
      return new RedirectResponse($this->generateUrl('admin'));
    }else if ($this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
        
$em = $this->get('doctrine')->getManager();

 date_default_timezone_set('America/Bogota');

        $ahora = (new \DateTime())->format('Y-m-d H:i');

    $repository = $em->getRepository('AppBundle:Info');
            $limite = $repository->find(1)->getFechaLimite()->format('Y-m-d H:i'); 

        if($ahora >= $limite) {
           $this->get('security.token_storage')->setToken(null);
            return new RedirectResponse($this->generateUrl('login', array('message' => 'end')));
        }
         
        $repository = $em->getRepository('AppBundle:Graduandos');

$graduando = $repository->find($this->getUser()->getUsername());
$session = $this->get('session');
$session->set('nombre',mb_strtoupper($graduando->getNombre(), "UTF-8"));
$session->set('apellido',mb_strtoupper($graduando->getApellido(), "UTF-8"));
$session->set('contador',0);
        return new RedirectResponse($this->generateUrl('graduate'));
    }
    }


    /**
     * @Route("/login_check", name="security_login_check")
     * @Method({"POST"})
     * @Security("has_role('IS_AUTHENTICATED_ANONYMOUSLY')")
     */
    public function loginCheckAction(Request $request)
    {

    }

    /**
     * @Route("/logout", name="logout")
     * @Method({"GET"})
     * @Security("has_role('ROLE_ADMIN') or has_role('ROLE_USER')")
     */
    public function logoutAction(Request $request)
    {

    }
}