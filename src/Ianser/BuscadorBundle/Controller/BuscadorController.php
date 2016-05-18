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
                $qb->andwhere("e.nombre = :nom");
                $qb->setParameter("nom", 'kemfks');
                
//                ->orderBy('u.name', 'ASC')
//                ->setParameter('identifier', 100);
            //$eventos= $em->getRepository('IanserEventosBundle:Evento')->findAll();
            $query= $qb->getQuery();

            return $this->render("IanserBuscadorBundle:Default:eventos_filtrats.html.twig", array('eventos' => $query->getResult()));
        }

       return $this->render("IanserBuscadorBundle:Default:filtre.html.twig", array('form'=>$form->createView(), 'evento'=>$evento));
    }
    
}











