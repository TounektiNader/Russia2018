<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 21/03/2018
 * Time: 20:39
 */

namespace Match\MatchBundle\Services;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Match\MatchBundle\Entity\Equipe;

class ResultatService extends Controller
{


    public function EquipeGagne($idPartie)
{

    $equipeGagner = new Equipe();

    $equipe = new Equipe();

    $em = $this->getDoctrine()->getManager();
    $partie = $em->getRepository('MatchMatchBundle:Partie')->find($idPartie);
    $resultat = $em->getRepository('MatchMatchBundle:Resultat')->findByidpartie($partie);
    $butHome = $resultat->getButhome();
    $butAway = $resultat->getButaway();

    if ($butHome > $butAway) {
        $equipeGagner=$partie->getHome();

    } elseif ($butAway > $butHome) {
        $equipeGagner = $partie->getAway();

    } else {
        $equipeGagner = $equipe;
    }

    return equipeGagner;
}


    public function EquipePerdu($idPartie)
    {

        $equipePerdu = new Equipe();

        $equipe = new Equipe();

        $em = $this->getDoctrine()->getManager();
        $partie = $em->getRepository('MatchMatchBundle:Partie')->find($idPartie);
        $resultat = $em->getRepository('MatchMatchBundle:Resultat')->findByidpartie($partie);
        $butHome = $resultat->getButhome();
        $butAway = $resultat->getButaway();

        if ($butHome > $butAway) {
            $equipePerdu = $partie->getAway();

        } elseif ($butAway > $butHome) {
            $equipePerdu = $partie->getHome();

        }

        return equipePerdu ;
    }


   public function verficationChangement($idPartie) {

 $equipeGagner = new Equipe();
 $equipePerdu = new Equipe();
 $equipe = new Equipe();

    $em = $this->getDoctrine()->getManager();
    $partie = $em->getRepository('MatchMatchBundle:Partie')->find($idPartie);
    $resultat = $em->getRepository('MatchMatchBundle:Resultat')->findByidPartie($idPartie);

    $butHome = $resultat->getButhome();
    $butAway = $resultat->getButaway();

  if ($butHome > $butAway) {
    $equipeGagner = $partie->getHome();
    $equipePerdu = $partie->getAway();

    $equipeGagner->setButmarque(($equipeGagner->getButmarque() + $butHome));
    $equipeGagner->setButencaisse(($equipeGagner->getButencaisse()) + $butAway);
    $equipeGagner->setMatchjouee(($equipeGagner->getMatchjouee()) + 1);
    $equipeGagner->setMatchgagne(($equipeGagner->getMatchgagne()) + 1);
    $equipeGagner->setNombrepoints(($equipeGagner->getNombrepoints()) + 3);
   ChangerChampEquipe($equipeGagner);
    $equipePerdu->setButmarque(($equipePerdu->getButmarque()) + $butAway);
    $equipePerdu->setButencaisse(($equipePerdu->getButencaisse()) + $butHome);
    $equipePerdu->setMatchjouee(($equipePerdu->getMatchjouee()) + 1);
    $equipePerdu->setMatchperdu(($equipePerdu->getMatchperdu()) + 1);
ChangerChampEquipe($equipePerdu);

} else if ($butHome < $butAway) {
    $equipeGagner = $partie->getAway();
    $equipePerdu = $partie->getHome();

    $equipeGagner->setButmarque(($equipeGagner->getButmarque()) + $butAway);
    $equipeGagner->setButencaisse(($equipeGagner->getButencaisse()) + $butHome);
    $equipeGagner->setMatchjouee(($equipeGagner->getMatchjouee()) + 1);
    $equipeGagner->setMatchgagne(($equipeGagner->getMatchgagne()) + 1);
    $equipeGagner->setNombrepoints(($equipeGagner->getNombrepoints()) + 3);
    ChangerChampEquipe($equipeGagner);
    $equipePerdu->setButmarque(($equipePerdu->getButmarque()) + $butHome);
    $equipePerdu->setButencaisse(($equipePerdu->getButencaisse()) + $butAway);
    $equipePerdu->setMatchjouee(($equipePerdu->getMatchjouee()) + 1);
    $equipePerdu->setMatchperdu(($equipePerdu->getMatchperdu()) + 1);
    ChangerChampEquipe($equipePerdu);
} else {

    $equipe->setButencaisse(($equipe->getButencaisse()) + $butHome);
    $equipe->setButmarque(($equipe->getButmarque()) + $butAway);
    $equipe->setNombrepoints(($equipe->getNombrepoints()) + 1);
    $equipe->setMatchnull(($equipe->getMatchnull()) + 1);
    $equipe->setMatchjouee(($equipe->getMatchjouee()) + 1);

      ChangerChampEquipeNull($equipe, $partie->getAway()->getIdequipe(), ($partie->getAway()->getNombrepoints()) + 1);
      ChangerChampEquipeNull($equipe, $partie->getHome()->getIdequipe(), ($partie->getHome()->getNombrepoints()) + 1);

}



    }


public function ChangerChampEquipe($equipe)
{
    $em = $this->getDoctrine()->getManager();
    $equipes = $em->getRepository('MatchMatchBundle:Equipe')->find($equipe->getIdequipe());

    $equipes->setButmarque($equipe->getButmarque());
    $equipes->setButencaisse($equipe->getButencaisse());
    $equipes->setMatchjouee($equipe->getMatchjouee());
    $equipes->setMatchnull($equipe->getMatchnull());
    $equipes->setMatchgagne($equipe->getMatchgagne());
    $equipes->setMatchperdu($equipe->getMatchperdu());
    $equipes->setNombrepoints($equipe->getNombrepoints());


    $em->persist($equipes);
    $em->flush();


}


    public function ChangerChampEquipeNull($equipe,$idEquipe, $nbPoints)
    {
        $em = $this->getDoctrine()->getManager();
        $equipes = $em->getRepository('MatchMatchBundle:Equipe')->find($idEquipe);

        $equipes->setButmarque($equipe->getButmarque());
        $equipes->setButencaisse($equipe->getButencaisse());
        $equipes->setMatchjouee($equipe->getMatchjouee());
        $equipes->setMatchnull($equipe->getMatchnull());
        $equipes->setMatchgagne($equipe->getMatchgagne());

        $equipes->setNombrepoints($nbPoints);
        $equipes->setMatchperdu($equipe->getMatchperdu());

        $em->persist($equipes);
        $em->flush();


    }




}