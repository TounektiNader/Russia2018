<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 21/03/2018
 * Time: 23:21
 */

namespace Match\MatchBundle\Services;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Match\MatchBundle\Entity\Bet;

class BetService  extends Controller
{

    public function AugmenterJeton($username)
    {
        $em = $this->getDoctrine()->getManager();
        $personne = $em->getRepository('MatchMatchBundle:user')->find($username);
        $nbJetonn = $personne->getJeton() + 2;

        $personne->setJeton($nbJetonn);
        $em->remove($personne);
        $em->flush();

    }

    public function DiminuerJeton($username)
    {

        $em = $this->getDoctrine()->getManager();
        $personne = $em->getRepository('MatchMatchBundle:User')->find($username);
        $nbJetonn = $personne->getJeton() - 1;

        $personne->setJeton($nbJetonn);
        $em->remove($personne);
        $em->flush();


    }

    public function updateEtatBetGain($idPartie)
    {
        $bet = new Bet();
        $em = $this->getDoctrine()->getManager();
        $bets = $em->getRepository('MatchMatchBundle:Bet')->find($idPartie);

        foreach ($bets as $bet) {
            $bet->setJeton('Gain');
            $em->remove($bet);
            $em->flush();

        }

    }


    public function updateEtatBetPerte($idPartie)
    {



        $bet = new Bet();
        $em = $this->getDoctrine()->getManager();
        $bets = $em->getRepository('MatchMatchBundle:Bet')->find($idPartie);

        foreach ($bets as $bet) {
            $bet->setJeton('Perte');
            $em->remove($bet);
            $em->flush();

        }


    }


    public function updateJetonEtat($idPartie)
    {
        $resultatSerivce = new ResultatService() ;

        $equipeGagne=$resultatSerivce->EquipeGagne($idPartie);

        $bet = new Bet();
        $em = $this->getDoctrine()->getManager();
        //a vérifier el 7ajja  hethi est findya3melha bil id wela bil objet kkoulou

        $bets = $em->getRepository('MatchMatchBundle:Bet')->findByidPartie($idPartie);


        foreach ($bets as $bet) {
            $idEquipeValeur = $bet->getValeur();
            if ($idEquipeValeur == $equipeGagne->getIdequipe()) {
                AugmenterJeton($bet->getUsername());
                updateEtatBetGain($idPartie);

            } else {
                updateEtatBetPerte($idPartie);
            }

        }





    }


        }