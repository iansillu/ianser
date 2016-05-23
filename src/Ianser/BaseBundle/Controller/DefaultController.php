<?php

namespace Ianser\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Ianser\UserBundle\Form\UserRegisterType;
use Symfony\Component\HttpFoundation\Request;
use Ianser\UserBundle\Entity\User;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class DefaultController extends Controller
{

    /**
     * @Route("/redirect", name="redirect_login")
     * @Method({"GET", "POST"})
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
     * @Method({"GET", "POST"})
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
        $form = $this->createForm(new UserRegisterType(), $usuari );
        
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
            $providerKey = 'main'; 
            $token = new UsernamePasswordToken($usuari, null, $providerKey, $usuari->getRoles());
            $this->container->get('security.context')->setToken($token);
            return new RedirectResponse($this->generateUrl("redirect_login"));
        }

        
        return $this->render('IanserBaseBundle:Default:portada.html.twig', array(
            'last_username' => $sesion->get(SecurityContext::LAST_USERNAME),
            'usuari'=>$usuari,
            'form'=>$form->createView()
        ));
    }
    
    
}
