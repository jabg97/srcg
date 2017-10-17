<?php

namespace GraduateBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use GraduateBundle\Model\Guest;

class ActionController extends Controller
{
   
     /**
     * @Route("/register", name="graduateRegisterGuest")
     * @Method({"POST"})
     * @Security("has_role('ROLE_USER')")
     */
    public function registerAction(Request $request)
    {
        $guest = new Guest($this->get('doctrine')->getManager());     
     $session = $this->get('session');
$message = $guest->register($request,$this->getUser()->getUsername());
         return new RedirectResponse($this->generateUrl('graduate',array('message' => $message)));
    }

    /**
     * @Route("/invitation", name="graduateInvitation")
     * @Method({"GET"})
     * @Security("has_role('ROLE_USER')")
     */
    public function invitationAction(Request $request)
    {   
$guest = new Guest($this->get('doctrine')->getManager()); 
 $list = $guest->searchGuests($this->getUser()->getUsername());
 $graduate = $list[0]->getGraduando();
 $info = array();



foreach ( $list as $invitado) {
$VCard  = "BEGIN:VCARD\r\n";
    $VCard .= "VERSION:3.0\r\n";
    $VCard .= "TITLE:".$invitado->getDocumento()."\r\n";
    $VCard .= "FN:".$invitado->getNombre()." ".$invitado->getApellido()."\r\n";
    $VCard .= "END:VCARD\r\n"; 
     $info[] = array($VCard,array($invitado->getNombre(),$invitado->getApellido())) ;

}

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
$mpdfService->getMpdf()->setHeader('<h3 style="color:#5f5f5f;">INVITADOS DE <span style="color:#d11c23;">'.$graduate->getNombre().' '.$graduate->getApellido().'</span></h3>');

$data= $this->get('srcg.get_event_info')->eventDate();
$html =  $this->render('GraduateBundle:Default:invitation.html.twig',
           array(
               'info' => $info,
               'graduate' => $graduate,
                'lugar' => $data[1],
               'direccion' => $data[5],
               'fecha_evento' => $data[3],
               'hora_evento' => $data[4],
               'limite' => count($list)-1

           ));     
           //return $html;  
           $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');
           return $mpdfService->generatePDFResponseFromHTML($html);

    }

}
