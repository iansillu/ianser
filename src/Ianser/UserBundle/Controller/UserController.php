<?php

namespace Ianser\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ianser\UserBundle\Entity\User;
use Ianser\UserBundle\Form\UserType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * User controller.
 *
 * @Route("/usuario")
 */
class UserController extends Controller
{

    /**
     * @Route("/actualitzar/{id}", name="usuari_modificar")
     */
    public function modificarAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $usuari = $em->getRepository('IanserUserBundle:User')->find($id);
        $usuari_loguejat= $this->getUser();
        
        if ($usuari_loguejat===$usuari){
            $form=$this->createForm(new UserType(), $usuari );
            $form->add('Modificar','submit');
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->flush();
                return $this->redirect($this->generateUrl('usuari_modificar', array('id' => $id)));
            }

            return $this->render("IanserUserBundle:User:edit.html.twig", array('form'=>$form->createView(), 'usuari'=>$usuari));
        }
        else{
            throw new AccessDeniedException();
        }
        
        

    }
    /**
     * @Route("/eliminar/{id}", name="usuari_eliminar")
     */
    public function eliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $usuari = $em->getRepository('IanserUserBundle:User')->find($id);
        $usuari_loguejat= $this->getUser();
        
        if ($usuari_loguejat===$usuari){
            $events_usuari= $em->getRepository('IanserEventosBundle:Evento')->findBy(array("fkuser"=>$usuari));
            foreach($events_usuari as $event){
                $em->remove($event);
                $em->flush();
            }
            $em->remove($usuari);
            $em->flush();
            $this->get('security.context')->setToken(null);
            $this->get('request')->getSession()->invalidate();
            return $this->redirect($this->generateUrl("portada"));
        }
        else{
           throw new AccessDeniedException(); 
        }
        
        
    }
    
}
