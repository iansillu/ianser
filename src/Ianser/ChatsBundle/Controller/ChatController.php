<?php

namespace Ianser\ChatsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 *
 * @Route("/chat")
 */
class ChatController extends Controller
{
    /**
     * @Route("/llistar", name="chat_llistar")
     */
    public function llistarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuari= $this->getUser();
        $chats= $em->getRepository('IanserUserBundle:Usuariochats')->findBy(array("fkuser"=>$usuari));
        
        $Achats= array();
        foreach($chats as $referencia_chat){
            $chat= $em->getRepository('IanserChatsBundle:Chats')->findOneBy(array("idchat"=>$referencia_chat->getFkchat()));
            array_push($Achats, $chat);
        }
        return $this->render('IanserChatsBundle:Default:llista_chats.html.twig', array('chats' => $Achats));
    }
}
