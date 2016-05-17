<?php

namespace Ianser\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ianser\UserBundle\Entity\User;
use Ianser\UserBundle\Form\UserType;


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

        $form=$this->createForm(new UserType(), $usuari );
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('usuari_modificar', array('id' => $id)));
        }

        return $this->render("IanserUserBundle:User:edit.html.twig", array('form'=>$form->createView(), 'usuari'=>$usuari));

    }
    /**
     * @Route("/eliminar/{id}", name="usuari_eliminar")
     */
    public function eliminarAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $usuari = $em->getRepository('IanserUserBundle:User')->find($id);
        $em->remove($usuari);
        $em->flush();
        
         return $this->redirect($this->generateUrl("portada"));
    }

}
