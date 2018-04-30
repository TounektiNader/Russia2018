<?php

namespace Match\MatchBundle\Controller;
use Match\MatchBundle\Entity\Equipe;
use Match\MatchBundle\Entity\Partie;
use Match\MatchBundle\Entity\Bet;
use Match\MatchBundle\Entity\Resultat;
use Match\MatchBundle\Form\ResultatType;
use Match\MatchBundle\Services\BetService;
use Match\MatchBundle\Services\PartieService;
use Match\MatchBundle\Services\ResultatService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use \DateTime;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Match\MatchBundle\Entity\Notifacation;


use Match\MatchBundle\sms\SmsGateway;


use Symfony\Component\HttpFoundation\Response;

class ResultatController extends Controller
{

    public function listResultatAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $resultat = $em->getRepository('MatchMatchBundle:Resultat')->findAll();

        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $resultat, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 25)/*page number*/

        );


        return $this->render('MatchMatchBundle:Resultat:list_resultat.html.twig', array("resultats"=>$result

        ));
    }



      public function modifierResulltatAction($id,Request $request) {

          $em = $this->getDoctrine()->getManager();

          $bolAB = $em->getRepository('MatchMatchBundle:Test')->find(1);
          $bolCD = $em->getRepository('MatchMatchBundle:Test')->find(2);
          $bolEF = $em->getRepository('MatchMatchBundle:Test')->find(3);
          $bolGH = $em->getRepository('MatchMatchBundle:Test')->find(4);
          $bol41 = $em->getRepository('MatchMatchBundle:Test')->find(5);
          $bol42 = $em->getRepository('MatchMatchBundle:Test')->find(6);
          $bol43 = $em->getRepository('MatchMatchBundle:Test')->find(7);
          $bol44 = $em->getRepository('MatchMatchBundle:Test')->find(8);
          $bol21 = $em->getRepository('MatchMatchBundle:Test')->find(9);
          $bol22 = $em->getRepository('MatchMatchBundle:Test')->find(10);
          $bolfinal = $em->getRepository('MatchMatchBundle:Test')->find(11);


          $resultat=$em->getRepository('MatchMatchBundle:Resultat')->find($id);

          $partie=$em->getRepository('MatchMatchBundle:Partie')->find($resultat->getIdpartie()->getId());



          $form=$this->createForm(ResultatType::class,$resultat);

          if ($form->handleRequest($request)->isValid())
          {

              if(($resultat->getIdpartie()->getGroupe()!='16es de finale')AND ($resultat->getButhome()==$resultat->getButaway()))

              {

                  $this->get('session')->getFlashBag()->add('Suppression'," Match ne peut pas être null !");
                  return $this->redirectToRoute('updateResultat',array(
                      'id' =>$id));
              }

              else{
              $em->persist($resultat);
              $em->flush();

              $this->updateEtatPartie($resultat->getIdpartie()->getId());
              $this->updateJetonEtat($resultat->getIdpartie()->getId());

              if($partie->getTour()==("16es de finale")) {
                  $this->verficationChangement($resultat->getIdpartie()->getId());
                  }

                  // rani badeltha w lazem netfa9edha
                  else{$this->verficationChangement2emeTour($resultat->getIdpartie()->getId());}

              if($bolAB->getValeur()==1){$this->affectationGroupeAB18Eme();}
              elseif ($bolCD->getValeur()==1){$this->affectationGroupeCD8Eme();}
              elseif ($bolEF->getValeur()==1){$this->affectationGroupeEF8Eme();}
              elseif ($bolGH->getValeur()==1){$this->affectationGroupeGH8Eme();}
              elseif ($bol41->getValeur()==1){$this->affectation4eme1();}
              elseif ($bol42->getValeur()==1){$this->affectation4eme2();}
              elseif ($bol43->getValeur()==1){$this->affectation4eme3();}
              elseif ($bol44->getValeur()==1){$this->affectation4eme4();}
              elseif ($bol21->getValeur()==1){$this->affectation2eme1();}
              elseif ($bol22->getValeur()==1){$this->affectation2eme2();}
              elseif ($bolfinal->getValeur()==1){$this->affectionfinal();}



              return $this->redirectToRoute('resultatList');
          }
          }
          return $this->render('MatchMatchBundle:Resultat:update.html.twig', array('form'=>$form->createView(),'resultat'=>$resultat));
    }













////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function updateEtatPartie($idPartie)
    {

        $em = $this->getDoctrine()->getManager();
        $partie = $em->getRepository('MatchMatchBundle:Partie')->find($idPartie);

        $partie->setEtatmatch('Jouee');

        $em->persist($partie);
        $em->flush();

    }


    public function EquipeGagne($idPartie)
    {

        $equipeGagner = new Equipe();

        $equipe = new Equipe();

        $em = $this->getDoctrine()->getManager();
        $partie = $em->getRepository('MatchMatchBundle:Partie')->find($idPartie);
        $resultat = $em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' => $partie));
        $butHome = $resultat->getButhome();
        $butAway = $resultat->getButaway();

        if ($butHome > $butAway) {
            $equipeGagner=$partie->getHome();

        } elseif ($butAway > $butHome) {
            $equipeGagner = $partie->getAway();

        } else {
            $equipeGagner = $equipe;
        }

        return $equipeGagner;
    }


    public function EquipePerdu($idPartie)
    {

        $equipePerdu = new Equipe();

        $equipe = new Equipe();

        $em = $this->getDoctrine()->getManager();
        $partie = $em->getRepository('MatchMatchBundle:Partie')->find($idPartie);
        $resultat = $em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' => $partie));

        $butHome = $resultat->getButhome();
        $butAway = $resultat->getButaway();

        if ($butHome > $butAway) {
            $equipePerdu = $partie->getAway();

        } elseif ($butAway > $butHome) {
            $equipePerdu = $partie->getHome();

        }

        return $equipePerdu ;
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



    public function verficationChangement($idPartie) {

        $equipeGagner = new Equipe();
        $equipePerdu = new Equipe();
        $equipe = new Equipe();

        $em = $this->getDoctrine()->getManager();
        $partie = $em->getRepository('MatchMatchBundle:Partie')->find($idPartie);
        $resultat = $em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' => $partie));



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
            $this->ChangerChampEquipe($equipeGagner);
            $equipePerdu->setButmarque(($equipePerdu->getButmarque()) + $butAway);
            $equipePerdu->setButencaisse(($equipePerdu->getButencaisse()) + $butHome);
            $equipePerdu->setMatchjouee(($equipePerdu->getMatchjouee()) + 1);
            $equipePerdu->setMatchperdu(($equipePerdu->getMatchperdu()) + 1);
            $this-> ChangerChampEquipe($equipePerdu);

        } else if ($butHome < $butAway) {
            $equipeGagner = $partie->getAway();
            $equipePerdu = $partie->getHome();

            $equipeGagner->setButmarque(($equipeGagner->getButmarque()) + $butAway);
            $equipeGagner->setButencaisse(($equipeGagner->getButencaisse()) + $butHome);
            $equipeGagner->setMatchjouee(($equipeGagner->getMatchjouee()) + 1);
            $equipeGagner->setMatchgagne(($equipeGagner->getMatchgagne()) + 1);
            $equipeGagner->setNombrepoints(($equipeGagner->getNombrepoints()) + 3);
            $this->  ChangerChampEquipe($equipeGagner);
            $equipePerdu->setButmarque(($equipePerdu->getButmarque()) + $butHome);
            $equipePerdu->setButencaisse(($equipePerdu->getButencaisse()) + $butAway);
            $equipePerdu->setMatchjouee(($equipePerdu->getMatchjouee()) + 1);
            $equipePerdu->setMatchperdu(($equipePerdu->getMatchperdu()) + 1);
            $this-> ChangerChampEquipe($equipePerdu);
        } else {

            $equipe->setButencaisse(($equipe->getButencaisse()) + $butHome);
            $equipe->setButmarque(($equipe->getButmarque()) + $butAway);
            $equipe->setNombrepoints(($equipe->getNombrepoints()) + 1);
            $equipe->setMatchnull(($equipe->getMatchnull()) + 1);
            $equipe->setMatchjouee(($equipe->getMatchjouee()) + 1);

            $this->ChangerChampEquipeNull($equipe, $partie->getAway()->getIdequipe(), ($partie->getAway()->getNombrepoints()) + 1);
            $this->  ChangerChampEquipeNull($equipe, $partie->getHome()->getIdequipe(), ($partie->getHome()->getNombrepoints()) + 1);

        }



    }



    public function verficationChangement2emeTour($idPartie) {

        $equipeGagner = new Equipe();
        $equipePerdu = new Equipe();
        $equipe = new Equipe();

        $em = $this->getDoctrine()->getManager();
        $partie = $em->getRepository('MatchMatchBundle:Partie')->find($idPartie);
        $resultat = $em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' => $partie));



        $butHome = $resultat->getButhome();
        $butAway = $resultat->getButaway();

        if ($butHome > $butAway) {
            $equipeGagner = $partie->getHome();
            $equipePerdu = $partie->getAway();

            $equipeGagner->setButmarque(($equipeGagner->getButmarque() + $butHome));
            $equipeGagner->setButencaisse(($equipeGagner->getButencaisse()) + $butAway);
            $equipeGagner->setMatchjouee(($equipeGagner->getMatchjouee()) + 1);
            $equipeGagner->setMatchgagne(($equipeGagner->getMatchgagne()) + 1);

            $this->ChangerChampEquipe($equipeGagner);
            $equipePerdu->setButmarque(($equipePerdu->getButmarque()) + $butAway);
            $equipePerdu->setButencaisse(($equipePerdu->getButencaisse()) + $butHome);
            $equipePerdu->setMatchjouee(($equipePerdu->getMatchjouee()) + 1);
            $equipePerdu->setMatchperdu(($equipePerdu->getMatchperdu()) + 1);
            $this-> ChangerChampEquipe($equipePerdu);

        } else if ($butHome < $butAway) {
            $equipeGagner = $partie->getAway();
            $equipePerdu = $partie->getHome();

            $equipeGagner->setButmarque(($equipeGagner->getButmarque()) + $butAway);
            $equipeGagner->setButencaisse(($equipeGagner->getButencaisse()) + $butHome);
            $equipeGagner->setMatchjouee(($equipeGagner->getMatchjouee()) + 1);
            $equipeGagner->setMatchgagne(($equipeGagner->getMatchgagne()) + 1);

            $this->  ChangerChampEquipe($equipeGagner);
            $equipePerdu->setButmarque(($equipePerdu->getButmarque()) + $butHome);
            $equipePerdu->setButencaisse(($equipePerdu->getButencaisse()) + $butAway);
            $equipePerdu->setMatchjouee(($equipePerdu->getMatchjouee()) + 1);
            $equipePerdu->setMatchperdu(($equipePerdu->getMatchperdu()) + 1);
            $this-> ChangerChampEquipe($equipePerdu);
        } else {

            $equipe->setButencaisse(($equipe->getButencaisse()) + $butHome);
            $equipe->setButmarque(($equipe->getButmarque()) + $butAway);

            $equipe->setMatchnull(($equipe->getMatchnull()) + 1);
            $equipe->setMatchjouee(($equipe->getMatchjouee()) + 1);

            $this->ChangerChampEquipeNull($equipe, $partie->getAway()->getIdequipe(), ($partie->getAway()->getNombrepoints()) );
            $this->  ChangerChampEquipeNull($equipe, $partie->getHome()->getIdequipe(), ($partie->getHome()->getNombrepoints()) );

        }



    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    public function AugmenterJeton($username)
    {
        $em = $this->getDoctrine()->getManager();

        $personne = $em->getRepository('MatchMatchBundle:User')->find($username);

        $nbJetonn = $personne->getJeton() + 2;

        $personne->setJeton($nbJetonn);
        $em->persist($personne);
        $em->flush();

    }

    public function DiminuerJeton($username)
    {

        $em = $this->getDoctrine()->getManager();
        $personne = $em->getRepository('MatchMatchBundle:User')->find($username);
        $nbJetonn = $personne->getJeton() - 1;

        $personne->setJeton($nbJetonn);
        $em->persist($personne);
        $em->flush();


    }

    public function updateEtatBetGain($idBet)
    {

        $em = $this->getDoctrine()->getManager();
        $bet = $em->getRepository('MatchMatchBundle:Bet')->find($idBet);

        $notifications=$em->getRepository('MatchMatchBundle:Notifacation')->findBy(array('idbet' =>$bet ));


        $notification = new Notifacation();
        foreach ($notifications as $notification)
        {
            $notification->setTitre('Gain');
            $em->persist($notification);
            $em->flush();

        }


        $bet->setEtat('Gain');
            $em->persist($bet);
            $em->flush();

        }




    public function updateEtatBetPerte($idBet)
    {




        $em = $this->getDoctrine()->getManager();

        $bet = $em->getRepository('MatchMatchBundle:Bet')->find($idBet);

        $notifications=$em->getRepository('MatchMatchBundle:Notifacation')->findBy(array('idbet' =>$bet ));


        $notification = new Notifacation();
        foreach ($notifications as $notification)
        {
            $notification->setTitre('Perte');
            $em->persist($notification);
            $em->flush();

        }



            $bet->setEtat('Perte');
            $em->persist($bet);
            $em->flush();

        }





    public function updateJetonEtat($idPartie)
    {

        $equipeGagne=$this->EquipeGagne($idPartie);

        $bet = new Bet();
        $em = $this->getDoctrine()->getManager();

        $partie = $em->getRepository('MatchMatchBundle:Partie')->find($idPartie);

        $bets = $em->getRepository('MatchMatchBundle:Bet')->findBy(array('idpartie' => $partie));

        $smsGateway = new SmsGateway('nader.tounekti@esprit.tn', 'mahamahamaha');




        foreach ($bets as $bet) {
            $idEquipeValeur = $bet->getValeur();

            if ($idEquipeValeur == $equipeGagne->getIdequipe()) {

                $this->AugmenterJeton($bet->getUsername());
                $this->updateEtatBetGain($bet->getIdbet());

                $deviceID = 84004;
                $number ='+216'.$bet->getUsername()->getNum();
                $message = ' Vous avez gagnée dans un  pari ; votre solde devient '.$bet->getUsername()->getJeton();;

                $result = $smsGateway->sendMessageToNumber($number , $message, $deviceID);

            } else {

               $this->updateEtatBetPerte($bet->getIdbet());
            }

        }


    }



 ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

   // public static $bolAB = true;

         public function affectationGroupeAB18Eme()
         {
             $em = $this->getDoctrine()->getManager();
             $bolAB = $em->getRepository('MatchMatchBundle:Test')->find(1);



             $ListA = $em->getRepository(Equipe::class)->findEquipe('A');

             $ListB = $em->getRepository(Equipe::class)->findEquipe('B');
             $nombMatchGroupA=$this->nombreMatchParGroupe('A');
             $nombMatchGroupB=$this->nombreMatchParGroupe('B');
             $test=$bolAB->getValeur();





         if (($nombMatchGroupA[0]['nb']== 6) AND ($nombMatchGroupB[0]['nb']== 6) AND  ($test==1))

         {


            $stadeAB = $em->getRepository('MatchMatchBundle:Stades')->find(11);
             $partieA1 = new Partie();

             $partieA1->setHeurepartie('16:00');
             $partieA1->setTour('8es de finale');
             $partieA1->setIdstade($stadeAB);
             $partieA1->setEtiquette('A1');
             $partieA1->setHome($ListA[0]);
             $partieA1->setAway($ListB[1]);
             $partieA1->setEtatmatch('PasEncore');


             $date = "30-06-2018";
             $partieA1->setDatepartie(\DateTime::createFromFormat('d-m-Y',$date));

             $em->persist($partieA1);
             $em->flush();


             $stadeBA = $em->getRepository('MatchMatchBundle:Stades')->find(4);
             $partieB1 = new Partie();

             $partieB1->setHeurepartie('20:00');
             $partieB1->setTour('8es de finale');
             $partieB1->setIdstade($stadeBA);
             $partieB1->setEtiquette('B1');
             $partieB1->setHome($ListB[0]);
             $partieB1->setAway($ListA[1]);
             $partieB1->setEtatmatch('PasEncore');

             $date1 = "01-07-2018";
             $partieB1->setDatepartie(\DateTime::createFromFormat('d-m-Y',$date1));


             $em->persist($partieB1);
             $em->flush();


             $resultat1= new Resultat();
             $partie1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'A1'));
             $resultat1->setIdpartie( $partie1);
             $resultat1->setButhome(0);
             $resultat1->setButaway(0);

             $em->persist($resultat1);
             $em->flush();

             $resultat2= new Resultat();
             $partie2 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'B1'));
             $resultat2->setIdpartie( $partie2);
             $resultat2->setButhome(0);
             $resultat2->setButaway(0);

             $em->persist($resultat2);
             $em->flush();


             $bolAB->setValeur(0);

             $em->persist($bolAB);
             $em->flush();

   }

}

  //  public static $bolCD =true;
    public function affectationGroupeCD8Eme()
    {

        $em = $this->getDoctrine()->getManager();
        $bolCD = $em->getRepository('MatchMatchBundle:Test')->find(2);

        $ListC = $em->getRepository(Equipe::class)->findEquipe('C');
        $ListD = $em->getRepository(Equipe::class)->findEquipe('D');
        $nombMatchGroupC=$this->nombreMatchParGroupe('C');
        $nombMatchGroupD=$this->nombreMatchParGroupe('D');


        if (($nombMatchGroupC[0]['nb'] == 6) && ($nombMatchGroupD[0]['nb'] == 6) &&  ($bolCD->getValeur()==1))

        {
            $stadeCB = $em->getRepository('MatchMatchBundle:Stades')->find(3);
            $partieA1 = new Partie();
            $partieA1->setHeurepartie('16:00');
            $partieA1->setTour('8es de finale');
            $partieA1->setIdstade($stadeCB);
            $partieA1->setEtiquette('C1');
            $partieA1->setHome($ListC[0]);
            $partieA1->setAway($ListD[1]);
            $partieA1->setEtatmatch('PasEncore');
            $date = "30-06-2018";
            $partieA1->setDatepartie(\DateTime::createFromFormat('d-m-Y',$date));


            $partieA1->setDatepartie(\DateTime::createFromFormat('d-m-Y',$date));

            $em->persist($partieA1);
            $em->flush();


            $stadeBA = $em->getRepository('MatchMatchBundle:Stades')->find(5);
            $partieB1 = new Partie();
            $partieB1->setHeurepartie('20:00');
            $partieB1->setTour('8es de finale');
            $partieB1->setIdstade($stadeBA);
            $partieB1->setEtiquette('D1');
            $partieB1->setHome($ListD[0]);
            $partieB1->setAway($ListC[1]);
            $partieB1->setEtatmatch('PasEncore');


            $date1 = "01-07-2018";
            $partieB1->setDatepartie(\DateTime::createFromFormat('d-m-Y',$date1));


            $em->persist($partieB1);
            $em->flush();


            $resultat1= new Resultat();
            $partie1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'C1'));
            $resultat1->setIdpartie( $partie1);
            $resultat1->setButhome(0);
            $resultat1->setButaway(0);

            $em->persist($resultat1);
            $em->flush();

            $resultat2= new Resultat();
            $partie2 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'D1'));
            $resultat2->setIdpartie( $partie2);
            $resultat2->setButhome(0);
            $resultat2->setButaway(0);

            $em->persist($resultat2);
            $em->flush();


            $bolCD->setValeur(0);

            $em->persist($bolCD);
            $em->flush();

        }

    }



   // public static $bolEF =true;
    public function affectationGroupeEF8Eme()
    {

        $em = $this->getDoctrine()->getManager();
        $bolEF = $em->getRepository('MatchMatchBundle:Test')->find(3);

        $ListE = $em->getRepository(Equipe::class)->findEquipe('E');
        $ListF = $em->getRepository(Equipe::class)->findEquipe('F');
        $nombMatchGroupE=$this->nombreMatchParGroupe('E');
        $nombMatchGroupF=$this->nombreMatchParGroupe('F');

        if (($nombMatchGroupE[0]['nb']== 6) && ($nombMatchGroupF[0]['nb']==6) &&   ($bolEF->getValeur()==1))

        {
            $stadeCB = $em->getRepository('MatchMatchBundle:Stades')->find(8);
            $partieA1 = new Partie();
            $partieA1->setHeurepartie('16:00');
            $partieA1->setTour('8es de finale');
            $partieA1->setIdstade($stadeCB);
            $partieA1->setEtiquette('E1');
            $partieA1->setHome($ListE[0]);
            $partieA1->setAway($ListF[1]);
            $partieA1->setEtatmatch('PasEncore');


            $date = "02-07-2018";



            $partieA1->setDatepartie(\DateTime::createFromFormat('d-m-Y',$date));

            $em->persist($partieA1);
            $em->flush();


            $stadeBA = $em->getRepository('MatchMatchBundle:Stades')->find(7);
            $partieB1 = new Partie();
            $partieB1->setHeurepartie('20:00');
            $partieB1->setTour('8es de finale');
            $partieB1->setIdstade($stadeBA);
            $partieB1->setEtiquette('F1');
            $partieB1->setHome($ListF[0]);
            $partieB1->setAway($ListE[1]);
            $partieB1->setEtatmatch('PasEncore');

            $date1 = "03-07-2018";
            $partieB1->setDatepartie(\DateTime::createFromFormat('d-m-Y',$date1));



            $em->persist($partieB1);
            $em->flush();


            $resultat1= new Resultat();
            $partie1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'E1'));
            $resultat1->setIdpartie( $partie1);
            $resultat1->setButhome(0);
            $resultat1->setButaway(0);

            $em->persist($resultat1);
            $em->flush();

            $resultat2= new Resultat();
            $partie2 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'F1'));
            $resultat2->setIdpartie( $partie2);
            $resultat2->setButhome(0);
            $resultat2->setButaway(0);

            $em->persist($resultat2);
            $em->flush();


            $bolEF->setValeur(0);

            $em->persist($bolEF);
            $em->flush();

        }

    }



   // public static $bolGH =true;
    public function affectationGroupeGH8Eme()
    {

        $em = $this->getDoctrine()->getManager();

        $bolGH = $em->getRepository('MatchMatchBundle:Test')->find(4);
        $ListG = $em->getRepository(Equipe::class)->findEquipe('G');
        $ListH = $em->getRepository(Equipe::class)->findEquipe('H');
        $nombMatchGroupG=$this->nombreMatchParGroupe('G');
        $nombMatchGroupH=$this->nombreMatchParGroupe('H');


        if (($nombMatchGroupG[0]['nb'] == 6) && ($nombMatchGroupH[0]['nb'] == 6) &&  ($bolGH->getValeur()==1))

        {
            $stadeCB = $em->getRepository('MatchMatchBundle:Stades')->find(6);
            $partieA1 = new Partie();
            $partieA1->setHeurepartie('16:00');
            $partieA1->setTour('8es de finale');
            $partieA1->setIdstade($stadeCB);
            $partieA1->setEtiquette('G1');
            $partieA1->setHome($ListG[0]);
            $partieA1->setAway($ListH[1]);
            $partieA1->setEtatmatch('PasEncore');


            $date = "02-07-2018";
            $partieA1->setDatepartie(\DateTime::createFromFormat('d-m-Y',$date));


            $em->persist($partieA1);
            $em->flush();


            $stadeBA = $em->getRepository('MatchMatchBundle:Stades')->find(4);
            $partieB1 = new Partie();
            $partieB1->setHeurepartie('20:00');
            $partieB1->setTour('8es de finale');
            $partieB1->setIdstade($stadeBA);
            $partieB1->setEtiquette('H1');
            $partieB1->setHome($ListH[0]);
            $partieB1->setAway($ListG[1]);
            $partieB1->setEtatmatch('PasEncore');


            $date1 = "03-07-2018";
            $partieB1->setDatepartie(\DateTime::createFromFormat('d-m-Y', $date1));


            $em->persist($partieB1);
            $em->flush();


            $resultat1= new Resultat();
            $partie1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'G1'));
            $resultat1->setIdpartie( $partie1);
            $resultat1->setButhome(0);
            $resultat1->setButaway(0);

            $em->persist($resultat1);
            $em->flush();

            $resultat2= new Resultat();
            $partie2 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'H1'));
            $resultat2->setIdpartie( $partie2);
            $resultat2->setButhome(0);
            $resultat2->setButaway(0);

            $em->persist($resultat2);
            $em->flush();


            $bolGH->setValeur(0);

            $em->persist($bolGH);
            $em->flush();

        }

    }




   // public static $bol41 =true;
    public function affectation4eme1() {

          $partieC1 = new Partie();
          $partieA1 = new Partie();

          $em = $this->getDoctrine()->getManager();
        $bol41 = $em->getRepository('MatchMatchBundle:Test')->find(5);

        $partieC1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'C1'));
        $partieA1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'A1'));



     if (($partieC1->getId() == 0) && ($partieA1->getId() == 0)) {
          $partieC1->setEtatMatch("PasEncore");
          $partieA1->setEtatMatch("PasEncore");

    }
    else {

        $equipeGaC1 = $this->EquipeGagne($partieC1->getId());
        $equipeGaA1 = $this->EquipeGagne($partieA1->getId());

    }
    if (($partieC1->getEtatmatch()=='Jouee')&& ($partieA1->getEtatmatch()=='Jouee') && ($bol41->getValeur()==1)) {


            $stadeBA = $em->getRepository('MatchMatchBundle:Stades')->find(5);
            $partieB1 = new Partie();
            $partieB1->setHeurepartie('16:00');
            $partieB1->setTour('4es de finale');
            $partieB1->setIdstade($stadeBA);
            $partieB1->setEtiquette('A11');
            $partieB1->setHome($equipeGaA1);
            $partieB1->setAway($equipeGaC1);
            $partieB1->setEtatmatch('PasEncore');

        $date = "06-07-2018";



            $partieB1->setDatepartie(\DateTime::createFromFormat('d-m-Y',$date));


            $em->persist($partieB1);
            $em->flush();


            $resultat1= new Resultat();
            $partie1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'A11'));
            $resultat1->setIdpartie( $partie1);
            $resultat1->setButhome(0);
            $resultat1->setButaway(0);

            $em->persist($resultat1);
            $em->flush();



        $bol41->setValeur(0);

        $em->persist($bol41);
        $em->flush();
            }


}


    //public static $bol42 =true;
    public function affectation4eme2() {

        $partieC1 = new Partie();
        $partieA1 = new Partie();

        $em = $this->getDoctrine()->getManager();

        $bol42 = $em->getRepository('MatchMatchBundle:Test')->find(6);
        $partieC1 =  $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'E1'));
        $partieA1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'G1'));


        if (($partieC1->getId() == 0) && ($partieA1->getId() == 0)) {
            $partieC1->setEtatMatch("PasEncore");
            $partieA1->setEtatMatch("PasEncore");
        }
        else {


            $equipeGaC1 = $this->EquipeGagne($partieC1->getId());
            $equipeGaA1 = $this->EquipeGagne($partieA1->getId());
        }
            if (($partieC1->getEtatmatch()=='Jouee')&& ($partieA1->getEtatmatch()=='Jouee') && ($bol42->getValeur()==1)) {


                $stadeBA = $em->getRepository('MatchMatchBundle:Stades')->find(3);
                $partieB1 = new Partie();
                $partieB1->setHeurepartie('16:00');
                $partieB1->setTour('4es de finale');
                $partieB1->setIdstade($stadeBA);
                $partieB1->setEtiquette('B11');
                $partieB1->setHome($equipeGaA1);
                $partieB1->setAway($equipeGaC1);
                $partieB1->setEtatmatch('PasEncore');

                $date = "06-07-2018";

                $partieB1->setDatepartie(\DateTime::createFromFormat('d-m-Y',$date));


                $em->persist($partieB1);
                $em->flush();


                $resultat1= new Resultat();
                $partie1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'B11'));
                $resultat1->setIdpartie( $partie1);
                $resultat1->setButhome(0);
                $resultat1->setButaway(0);

                $em->persist($resultat1);
                $em->flush();


                $bol42->setValeur(0);

                $em->persist($bol42);
                $em->flush();
            }


    }



    //public static $bol43 =true;
    public function affectation4eme3() {

        $partieC1 = new Partie();
        $partieA1 = new Partie();

        $em = $this->getDoctrine()->getManager();
        $bol43 = $em->getRepository('MatchMatchBundle:Test')->find(7);
        $partieC1 =  $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'B1'));
        $partieA1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'D1'));


        if (($partieC1->getId() == 0) && ($partieA1->getId() == 0)) {
            $partieC1->setEtatMatch("PasEncore");
            $partieA1->setEtatMatch("PasEncore");
        }
        else {


            $equipeGaC1 = $this->EquipeGagne($partieC1->getId());
            $equipeGaA1 = $this->EquipeGagne($partieA1->getId());
        }
        if (($partieC1->getEtatmatch()=='Jouee')&& ($partieA1->getEtatmatch()=='Jouee') && ($bol43->getValeur()==1)) {


            $stadeBA = $em->getRepository('MatchMatchBundle:Stades')->find(3);
            $partieB1 = new Partie();
            $partieB1->setHeurepartie('16:00');
            $partieB1->setTour('4es de finale');
            $partieB1->setIdstade($stadeBA);
            $partieB1->setEtiquette('C11');
            $partieB1->setHome($equipeGaA1);
            $partieB1->setAway($equipeGaC1);
            $partieB1->setEtatmatch('PasEncore');

            $date = "07-07-2018";


            $partieB1->setDatepartie(\DateTime::createFromFormat('d-m-Y',$date));


            $em->persist($partieB1);
            $em->flush();


            $resultat1= new Resultat();
            $partie1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'C11'));
            $resultat1->setIdpartie( $partie1);
            $resultat1->setButhome(0);
            $resultat1->setButaway(0);

            $em->persist($resultat1);
            $em->flush();


            $bol43->setValeur(0);

            $em->persist($bol43);
            $em->flush();
        }


    }




    //public static $bol44 =true;
    public function affectation4eme4() {

        $partieC1 = new Partie();
        $partieA1 = new Partie();

        $em = $this->getDoctrine()->getManager();
        $bol44 = $em->getRepository('MatchMatchBundle:Test')->find(8);
        $partieC1 =  $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'F1'));
        $partieA1 =  $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'H1'));


        if (($partieC1->getId() == 0) && ($partieA1->getId() == 0)) {
            $partieC1->setEtatMatch("PasEncore");
            $partieA1->setEtatMatch("PasEncore");
        }
        else {


            $equipeGaC1 = $this->EquipeGagne($partieC1->getId());
            $equipeGaA1 = $this->EquipeGagne($partieA1->getId());
        }
        if (($partieC1->getEtatmatch()=='Jouee')&& ($partieA1->getEtatmatch()=='Jouee') && ($bol44->getValeur()==1)) {


            $stadeBA = $em->getRepository('MatchMatchBundle:Stades')->find(8);
            $partieB1 = new Partie();
            $partieB1->setHeurepartie('16:00');
            $partieB1->setTour('4es de finale');
            $partieB1->setIdstade($stadeBA);
            $partieB1->setEtiquette('D11');
            $partieB1->setHome($equipeGaA1);
            $partieB1->setAway($equipeGaC1);
            $partieB1->setEtatmatch('PasEncore');

            $date = "07-07-2018";

            $partieB1->setDatepartie(\DateTime::createFromFormat('d-m-Y',$date));


            $em->persist($partieB1);
            $em->flush();


            $resultat1= new Resultat();
            $partie1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'D11'));
            $resultat1->setIdpartie( $partie1);
            $resultat1->setButhome(0);
            $resultat1->setButaway(0);

            $em->persist($resultat1);
            $em->flush();


            $bol44->setValeur(0);

            $em->persist($bol44);
            $em->flush();
        }


    }


    //public static $bol21 =true;
    public function affectation2eme1() {

        $partieC1 = new Partie();
        $partieA1 = new Partie();

        $em = $this->getDoctrine()->getManager();
        $bol21 = $em->getRepository('MatchMatchBundle:Test')->find(9);
        $partieC1 =  $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'A11'));
        $partieA1 =  $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'B11'));


        if (($partieC1->getId() == 0) && ($partieA1->getId() == 0)) {
            $partieC1->setEtatMatch("PasEncore");
            $partieA1->setEtatMatch("PasEncore");
        }
        else {


            $equipeGaC1 = $this->EquipeGagne($partieC1->getId());
            $equipeGaA1 = $this->EquipeGagne($partieA1->getId());
        }
        if (($partieC1->getEtatmatch()=='Jouee')&& ($partieA1->getEtatmatch()=='Jouee') && ($bol21->getValeur()==1)) {


            $stadeBA = $em->getRepository('MatchMatchBundle:Stades')->find(7);
            $partieB1 = new Partie();
            $partieB1->setHeurepartie('20:00');
            $partieB1->setTour('Demi Finale');
            $partieB1->setIdstade($stadeBA);
            $partieB1->setEtiquette('A111');
            $partieB1->setHome($equipeGaA1);
            $partieB1->setAway($equipeGaC1);
            $partieB1->setEtatmatch('PasEncore');

            $date = "10-07-2018";



            $partieB1->setDatepartie(\DateTime::createFromFormat('d-m-Y',$date));


            $em->persist($partieB1);
            $em->flush();


            $resultat1= new Resultat();
            $partie1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'A111'));
            $resultat1->setIdpartie( $partie1);
            $resultat1->setButhome(0);
            $resultat1->setButaway(0);

            $em->persist($resultat1);
            $em->flush();


            $bol21->setValeur(0);

            $em->persist($bol21);
            $em->flush();
        }


    }


    //public static $bol22 =true;
    public function affectation2eme2() {

        $partieC1 = new Partie();
        $partieA1 = new Partie();

        $em = $this->getDoctrine()->getManager();
        $bol22 = $em->getRepository('MatchMatchBundle:Test')->find(10);

        $partieC1 =  $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'C11'));
        $partieA1 =  $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'D11'));


        if (($partieC1->getId() == 0) && ($partieA1->getId() == 0)) {
            $partieC1->setEtatMatch("PasEncore");
            $partieA1->setEtatMatch("PasEncore");
        }
        else {


            $equipeGaC1 = $this->EquipeGagne($partieC1->getId());
            $equipeGaA1 = $this->EquipeGagne($partieA1->getId());
        }
        if (($partieC1->getEtatmatch()=='Jouee')&& ($partieA1->getEtatmatch()=='Jouee') && ($bol22->getValeur()==1)) {


            $stadeBA = $em->getRepository('MatchMatchBundle:Stades')->find(4);
            $partieB1 = new Partie();
            $partieB1->setHeurepartie('20:00');
            $partieB1->setTour('Demi Finale');
            $partieB1->setIdstade($stadeBA);
            $partieB1->setEtiquette('B111');
            $partieB1->setHome($equipeGaA1);
            $partieB1->setAway($equipeGaC1);
            $partieB1->setEtatmatch('PasEncore');

            $date = "11-07-2018";

            $partieB1->setDatepartie(\DateTime::createFromFormat('d-m-Y',$date));


            $em->persist($partieB1);
            $em->flush();


            $resultat1= new Resultat();
            $partie1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'B111'));
            $resultat1->setIdpartie( $partie1);
            $resultat1->setButhome(0);
            $resultat1->setButaway(0);

            $em->persist($resultat1);
            $em->flush();


            $bol22->setValeur(0);

            $em->persist($bol22);
            $em->flush();
        }


    }

    //public static $bolfinal =true;
    public function affectionfinal() {

        $partieC1 = new Partie();
        $partieA1 = new Partie();

        $em = $this->getDoctrine()->getManager();
        $bolfinal = $em->getRepository('MatchMatchBundle:Test')->find(11);

        $partieC1 =  $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'A111'));
        $partieA1 =  $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'B111'));


        if (($partieC1->getId() == 0) && ($partieA1->getId() == 0)) {
            $partieC1->setEtatMatch("PasEncore");
            $partieA1->setEtatMatch("PasEncore");
        }
        else {


            $equipeGaC1 = $this->EquipeGagne($partieC1->getId());
            $equipeGaA1 = $this->EquipeGagne($partieA1->getId());

            $equipePeC1 = $this->EquipePerdu($partieC1->getId());
            $equipePeA1 = $this->EquipePerdu($partieA1->getId());
        }
        if (($partieC1->getEtatmatch()=='Jouee')&& ($partieA1->getEtatmatch()=='Jouee') && ($bolfinal->getValeur()==1)) {


            $stadeBA = $em->getRepository('MatchMatchBundle:Stades')->find(4);
            $partieB1 = new Partie();
            $partieB1->setHeurepartie('17:00');
            $partieB1->setTour('Finale');
            $partieB1->setIdstade($stadeBA);
            $partieB1->setEtiquette('A1111');
            $partieB1->setHome($equipeGaA1);
            $partieB1->setAway($equipeGaC1);
            $partieB1->setEtatmatch('PasEncore');

            $date = "15-07-2018";


            $partieB1->setDatepartie(\DateTime::createFromFormat('d-m-Y',$date));


            $em->persist($partieB1);
            $em->flush();


            $resultat1= new Resultat();
            $partie1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'A1111'));
            $resultat1->setIdpartie( $partie1);
            $resultat1->setButhome(0);
            $resultat1->setButaway(0);

            $em->persist($resultat1);
            $em->flush();






            $stade = $em->getRepository('MatchMatchBundle:Stades')->find(7);
            $partieA1 = new Partie();
            $partieA1->setHeurepartie('16:00');
            $partieA1->setTour('3eme Place');
            $partieA1->setIdstade($stade);
            $partieA1->setEtiquette('B1111');
            $partieA1->setHome($equipePeA1);
            $partieA1->setAway($equipePeC1);
            $partieA1->setEtatmatch('PasEncore');


            $date1 = "14-07-2018";

            $partieA1->setDatepartie(\DateTime::createFromFormat('d-m-Y',$date1));


            $em->persist($partieA1);
            $em->flush();


            $resultat= new Resultat();
            $par = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'B1111'));
            $resultat->setIdpartie( $par);
            $resultat->setButhome(0);
            $resultat->setButaway(0);

            $em->persist($resultat);
            $em->flush();


            $bolfinal->setValeur(0);

            $em->persist($bolfinal);
            $em->flush();
        }


    }



////////////////////////////////////////////////////////////////////////////////////////////////////////////
  public function nombreMatchParGroupe($groupe) {

      $em=$this->getDoctrine()->getManager();
      $nombreMatch= $em->getRepository(Partie::class)->nombrePartieGroupe($groupe);

        return $nombreMatch;

    }



    public function alllResultJAction()
    {$tasks = $this->getDoctrine()->getManager()
        ->getRepository('MatchMatchBundle:Resultat')
        ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
        //return $this->render('MatchMatchBundle:Default:son.html.twig');
    }


}
