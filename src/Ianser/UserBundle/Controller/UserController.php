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
    // comprovem que l'usuari tingui privilegis per modificar l'instancia de l'usuari, si en te, el modifiquem
    /**
     * @Route("/actualitzar/{id}", name="usuari_modificar")
     */
    public function modificarAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $usuari = $em->getRepository('IanserUserBundle:User')->find($id);
        $usuari_loguejat= $this->getUser();
        
        $passwordOriginal = $usuari->getPassword();
        $usuari->setPassword("");
        
        $form=$this->createForm(new UserType(), $usuari );
        
        if ($usuari_loguejat===$usuari){
            
            $form->add('Modificar','submit');
            $form->handleRequest($request);

            if ($form->isValid()) {
                if($usuari->getPassword()==""){
                    $usuari->setPassword($passwordOriginal);
                }
                else{
                    $encoder = $this->get('security.encoder_factory')->getEncoder($usuari);
                    $passwordCodificado = $encoder->encodePassword(
                    $usuari->getPassword(),
                    $usuari->getSalt()
                    );
                    $usuari->setPassword($passwordCodificado);
                }
                $em->flush();
                return $this->render("IanserUserBundle:User:edit.html.twig", array('form'=>$form->createView(), 'usuari'=>$usuari, 'canvis'=>'OK'));
            }

            return $this->render("IanserUserBundle:User:edit.html.twig", array('form'=>$form->createView(), 'usuari'=>$usuari));
        }
        else{
            throw new AccessDeniedException();
        }
        
        

    }
    // eliminem l'usuari i segons el seu rol, les dades que té relacionades amb ell
    /**
     * @Route("/eliminar/{id}", name="usuari_eliminar")
     */
    public function eliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $usuari = $em->getRepository('IanserUserBundle:User')->find($id);
        $usuari_loguejat= $this->getUser();
        
        if ($usuari_loguejat===$usuari){
            if($usuari->getRoles()==array('ROLE_EMPRESA')){
                
                $events_usuari= $em->getRepository('IanserEventosBundle:Evento')->findBy(array("fkuser"=>$usuari));
                
                
                if(!is_null($events_usuari)){
                    foreach($events_usuari as $event){
                        $event_relacio= $em->getRepository('IanserUserBundle:Usuarioeventos')->findOneBy(array("fkevento"=>$event));
                        $em->remove($event_relacio);
                        $em->flush();
                        $em->remove($event);
                        $em->flush();
                    }   
                }
            }
            
            else if($usuari->getRoles()==array('ROLE_USUARIO')){
                $usuaris_eventos= $em->getRepository('IanserUserBundle:Usuarioeventos')->findBy(array("fkuser"=>$usuari));
                
                if(!is_null($usuaris_eventos)){
                    foreach($usuaris_eventos as $relacio){
                        $em->remove($relacio);
                        $em->flush();
                    }
                }
                 
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
