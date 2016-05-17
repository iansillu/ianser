<?php

namespace Ianser\BuscadorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

    /**
    * @Route("/api/buscador")
    */
class BuscadorController extends Controller
{
    /**
     * @Route("/filtre", name="buscador_filtre")
     */
    public function FiltreAction()
    {
        
        //return $this->render('IanserBuscadorBundle:Default:index.html.twig', array('name' => $name));
    }
}
