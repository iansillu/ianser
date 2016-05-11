<?php

namespace Ianser\EventosBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('IanserEventosBundle:Default:index.html.twig', array('name' => $name));
    }
}
