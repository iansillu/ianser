<?php

namespace Ianser\BuscadorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ianser\BuscadorBundle\Form\BuscadorType;
use Ianser\EventosBundle\Entity\Evento;
use Doctrine\ORM;

/**
* @Route("/buscador")
*/
class BuscadorController extends Controller
{
    /**
     * @Route("/filtre", name="buscador_filtre")
     */
    public function FiltreAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $evento= new Evento();
        $form=$this->createForm(new BuscadorType(), $evento );
        $form->handleRequest($request);

        if ($form->isValid()) {
            $qb = $em->createQueryBuilder();
            $qb->select('e')->from('IanserEventosBundle:Evento', 'e');
            
            if(!is_null($evento->getNombre())){
               $qb->andwhere("e.nombre LIKE :nom");
               $qb->setParameter("nom", '%'.$evento->getNombre().'%');
            }
            
            if(!is_null($evento->getDireccion())){
               $qb->andwhere("e.direccion LIKE :direccio");
               $qb->setParameter("direccio", '%'.$evento->getDireccion().'%');
            }
            
            if(!is_null($evento->getCiudad())){
               $qb->andwhere("e.ciudad LIKE :ciutat");
               $qb->setParameter("ciutat", '%'.$evento->getCiudad().'%');
            }
            
            if(!is_null($evento->getTipo())){
               $qb->andwhere("e.tipo LIKE :tipo");
               $qb->setParameter("tipo", '%'.$evento->getTipo().'%');
            }
            
            
//            $qb->andwhere("e.ciudad LIKE :ciudad");
//            $qb->setParameter("ciudad", '%klm%');

            $query= $qb->getQuery();

            return $this->render("IanserBuscadorBundle:Default:eventos_filtrats.html.twig", array('eventos' => $query->getResult()));
        }

       return $this->render("IanserBuscadorBundle:Default:filtre.html.twig", array('form'=>$form->createView(), 'evento'=>$evento));
    }
    
}











