<?php

namespace Ianser\BuscadorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ianser\BuscadorBundle\Form\BuscadorType;
use Ianser\EventosBundle\Entity\Evento;
use Doctrine\ORM;
use Ianser\UserBundle\Entity\Usuarioeventos;
use Symfony\Component\HttpFoundation\Response;
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
        $usuari=$this->getUser();

        if ($form->isValid()) {
            $qb = $em->createQueryBuilder();
            $qb->select('e')->from('IanserEventosBundle:Evento', 'e');
            
            if(!is_null($evento->getNombre())){
               $qb->andwhere("e.nombre LIKE :nom");
               $qb->setParameter("nom", '%'.$evento->getNombre().'%');
            }
            
            if(!is_null($evento->getCiudad())){
               $qb->andwhere("e.ciudad LIKE :ciutat");
               $qb->setParameter("ciutat", '%'.$evento->getCiudad().'%');
            }
            
            if(!is_null($evento->getTipo())){
               $qb->andwhere("e.tipo LIKE :tipo");
               $qb->setParameter("tipo", '%'.$evento->getTipo().'%');
            }
            
            if(!is_null($evento->getAforo())){
               $qb->andwhere("e.aforo LIKE :aforo");
               $qb->setParameter("aforo", '%'.$evento->getAforo().'%');
            }
            
            if(!is_null($evento->getEdad())){
               $qb->andwhere("e.edad LIKE :edad");
               $qb->setParameter("edad", '%'.$evento->getEdad().'%');
            }
            
            if(!is_null($evento->getGratuito())){
               $qb->andwhere("e.gratuito LIKE :gratuito");
               $qb->setParameter("gratuito", '%'.$evento->getGratuito().'%');
            }

            $query= $qb->getQuery();
            $eventos= $query->getResult();
            $Aeventos=array();
            foreach($eventos as $evento){
                $comprova_existencia= $em->getRepository('IanserUserBundle:Usuarioeventos')->findOneBy(array("fkuser"=>$usuari, "fkevento"=>$evento));
                if(is_object($comprova_existencia)){
                    $evento->setAsiste("si");
                }
                else{
                    $evento->setAsiste("no");
                }
                array_push($Aeventos, $evento);
            }

            return $this->render("IanserBuscadorBundle:Default:eventos_filtrats.html.twig", array('eventos' => $Aeventos));
        }

       return $this->render("IanserBuscadorBundle:Default:filtre.html.twig", array('form'=>$form->createView(), 'evento'=>$evento));
    }
    
    /**
     * @Route("/detall/{id}", name="buscador_detall")
     */
    public function DetallAction($id){
        $em = $this->getDoctrine()->getManager();
        $evento = $em->getRepository('IanserEventosBundle:Evento')->find($id);
        $usuari=$this->getUser();
        $comprova_existencia= $em->getRepository('IanserUserBundle:Usuarioeventos')->findOneBy(array("fkuser"=>$usuari, "fkevento"=>$evento));
        if(is_object($comprova_existencia)){
            $evento->setAsiste("si");
        }
        else{
            $evento->setAsiste("no");
        }

        
        return $this->render("IanserBuscadorBundle:Default:detall.html.twig", array('evento'=>$evento));
    }
    
    /**
     * @Route("/asistencia/{id_evento}", name="buscador_asistencia", options = { "expose" = true })
     */
    public function ToggleAsistenciaAction($id_evento){
        $em= $this->getDoctrine()->getManager();
        $usuari= $this->getUser();
        
        $evento= $em->getRepository('IanserEventosBundle:Evento')->findOneBy(array("idevento"=>$id_evento));
        $comprova_existencia= $em->getRepository('IanserUserBundle:Usuarioeventos')->findOneBy(array("fkuser"=>$usuari, "fkevento"=>$evento));
        
        if(is_object($comprova_existencia)){
            $em->remove($comprova_existencia);
            $em->flush();
            return new Response("false");
        }
        
        else{
            $afegir_evento= new Usuarioeventos();
            $afegir_evento->setFkuser($usuari);
            $afegir_evento->setFkevento($evento);
            $em->persist($afegir_evento);
            $em->flush();
            return new Response("true");
        }
        
    }

    
}











