<?php

namespace Ianser\BuscadorBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Ianser\BuscadorBundle\Form\BuscadorType;
use Ianser\EventosBundle\Entity\Evento;
use Doctrine\ORM;
use Ianser\UserBundle\Entity\Usuarioeventos;
use Ianser\UserBundle\Entity\Usuariochats;
use Symfony\Component\HttpFoundation\Response;
use Ianser\ChatsBundle\Entity\Chats;
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

            return $this->render("IanserBuscadorBundle:Default:eventos_filtrats.html.twig", array('eventos' => $query->getResult()));
        }

       return $this->render("IanserBuscadorBundle:Default:filtre.html.twig", array('form'=>$form->createView(), 'evento'=>$evento));
    }
    
    /**
     * @Route("/detall/{id}", name="buscador_detall")
     */
    public function DetallAction($id){
        $em = $this->getDoctrine()->getManager();
        $evento = $em->getRepository('IanserEventosBundle:Evento')->find($id);
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
    
    /**
     * @Route("/chat/{id_evento}", name="buscador_chat", options = { "expose" = true })
     */
    public function ToggleChatAction($id_evento){
        $em= $this->getDoctrine()->getManager();
        $usuari= $this->getUser();
        
        $evento= $em->getRepository('IanserEventosBundle:Evento')->findOneBy(array("idevento"=>$id_evento));
        $chat= $em->getRepository('IanserChatsBundle:Chats')->findOneBy(array("fkevento"=>$evento));
        $comprova_existencia= $em->getRepository('IanserUserBundle:Usuariochats')->findOneBy(array("fkuser"=>$usuari, "fkchat"=>$chat));
        
        if(is_object($comprova_existencia)){
            $em->remove($comprova_existencia);
            $em->flush();
            return new Response("false");
        }
        
        else{
            $afegir_chat= new Usuariochats();
            $afegir_chat->setFkuser($usuari);
            $afegir_chat->setFkchat($chat);
            $em->persist($afegir_chat);
            $em->flush();
            return new Response("true");
        }
        
    }
    
}











