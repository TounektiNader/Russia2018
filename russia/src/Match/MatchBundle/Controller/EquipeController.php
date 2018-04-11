<?php

namespace Match\MatchBundle\Controller;

use Match\MatchBundle\Entity\Equipe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EquipeController extends Controller
{
    public function classementAction()
    {
        $us = $this->getUser();


        $em = $this->getDoctrine()->getManager();
        $equipes= $em->getRepository(Equipe::class)->findEquipe('A');

        $parties= $em->getRepository(Equipe::class)->findPartie('A');

        $resultats= $em->getRepository('MatchMatchBundle:Resultat')->findBy(array('idpartie' =>$parties));

        $bets= $em->getRepository('MatchMatchBundle:Bet')->findBy(array('username' =>$us));

        return $this->render('MatchMatchBundle:Partie:classementMatch.html.twig',array('equipes'=>$equipes,'parties'=>$resultats,'bets'=>$bets));
    }

    public function classementGroupeAction($groupe)

    {
        $us = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $equipes= $em->getRepository(Equipe::class)->findEquipe($groupe);
        $parties= $em->getRepository(Equipe::class)->findPartie($groupe);

        $resultats= $em->getRepository('MatchMatchBundle:Resultat')->findBy(array('idpartie' =>$parties));
        $bets= $em->getRepository('MatchMatchBundle:Bet')->findBy(array('username' =>$us));

        return $this->render('MatchMatchBundle:Partie:classementMatch.html.twig',array('equipes'=>$equipes,'parties'=>$resultats,'bets'=>$bets));
    }

    public function MesBetsAction()
    {
        return $this->render('MatchMatchBundle:Bet:ListBet.html.twig');
    }

}
