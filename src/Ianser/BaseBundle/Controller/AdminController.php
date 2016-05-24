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

    //renderitzem la portada de l'admin
    /**
     * @Route("/", name="admin_portada")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render("IanserBaseBundle:Default:portada_admin.html.twig");
    }
    
    
    //renderitzem una vista amb tots els usuaris
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
    
    // crea un usuari amb role ROLE_EMPRESA
    /**
     * @Route("/crear", name="admin_crear")
     */
    public function crearEmpresaAction(Request $request)
    {
        $usuari = new User();
        $form = $this->createForm(new UserType(), $usuari );
        $form->remove("password");
        $form->add('password','text', array('label'=>"Contrasenya", 'required'=>false));
        $form->add('username');
        $form->add('submit', 'submit', array('label' => 'Crear'));
        
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $encoder = $this->get('security.encoder_factory')->getEncoder($usuari);
            $usuari->setSalt(md5(time()));
            $passwordCodificado = $encoder->encodePassword($usuari->getPassword(),$usuari->getSalt());
            $usuari->setPassword($passwordCodificado);
            $usuari->setRoles("ROLE_EMPRESA");
            $em->persist($usuari);
            $em->flush();
            return $this->redirect($this->generateUrl("admin_portada"));
        }

        return $this->render("IanserUserBundle:User:new.html.twig", array(
            'usuari'=>$usuari,
            'form'=>$form->createView()
        ));
        
    }
    
    // modifica un usuari, el qual aconseguim a través de la seva ID
    /**
     * @Route("/actualitzar/{id}", name="admin_modificar")
     */
    public function modificarAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $usuari = $em->getRepository('IanserUserBundle:User')->find($id);
        
        
        $form=$this->createForm(new UserType(), $usuari );
        $form->add('Modificar','submit');
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('admin_portada', array('id' => $id)));
        }

        return $this->render("IanserBaseBundle:Default:edit.html.twig", array('form'=>$form->createView(), 'usuari'=>$usuari));
       
        
        

    }
    
    // elimina un usuari de la base de dades
    /**
     * @Route("/eliminar/{id}", name="admin_eliminar")
     */
    public function eliminarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $usuari = $em->getRepository('IanserUserBundle:User')->find($id);
        $events_usuari= $em->getRepository('IanserEventosBundle:Evento')->findBy(array("fkuser"=>$usuari));
        foreach($events_usuari as $event){
            $em->remove($event);
            $em->flush();
        }
        $em->remove($usuari);
        $em->flush();
        return $this->redirect($this->generateUrl("admin_portada"));
        
        
        
    }
    
}
