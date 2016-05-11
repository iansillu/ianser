<?php

namespace Ianser\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Ianser\UserBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Ianser\UserBundle\Entity\User;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="portada")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('IanserBaseBundle:Default:portada.html.twig');
    }
    
    /**
     * @Route("/login", name="usuario_login")
     * @Method("GET")
     */
    public function loginAction(Request $request)
    {
        $sesion = $request->getSession();
        // obtener, si existe, el error producido en el último intento de login
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $sesion->get(SecurityContext::AUTHENTICATION_ERROR);
            $sesion->remove(SecurityContext::AUTHENTICATION_ERROR);
        }
        
        return $this->render('IanserBaseBundle:Default:portada.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'error'
            => $error
        ));
    }
    
     /**
     * @Route("/registro", name="usuari_crear")
     */
    public function registroAction(Request $request)
    {
        $usuari = new User();
        $form = $this->createForm(new UserType(), $usuari );
        $form->add('submit', 'submit', array('label' => 'Crear'));
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $encoder = $this->get('security.encoder_factory')->getEncoder($usuari);
            $usuari->setSalt(md5(time()));
            $passwordCodificado = $encoder->encodePassword($usuari->getPassword(),$usuari->getSalt());
            $usuari->setPassword($passwordCodificado);
            $usuari->setRoles("ROLE_USUARIO");
            $em->persist($usuari);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info','¡Enhorabuena! Te has registrado correctamente.');
            return $this->redirect($this->generateUrl("portada"));
        }

        return $this->render("IanserUserBundle:User:new.html.twig", array(
            'usuari'=>$usuari,
            'form'=>$form->createView()
        ));
        
    }
}
