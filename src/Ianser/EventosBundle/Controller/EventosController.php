<?php

namespace Ianser\EventosBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ianser\EventosBundle\Entity\Evento;
use Ianser\EventosBundle\Form\EventoType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
            $eventos= $em->getRepository('IanserUserBundle:Usuarioeventos')->findBy(array('fkuser'=>$usuari_loguejat));
            return $this->render("IanserEventosBundle:Eventos:index_usuario.html.twig", array('eventos'=>$eventos));
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
            $form->handleRequest($request);
            
            
            if ($form->isValid()) {
                $evento->setRandomString();
                $em->persist($evento);
                $em->flush();
                return $this->redirect($this->generateUrl('evento_modificar', array('id' => $id)));
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
            $em->remove($evento);
            $em->flush();
            return $this->redirect($this->generateUrl("evento_llistar"));
        }
        else{
            throw new AccessDeniedException();
        }
         
    }

}
