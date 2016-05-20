<?php

namespace Ianser\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Ianser\UserBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Ianser\UserBundle\Entity\User;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;


class DefaultController extends Controller
{

    /**
     * @Route("/redirect", name="redirect_login")
     * @Method("GET")
     */
    public function redirectLoginAction(){

        $url="portada";
        if ($this->get('security.context')->isGranted('ROLE_USUARIO')) {
            $url = 'evento_llistar';
        } 
        
        elseif ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            $url = 'admin_portada';
        }
        
        elseif ($this->get('security.context')->isGranted('ROLE_EMPRESA')) {
            $url = 'evento_llistar';
        }
        
       return new RedirectResponse($this->generateUrl($url));
       
    }
    
    /**
     * @Route("/", name="portada")
     * @Method("GET")
     */
    public function loginAction(Request $request)
    {
        $sesion = $request->getSession();
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        
        if ($error) {
            $sesion->getFlashBag()->set('login_incorrecte', "Contrasenya incorrecte o usuari inexistent.");
            
        }
        
        $usuari = new User();
        $form = $this->createForm(new UserType(), $usuari );
        $form->add('submit', 'submit', array('label' => 'Crear compte'));
        
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
            return $this->redirect($this->generateUrl("usuario_login_check"));
        }
        
        return $this->render('IanserBaseBundle:Default:portada.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'usuari'=>$usuari,
            'form'=>$form->createView()
        ));
    }
    
     /**
     * @Route("/registro", name="usuari_crear")
     */
    public function registroAction(Request $request)
    {
        $usuari = new User();
        $form = $this->createForm(new UserType(), $usuari );
        $form->add('submit', 'submit', array('label' => 'Crear compte'));
        
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
            return $this->redirect($this->generateUrl("usuario_login_check"));
        }

        return $this->render("IanserUserBundle:User:new.html.twig", array(
            'usuari'=>$usuari,
            'form'=>$form->createView()
        ));
        
    }
    
}
