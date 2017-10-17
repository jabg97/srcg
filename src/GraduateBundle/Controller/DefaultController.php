<?php

namespace GraduateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use GraduateBundle\Model\Guest;

class DefaultController extends Controller
{
    /**
     * @Route("/{message}", name="graduate", defaults={"message" = null}, requirements={"message" = "^[A-Z-]*$"} )
    * @Method({"GET"})
      * @Template("GraduateBundle:Default:index.html.twig")
      * @Security("has_role('ROLE_USER')")
     */
    public function indexAction(Request $request,$message = null)
    {
$guest = new Guest($this->get('doctrine')->getManager());
$size = $this->get('srcg.get_event_info')->limitGuests();
$activar = $this->get('srcg.get_event_info')->invitation();
$info = $guest->loadGuests($this->getUser()->getUsername(),$size,$message);
if ($info == null) {
throw $this->createNotFoundException();
}

$this->get('session')->set('contador',$this->get('session')->get('contador')+1);
       return array(
               'guests' => $info[0],
               'messages' => $info[1],
               'icons' => $info[2],
               'sizemen' => $info[3],
               'mostrar' => $info[4],
               'invitation' => $info[5],
               'size' => $size,
               'activar' => $activar,
           );
    }

    /**
     * @Route("/help", name="graduateHelp")
     * @Method({"GET"})
      * @Template("GraduateBundle:Default:help.html.twig")
      * @Security("has_role('ROLE_USER')")
     */
    public function helpAction(Request $request)
    {   
        $activar = $this->get('srcg.get_event_info')->invitation();
        $data= $this->get('srcg.get_event_info')->limitDate();
        return array(
               'fecha_limite' => $data[0],
               'hora_limite' => $data[1],
               'activar' => $activar,
           );
    }



/**
     * @Route("/pass/{error}", name="graduatePass", defaults={"error" = null}, requirements={"error" = "[a-z]{4,9}"} )
    * @Method({"GET"})
      * @Template("GraduateBundle:Security:pass.html.twig")
      * @Security("has_role('ROLE_USER')")
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
