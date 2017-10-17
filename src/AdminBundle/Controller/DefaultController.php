<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use AdminBundle\Model\Graduate;
use AdminBundle\Model\Location;
use AdminBundle\Model\Event;
use AdminBundle\Model\Faculty;
use AdminBundle\Model\Career;
use AppBundle\Entity\Espacios;

class DefaultController extends Controller
{
   
 /**
     * @Route("/", name="admin")
      * @Method({"GET"})
      * @Template("AdminBundle:Default:index.html.twig")
      * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction(Request $request)
    {
        $graduate = new Graduate($this->get('doctrine')->getManager());
        $list = $graduate->CareerStatistics();
        $color = array();
        foreach ($list as $key => $value) {
           $color[$key] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        }
        return array(
            'lista_Carreras' => $list,
            'color_Carreras' => $color,
            'lista_Facultades' => $graduate->FacultyStatistics(),
        );
    }

     /**
     * @Route("/event/fullscreen", name="eventFullscreen")
      * @Method({"GET"})
      * @Template("AdminBundle:Default:fullscreen.html.twig")
      * @Security("has_role('ROLE_ADMIN')")
     */
    public function eventFullscreenAction(Request $request)
    {
        $location = new Location($this->get('doctrine')->getManager());
        $event = new Event($this->get('doctrine')->getManager());
        return array(
            'place' => $location->searchLocation($event->loadInfo()->getEspacio()),
            'noMobile' => !$event->isMobile($request)
        );
    }

 /**
     * @Route("/location/{message}", name="adminLocation", defaults={"message" = null}, requirements={"message" = "[a-z]{5,8}"} )
     * @Method({"GET", "POST"})
      * @Template("AdminBundle:Default:location.html.twig")
      * @Security("has_role('ROLE_ADMIN')")
     */
    public function locationAction(Request $request,$message = null)
    {
        if($message == 'empty' || $message == 'selected' || $message == 'success' || $message == null){
                $location = new Location($this->get('doctrine')->getManager());
               
                $espacio = new Espacios();
                $errors = array();
                $action = trim($request->request->get('action'));

                $form = $this->createForm('AdminBundle\Form\EspaciosType', $espacio);
                $form->handleRequest($request);        

                $paginator  = $this->get('knp_paginator');
                $query = $location->locationsQuery();

                $pagination = $paginator->paginate($query, $request->query->getInt('page', 1),5);

                if ($form->isSubmitted()) {   
                    $codigo = $espacio->getCodigo();
                    if ($action == "edit"){ 
                        $espacio = $location->searchLocation($codigo);
                        $form = $this->createForm('AdminBundle\Form\EspaciosType', $espacio);
                        $form->handleRequest($request); 
                    }
                    if ($form->isValid()) {           
                        $map = $espacio->getMap();
                        $espacio->setNombre(mb_strtoupper(trim($espacio->getNombre()), "UTF-8"));
                        $espacio->setDireccion(mb_strtoupper(trim($espacio->getDireccion()), "UTF-8"));
                        $image = $espacio->getImage();
                        $url = $this->get('kernel')->getRootDir().'/../web';
                        $em = $this->getDoctrine()->getManager();

                        if ($action == "insert"){
                            if($map === NULL || $image === NULL){                    
                                $message = 'empty'; 
                                return array(
                                    'pagination' => $pagination,
                                    'message' => $message,
                                    'errors' => $errors,
                                    'espacio' => $espacio,
                                    'formObject' => $form
                                 );
                            }
                            $em->persist($espacio);
                            }
                      
                            $em->flush();                         
                                                                                    
                            if($map !== NULL){                    
                                $fileName = $codigo.'.pdf';                    
                                $map->move($url."/documents/map",$fileName);       
                            }
                            if($image !== NULL){
                                $fileName = $codigo.'.jpg';     
                                $image->move($url."/img/main/map",$fileName);        
                            }
                               $message = 'success';
                                                    
                    }else{
                        $message = 'error';
                        $errors = $this->get('validator')->validate($espacio);
                        }
                    
                }

                return array(
                    'pagination' => $pagination,
                    'message' => $message,
                    'errors' => $errors,
                    'espacio' => $espacio,
                    'formObject' => $form
                 );
                }else{
                    throw $this->createNotFoundException();
                            }
    }

    /**
     * @Route("/career/{message}", name="adminCareer", defaults={"message" = null}, requirements={"message" = "[a-z]{5,7}"} )
     * @Method({"GET"})
      * @Template("AdminBundle:Default:career.html.twig")
      * @Security("has_role('ROLE_ADMIN')")
     */
    public function CareerAction(Request $request,$message = null)
    {
            
            if($message == 'faculty' || $message == 'error' || $message == 'success' || $message == null){
                $career = new Career($this->get('doctrine')->getManager());
                $faculty = new Faculty($this->get('doctrine')->getManager());
                $errors = array();
                if($message == 'error'){
                    $session = $this->get('session');
                    $errors =  $session->get('error_career');                 
                }

                $paginator  = $this->get('knp_paginator');
                $query = $career->careersQuery();

                $pagination = $paginator->paginate($query, $request->query->getInt('page', 1),5);
                return array(
                    'pagination' => $pagination,
                    'faculties' => $faculty->loadFaculties(),
                    'message' => $message,
                    'errors' => $errors
                 );
            }else{
 throw $this->createNotFoundException();
         }
    }


    /**
     * @Route("/faculty/{message}", name="adminFaculty", defaults={"message" = null}, requirements={"message" = "[a-z]{5,7}"} )
     * @Method({"GET"})
      * @Template("AdminBundle:Default:faculty.html.twig")
      * @Security("has_role('ROLE_ADMIN')")
     */
    public function FacultyAction(Request $request,$message = null)
    {
        if( $message == 'error' || $message == 'success' || $message == null){
            $faculty = new Faculty($this->get('doctrine')->getManager());
            $errors = array();
            if($message == 'error'){
                $session = $this->get('session');
                $errors =  $session->get('error_faculty');                 
            }

            $paginator  = $this->get('knp_paginator');
            $query = $faculty->facultiesQuery();

            $pagination = $paginator->paginate($query, $request->query->getInt('page', 1),5);
            return array(
                'pagination' => $pagination,
                'message' => $message,
                'errors' => $errors
             );
        }else{
throw $this->createNotFoundException();
     }
    }

    /**
     * @Route("/graduate/{message}", name="adminGraduate", defaults={"message" = null}, requirements={"message" = "[a-z]{4,7}"} )
     * @Method({"GET"})
      * @Template("AdminBundle:Default:graduate.html.twig")
      * @Security("has_role('ROLE_ADMIN')")
     */
    public function graduateAction(Request $request ,$message = null)
    {
           if($message == 'empty' || $message == 'format' || $message == 'career' || $message == 'email' || $message == 'error' || $message == 'data' || $message == 'success' || $message == null){
            $graduate = new Graduate($this->get('doctrine')->getManager());
            $career = new Career($this->get('doctrine')->getManager());  
            $errors = array();
               if($message == 'error' || $message == 'data'){
                   $session = $this->get('session');
                   $errors =  $session->get('error_graduate');                 
               }             
               $paginator  = $this->get('knp_paginator');
               $query = $graduate->graduatesQuery(); 
               $pagination = $paginator->paginate($query, $request->query->getInt('page', 1),5);
        return array(
               'careers' => $career->loadCareers(),
               'pagination' => $pagination,
         'message' => $message,
         'errors' => $errors);
           }else{
throw $this->createNotFoundException();
        }
    }


 /**
     * @Route("/event/{message}", name="adminEvent", defaults={"message" = null}, requirements={"message" = "[a-z]{6,8}"} )
     * @Method({"GET"})
      * @Template("AdminBundle:Default:event.html.twig")
      * @Security("has_role('ROLE_ADMIN')")
     */
    public function eventAction(Request $request,$message = null)
    {   
        if($message == 'location' || $message == 'success' || $message == null){    
        $location = new Location($this->get('doctrine')->getManager());
        $event = new Event($this->get('doctrine')->getManager());
        $info = $event->loadInfo();
        return array(
               'locations' => $location->loadLocations(),
               'event' => $info,
               'place' => $location->searchLocation($info->getEspacio()),
               'graduates' => $event->howManyGraduates(),
               'noMobile' => !$event->isMobile($request),
               'message' => $message
           );
        }else{
            throw $this->createNotFoundException();
                    }
    }

    /**
     * @Route("/pass/{error}", name="adminPass", defaults={"error" = null}, requirements={"error" = "[a-z]{4,9}"} )
    * @Method({"GET"})
      * @Template("AdminBundle:Security:pass.html.twig")
      * @Security("has_role('ROLE_ADMIN')")
     */
    public function passAction(Request $request,$error = null)
    {
        if($error == 'different' || $error == 'equals' || $error == 'error' || $error == 'fail' || $error == null){
         return array('error' => $error);
           }else{
throw $this->createNotFoundException();
        }
    }

}
