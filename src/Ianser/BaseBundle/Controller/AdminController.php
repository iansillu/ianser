<?php

namespace Ianser\BaseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Ianser\UserBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Ianser\UserBundle\Entity\User;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{

    /**
     * @Route("/", name="admin_portada")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render("IanserBaseBundle:Default:portada_admin.html.twig");
    }
    
    
    
    /**
     * @Route("/llistar", name="admin_llistar")
     * @Method("GET")
     */
    public function llistarAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usuaris = $em->getRepository('IanserUserBundle:User')->findAll();
        return $this->render("IanserUserBundle:User:index.html.twig", array('usuaris'=>$usuaris));
    }
    
    /**
     * @Route("/crear", name="admin_crear")
     */
    public function crearEmpresaAction(Request $request)
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
            $usuari->setRoles("ROLE_ADMIN");
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
