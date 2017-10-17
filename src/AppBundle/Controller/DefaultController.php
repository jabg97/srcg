<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method({"GET"})
    * @Template("AppBundle:Default:index.html.twig")
     */
    public function indexAction(Request $request)
    {

$data= $this->get('srcg.get_event_info')->eventDate();
         return array(
                'codigo'=> $data[0],
               'lugar' => $data[1],
               'anio' => $data[2],
               'fecha_evento' => $data[3],
               'hora_evento' => $data[4],
               'direccion' => $data[5]
               );
    
    }

   
}
