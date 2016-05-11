<?php

namespace Ianser\BuscadorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('IanserBuscadorBundle:Default:index.html.twig', array('name' => $name));
    }
}
