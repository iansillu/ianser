<?php

namespace Ianser\EventosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ianser\EventosBundle\Entity\Evento;
use Ianser\EventosBundle\Form\EventoType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Ianser\ChatsBundle\Entity\Chats;
use Ianser\UserBundle\Entity\Usuariochats;

class EventosController extends Controller
{

    /**
     * @Route("/api/eventos/llistar", name="evento_llistar")
     * @Method("GET")
     */
    public function llistarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usuari_loguejat= $this->getUser();
        
        if($usuari_loguejat->getRoles()[0]=='ROLE_USUARIO'){
            $eventos_relacionats= $em->getRepository('IanserUserBundle:Usuarioeventos')->findBy(array('fkuser'=>$usuari_loguejat));
            $Aids_eventos= array();
            foreach ($eventos_relacionats as $evento){
                array_push($Aids_eventos, $evento->getFkevento());
            }
            
            return $this->render("IanserEventosBundle:Eventos:index_usuario.html.twig", array('eventos'=>$Aids_eventos));
        }
        else{
           $eventos = $em->getRepository('IanserEventosBundle:Evento')->findBy(array('fkuser'=>$usuari_loguejat));
           return $this->render("IanserEventosBundle:Eventos:index_empresa.html.twig", array('eventos'=>$eventos));
        }
        
    }
    
    /**
     * @Route("/empresa/eventos/crear", name="evento_crear")
     */
    public function crearAction(Request $request)
    {
        $evento = new Evento();
        $form = $this->createForm(new EventoType(), $evento );
        $form->add('submit', 'submit', array('label' => 'Crear'));
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $evento->setFkuser($this->getUser());
            $em->persist($evento);
            $em->flush();
            $chat= new Chats();
            $chat->setFkevento($evento);
            $em->persist($chat);
            $em->flush();
            return $this->redirect($this->generateUrl("evento_llistar"));
        }

        return $this->render("IanserEventosBundle:Eventos:new.html.twig", array(
            'evento'=>$evento,
            'form'=>$form->createView()
        ));
        
    }
    
    
    /**
     * @Route("/empresa/eventos/actualitzar/{id}", name="evento_modificar")
     */
    public function modificarAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $usuari_loguejat= $this->getUser();
        $evento = $em->getRepository('IanserEventosBundle:Evento')->find($id);
        
        if ($evento->getFkUser()==$usuari_loguejat){
            $form=$this->createForm(new EventoType(), $evento );
            $form->add('submit', 'submit', array('label' => 'Modificar'));
            $form->remove('imageFile');
            $form->add('imageFile', 'vich_file', array('required'=>false, 'allow_delete'=> false, 'download_link'=>false, 'label'=>"Imatge"));
            $form->handleRequest($request);
            
            if ($form->isValid()) {
                $evento->setRandomString();
                $em->persist($evento);
                $em->flush();
                return $this->redirect($this->generateUrl('evento_llistar', array('id' => $id)));
            }

           return $this->render("IanserEventosBundle:Eventos:edit.html.twig", array('form'=>$form->createView(), 'evento'=>$evento));
        }
        else{
            throw new AccessDeniedException();
        }
        

    }
    
    /**
     * @Route("/empresa/eventos/eliminar/{id}", name="evento_eliminar")
     */
    public function eliminarAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $usuari_loguejat= $this->getUser();
        $evento = $em->getRepository('IanserEventosBundle:Evento')->find($id);
        
        if ($evento->getFkUser()==$usuari_loguejat){
            $chat= $em->getRepository('IanserChatsBundle:Chats')->findOneBy(array('fkevento'=>$evento));
            $usuaris_chat= $em->getRepository('IanserUserBundle:Usuariochats')->findOneBy(array("fkchat"=>$chat));
            $usuaris_eventos= $em->getRepository('IanserUserBundle:Usuarioeventos')->findOneBy(array("fkevento"=>$evento));
            if(!is_null($usuaris_eventos)){
                $em->remove($usuaris_chat);
                $em->flush();
            }
            if(!is_null($usuaris_eventos)){
                $em->remove($usuaris_eventos);
                $em->flush();
            }
            
            
            $em->remove($chat);
            $em->flush();
            $em->remove($evento);
            $em->flush();
            return $this->redirect($this->generateUrl("evento_llistar"));
        }
        else{
            throw new AccessDeniedException();
        }
         
    }

}
