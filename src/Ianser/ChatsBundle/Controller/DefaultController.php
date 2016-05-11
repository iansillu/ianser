<?php

namespace Ianser\ChatsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('IanserChatsBundle:Default:index.html.twig', array('name' => $name));
    }
}
