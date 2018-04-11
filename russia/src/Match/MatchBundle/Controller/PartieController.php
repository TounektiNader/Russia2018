<?php

namespace Match\MatchBundle\Controller;

use Match\MatchBundle\Entity\Bet;
use Match\MatchBundle\Entity\Equipe;
use Match\MatchBundle\Entity\Notifacation;
use Match\MatchBundle\Entity\Partie;
use Match\MatchBundle\Entity\Resultat;
use Match\MatchBundle\Form\BetType;
use Match\MatchBundle\Form\EquipeType;
use Match\MatchBundle\Form\PartieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Match\MatchBundle\Services\ResultatService;

class PartieController extends Controller
{
    public function listMatchAction(Request $request)
    {


        $em=$this->getDoctrine()->getManager();
        $parties = $em->getRepository('MatchMatchBundle:Partie')->findAll();

        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $parties, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 10)/*page number*/

        );




        return $this->render('MatchMatchBundle:Partie:list_match.html.twig', array("parties"=>$result

        ));
    }

	public function supprimerMatchAction($id)
{
    $em = $this->getDoctrine()->getManager();
    $mark=$em->getRepository('MatchMatchBundle:Partie')->find($id);

    $em->remove($mark);
    $em->flush();
    $this->get('session')->getFlashBag()->add('Suppression'," Partie Supprimé !");
    return $this->redirectToRoute('list_match');
}


    public function ajoutPartieAction(Request $request)
    {

        $em=$this->getDoctrine()->getManager();
        $groupe= $em->getRepository(Partie::class)->selectDQL();


        $equipes = $em->getRepository('MatchMatchBundle:Equipe')->findAll();
        $stades = $em->getRepository('MatchMatchBundle:Stades')->findAll();


        $partie= new Partie();
        $form = $this->createForm(PartieType::class,$partie);


        if($form->handleRequest($request)->isValid())
                {

                    $home=$request->get('CHome');
                    $away=$request->get('CAway');
                    $stade=$request->get('CStade');
                    $groupe=$request->get('CGroup');




                    $home1 = $em ->getRepository('MatchMatchBundle:Equipe')->find($home);
                    $away1 = $em ->getRepository('MatchMatchBundle:Equipe')->find($away);
                    $stade1 = $em ->getRepository('MatchMatchBundle:Stades')->find($stade);
if($home1==$away1){


    $this->get('session')->getFlashBag()->add('Suppression',"Vous ne pouvez pas jouer un match avec deux équipes similaire !");
    return $this->redirectToRoute('ajoutPartie');

}
else{

                    $partie->setHome($home1);
                    $partie->setAway($away1);
                    $partie->setIdstade($stade1);
                    $partie->setEtatmatch('PasEncore');
                    $partie->setTour('16es de finale');
                    $partie->setGroupe($groupe);

                    $em->persist($partie);
                    $em->flush();
                    $resultat1= new Resultat();

                    $resultat1->setIdpartie($partie);

                    $resultat1->setButhome(0);
                    $resultat1->setButaway(0);

                    $em->persist($resultat1);
                    $em->flush();



                    $this->get('session')->getFlashBag()->add('succes'," Ajout Partie avec Succès !");

            return $this->redirectToRoute('list_match');
}

                    }
        return $this->render('MatchMatchBundle:Partie:ajoutPartie.html.twig', array( 'f'=>$form->createView(),'equipes'=>$equipes,'stades'=>$stades ,'groupes'=>$groupe ));

    }

    public function modifierAction($id,Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $groupe= $em->getRepository(Partie::class)->selectDQL();


        $equipes = $em->getRepository('MatchMatchBundle:Equipe')->findAll();
        $stades = $em->getRepository('MatchMatchBundle:Stades')->findAll();
        $partie=$em->getRepository('MatchMatchBundle:Partie')->find($id);
        $gr  = $partie->getGroupe();
        $ho  = $partie->getHome();
        $aw  = $partie->getAway();
        $st  = $partie->getIdstade();


        $form=$this->createForm(PartieType::class,$partie);
        if ($form->handleRequest($request)->isValid())
        {

            $home=$request->get('CHome');
            $away=$request->get('CAway');
            $stade=$request->get('CStade');
            $groupe=$request->get('CGroup');




            $home1 = $em ->getRepository('MatchMatchBundle:Equipe')->find($home);
            $away1 = $em ->getRepository('MatchMatchBundle:Equipe')->find($away);
            $stade1 = $em ->getRepository('MatchMatchBundle:Stades')->find($stade);

            $partie->setHome($home1);
            $partie->setAway($away1);
            $partie->setIdstade($stade1);
            $partie->setEtatmatch('PasEncore');
            $partie->setTour('16es de finale');
            $partie->setGroupe($groupe);

            $em->persist($partie);
            $em->flush();
            return $this->redirectToRoute('list_match');
        }
        return $this->render('MatchMatchBundle:Partie:edit.html.twig', array( 'f'=>$form->createView(),'equipes'=>$equipes,'stades'=>$stades ,'groupes'=>$groupe,
            'ho'=>$ho,'go'=>$gr,'aw'=>$aw,'st'=>$st));
    }


    public function programmeMatchAction(Request $request)
    {

        $us = $this->getUser();


        $em=$this->getDoctrine()->getManager();



        $last= $em->getRepository(Partie::class)->lastParties();






            if(count($last)>=1)
                $match1=$last[0];

        else   $match1= new Partie();




        if(count($last)>=2)
              $match2=$last[1];
        else  $match2= new Partie();

            if(count($last)>2)
             $match3=$last[2];
              else  $match3= new Partie();





        $equipes = $em->getRepository('MatchMatchBundle:Equipe')->findAll();

        $equipe = new Equipe();

        $forrrr = $this->createForm(EquipeType::class,$equipe);

        $bets= $em->getRepository('MatchMatchBundle:Bet')->findBy(array('username' =>$us));
        $partieA1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'A1'));
        $resultatA1=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieA1));


        $partieB1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'B1'));
        $resultatB1=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieB1));


        $partieC1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'C1'));
        $resultatC1=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieC1));


        $partieD1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'D1'));
        $resultatD1=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieD1));


        $partieE1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'E1'));
        $resultatE1=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieE1));


        $partieF1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'F1'));
        $resultatF1=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieF1));


        $partieG1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'G1'));
        $resultatG1=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieG1));



        $partieH1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'H1'));
        $resultatH1=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieH1));



        $partieA11 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'A11'));
        $resultatA11=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieA11));


        $partieB11 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'B11'));
        $resultatB11=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieB11));



        $partieC11 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'C11'));
        $resultatC11=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieC11));


        $partieD11 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'D11'));
        $resultatD11=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieD11));


        $partieA111 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'A111'));
        $resultatA111=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieA111));


        $partieB111 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'B111'));
        $resultatB111=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieB111));



        $partieA1111 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'A1111'));
        $resultatA1111=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieA1111));


        $partieB1111 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'B1111'));
        $resultatB1111=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieB1111));



        $parties = $em->getRepository('MatchMatchBundle:Partie')->findAll();

        $resultats= $em->getRepository('MatchMatchBundle:Resultat')->findBy(array('idpartie' =>$parties));

        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $resultats,
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 10)/*page number*/

        );



        if($forrrr->handleRequest($request)->isValid())

        {

            $id=$request->get('equipe');


            $equipe = $em ->getRepository('MatchMatchBundle:Equipe')->find($id);



            $parties= $em->getRepository(Partie::class)->findPartieEquipe($equipe);



            $resultats= $em->getRepository('MatchMatchBundle:Resultat')->findBy(array('idpartie' =>$parties));

            $paginator  = $this->get('knp_paginator');
            $result = $paginator->paginate(
                $resultats,
                $request->query->getInt('page', 1)/*page number*/,
                $request->query->getInt('limit', 10)/*page number*/);

            return $this->render('MatchMatchBundle:Partie:programme.html.twig', array(

                "parties"=>$result,
                "partieA1"=>$resultatA1,
                "partieB1"=>$resultatB1,
                "partieC1"=>$resultatC1,
                "partieD1"=>$resultatD1,
                "partieE1"=>$resultatE1,
                "partieF1"=>$resultatF1,
                "partieG1"=>$resultatG1,
                "partieH1"=>$resultatH1,

                "partieA11"=>$resultatA11,
                "partieB11"=>$resultatB11,
                "partieC11"=>$resultatC11,
                "partieD11"=>$resultatD11,


                "partieA111"=>$resultatA111,
                "partieB111"=>$resultatB111,

                "partieA1111"=>$resultatA1111,
                "partieB1111"=>$resultatB1111,
                'bets'=>$bets,
                'f'=>$forrrr->createView(),
                'equipes'=>$equipes,
                'match1'=>$match1,
                'match2'=>$match2,
                'match3'=>$match3

            ));

        }





        return $this->render('MatchMatchBundle:Partie:programme.html.twig', array(

            "parties"=>$result,
            "partieA1"=>$resultatA1,
            "partieB1"=>$resultatB1,
            "partieC1"=>$resultatC1,
            "partieD1"=>$resultatD1,
            "partieE1"=>$resultatE1,
            "partieF1"=>$resultatF1,
            "partieG1"=>$resultatG1,
            "partieH1"=>$resultatH1,

            "partieA11"=>$resultatA11,
            "partieB11"=>$resultatB11,
            "partieC11"=>$resultatC11,
            "partieD11"=>$resultatD11,


            "partieA111"=>$resultatA111,
            "partieB111"=>$resultatB111,

            "partieA1111"=>$resultatA1111,
            "partieB1111"=>$resultatB1111,
            'bets'=>$bets,
            'f'=>$forrrr->createView(),
            'equipes'=>$equipes,
            'match1'=>$match1,
            'match2'=>$match2,
            'match3'=>$match3

        ));
    }

    public function searchEquipeAction(Request $request)
         {


             $em=$this->getDoctrine()->getManager();
             $parties = $em->getRepository('MatchMatchBundle:Partie')->findAll();

             $resultats= $em->getRepository('MatchMatchBundle:Resultat')->findBy(array('idpartie' =>$parties));

             $paginator  = $this->get('knp_paginator');
             $result = $paginator->paginate(
                 $resultats,
                 $request->query->getInt('page', 1)/*page number*/,
                 $request->query->getInt('limit', 10)/*page number*/

             );


        if($request->getMethod()=="POST") {
            $equipe= $em->getRepository(Equipe::class)->findEquipeRecherche($request->get('serie'));

            $parties = $em->getRepository('MatchMatchBundle:Partie')->findBy(array('idpartie' =>$equipe));

            $resultats= $em->getRepository('MatchMatchBundle:Resultat')->findBy(array('idpartie' =>$parties));

            $paginator  = $this->get('knp_paginator');
            $result = $paginator->paginate(
                $resultats,
                $request->query->getInt('page', 1)/*page number*/,
                $request->query->getInt('limit', 10)/*page number*/);

            return $this->render('MyAppMyxBundle:Voiture:chercher.html.twig', array( "parties"=>$result

            ) );

        }
        return $this->render('MyAppMyxBundle:Voiture:chercher.html.twig', array( "parties"=>$result

        ));
    }

    public function MatchAction()
    {
        $em=$this->getDoctrine()->getManager();

        /*$ListA = $em->getRepository(Equipe::class)->findEquipe('A');
        $equipeA1=$ListA[0];
        $equipeA2=$ListA[1];
        $ListB = $em->getRepository(Equipe::class)->findEquipe('B');
        $equipeB1=$ListB[0];
        $equipeB2=$ListB[1];
        $ListC = $em->getRepository(Equipe::class)->findEquipe('C');
        $equipeC1=$ListC[0];
        $equipeC2=$ListC[1];
        $ListD = $em->getRepository(Equipe::class)->findEquipe('D');
        $equipeD1=$ListD[0];
        $equipeD2=$ListD[1];
        $ListE = $em->getRepository(Equipe::class)->findEquipe('E');
        $equipeE1=$ListE[0];
        $equipeE2=$ListE[1];
        $ListF = $em->getRepository(Equipe::class)->findEquipe('F');
        $equipeF1=$ListF[0];
        $equipeF2=$ListF[1];
        $ListG = $em->getRepository(Equipe::class)->findEquipe('G');
        $equipeG1=$ListG[0];
        $equipeG2=$ListG[1];
        $ListH = $em->getRepository(Equipe::class)->findEquipe('H');
        $equipeH1=$ListH[0];
        $equipeH2=$ListH[1];
*/
        $partieA1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'A1'));
        $resultatA1=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieA1));


        $partieB1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'B1'));
        $resultatB1=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieB1));


        $partieC1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'C1'));
        $resultatC1=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieC1));


        $partieD1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'D1'));
        $resultatD1=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieD1));


        $partieE1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'E1'));
        $resultatE1=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieE1));


        $partieF1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'F1'));
        $resultatF1=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieF1));


        $partieG1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'G1'));
        $resultatG1=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieG1));



        $partieH1 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'H1'));
        $resultatH1=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieH1));



        $partieA11 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'A11'));
        $resultatA11=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieA11));


        $partieB11 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'B11'));
        $resultatB11=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieB11));



        $partieC11 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'C11'));
        $resultatC11=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieC11));


        $partieD11 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'D11'));
        $resultatD11=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieD11));


        $partieA111 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'A111'));
        $resultatA111=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieA111));


        $partieB111 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'B111'));
        $resultatB111=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieB111));



        $partieA1111 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'A1111'));
        $resultatA1111=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieA1111));


        $partieB1111 = $em->getRepository('MatchMatchBundle:Partie')->findOneBy(array('etiquette' => 'B1111'));
        $resultatB1111=$em->getRepository('MatchMatchBundle:Resultat')->findOneBy(array('idpartie' =>$partieB1111));

        return $this->render('MatchMatchBundle:Partie:arbre.html.twig',array(
          /*  "equipeA1"=>$equipeA1,
            "equipeA2"=>$equipeA2,
            "equipeB1"=>$equipeB1,
            "equipeB2"=>$equipeB2,
            "equipeC1"=>$equipeC1,
            "equipeC2"=>$equipeC2,
            "equipeD1"=>$equipeD1,
            "equipeD2"=>$equipeD2,
            "equipeE1"=>$equipeE1,
            "equipeE2"=>$equipeE2,
            "equipeF1"=>$equipeF1,
            "equipeF2"=>$equipeF2,
            "equipeG1"=>$equipeG1,

            "equipeG2"=>$equipeG2,
            "equipeH1"=>$equipeH1,
            "equipeH2"=>$equipeH2,*/


            "partieA1"=>$resultatA1,
            "partieB1"=>$resultatB1,
            "partieC1"=>$resultatC1,
            "partieD1"=>$resultatD1,
            "partieE1"=>$resultatE1,
            "partieF1"=>$resultatF1,
            "partieG1"=>$resultatG1,
            "partieH1"=>$resultatH1,

            "partieA11"=>$resultatA11,
            "partieB11"=>$resultatB11,
            "partieC11"=>$resultatC11,
            "partieD11"=>$resultatD11,


            "partieA111"=>$resultatA111,
            "partieB111"=>$resultatB111,

            "partieA1111"=>$resultatA1111,
            "partieB1111"=>$resultatB1111,



        ));
    }

    public function insertBetAction($id,Request $request){

        $us = $this->getUser();


        $countt = $this->jouerUnMatch($id);
        if($countt[0]['nb']!=0){
            $this->get('session')->getFlashBag()->add('Impossible'," Vous avez déja jouee ce match !");

            return $this->redirectToRoute('programme',array("count"=>$countt[0]['nb']));
        }

else{
        $em = $this->getDoctrine()->getManager();
            $partie = $em->getRepository('MatchMatchBundle:Partie')->find($id);

            $username = $em->getRepository('MatchMatchBundle:User')->find($us->getId());
            $bet = new Bet();

            $form = $this->createForm(BetType::class, $bet);


            if ($form->handleRequest($request)->isValid()) {
                $valeur = $request->get('optradio');
if($valeur==null){

    return $this->render('MatchMatchBundle:Partie:insertbet.html.twig', array( 'f'=>$form->createView() ,'partie'=>$partie ));

}
    else{
    $this->DiminuerJeton($username);
                $bet->setIdpartie($partie);
                $bet->setUsername($username);
                $bet->setEtat('Traite');
                $bet->setValeur($valeur);

                $notif = new Notifacation();
                $notif->setEtat(0);
                $notif->setIdbet($bet);
                $notif->setUsername($username);

                $em->persist($bet);
                $em->flush();
                $em->persist($notif);
                $em->flush();
                return $this->redirectToRoute('programme');
    }
            }


        return $this->render('MatchMatchBundle:Partie:insertbet.html.twig', array( 'f'=>$form->createView() ,'partie'=>$partie ));
}
    }


      public function jouerUnMatch($id) {
          $us = $this->getUser();
          $em = $this->getDoctrine()->getManager();
          $partie = $em->getRepository('MatchMatchBundle:Partie')->find($id);

          $count = $em->getRepository(Bet::class)->nombreMatchJouer($us,$partie);
          return $count;
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

    public function hayaAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $parties = $em->getRepository('MatchMatchBundle:Equipe')->findAll();

       $match= $em->getRepository(Partie::class)->ProchainMatch();




        if(count($match)>=1)
            $match1=$match[0];

        else   $match1= new Partie();


        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $parties, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 10)/*page number*/

        );

        if($request->getMethod()=="POST") {
            $mark = $em->getRepository('MatchMatchBundle:Equipe')->findBy(array('nomequipe'=>$request->get('serie')));

            $paginator  = $this->get('knp_paginator');
            $result = $paginator->paginate(
                $mark, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                $request->query->getInt('limit', 10)/*page number*/);
            return $this->render('MatchMatchBundle:Partie:list.html.twig',array('equipes'=>$result,'match'=>$match1));
        }


        return $this->render('MatchMatchBundle:Partie:list.html.twig',array('equipes'=>$result,'match'=>$match1));
    }

    public function filtreparnomEquipeAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $match= $em->getRepository(Partie::class)->ProchainMatch();

        if(count($match)>=1)
            $match1=$match[0];

        else   $match1= new Partie();


        $partie= $em->getRepository(Equipe::class)->filtreEquipeParNom();

        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $partie, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 10)/*page number*/

        );


        return $this->render('MatchMatchBundle:Partie:list.html.twig',array('equipes'=>$result,'match'=>$match1));
    }
    public function filtreparcontentEquipeAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $match= $em->getRepository(Partie::class)->ProchainMatch();

        if(count($match)>=1)
            $match1=$match[0];

        else   $match1= new Partie();

        $partie= $em->getRepository(Equipe::class)->filtreEquipeParContenent();

        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $partie, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 10)/*page number*/

        );

        if($request->getMethod()=="POST") {
            $mark = $em->getRepository('MatchMatchBundle:Equipe')->findBy(array('nomequipe'=>$request->get('serie')));

            $paginator  = $this->get('knp_paginator');
            $result = $paginator->paginate(
                $mark, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                $request->query->getInt('limit', 10)/*page number*/);
            return $this->render('MatchMatchBundle:Partie:list.html.twig',array('equipes'=>$result,'match'=>$match1));
        }


        return $this->render('MatchMatchBundle:Partie:list.html.twig',array('equipes'=>$result,'match'=>$match1));}
    public function filtrepargroupeEquipeAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $match= $em->getRepository(Partie::class)->ProchainMatch();

        if(count($match)>=1)
            $match1=$match[0];

        else   $match1= new Partie();

        $partie= $em->getRepository(Equipe::class)->filtreEquipeParGroupe();

        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $partie, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 10)/*page number*/

        );


        if($request->getMethod()=="POST") {
            $mark = $em->getRepository('MatchMatchBundle:Equipe')->findBy(array('nomequipe'=>$request->get('serie')));

            $paginator  = $this->get('knp_paginator');
            $result = $paginator->paginate(
                $mark, /* query NOT result */
                $request->query->getInt('page', 1)/*page number*/,
                $request->query->getInt('limit', 10)/*page number*/);
            return $this->render('MatchMatchBundle:Partie:list.html.twig',array('equipes'=>$result,'match'=>$match1));
        }

        return $this->render('MatchMatchBundle:Partie:list.html.twig',array('equipes'=>$result,'match'=>$match1));}


    public function PartieParEquipeAction($idEquipe)
    {     $em=$this->getDoctrine()->getManager();
        $equipe = $em->getRepository('MatchMatchBundle:Equipe')->find($idEquipe);


        $partie= $em->getRepository(Partie::class)->findPartieEquipe($equipe);


        return $partie;
    }
    public function mesequipesAction($id)
    {
        $us = $this->getUser();
        $em=$this->getDoctrine()->getManager();
        $bets= $em->getRepository('MatchMatchBundle:Bet')->findBy(array('username' =>$us));
        $equipe = $em->getRepository('MatchMatchBundle:Equipe')->find($id);
        $partie=$this->PartieParEquipeAction($id);
        $resultat = $em->getRepository('MatchMatchBundle:Resultat')->findBy(array('idpartie' => $partie));

        return $this->render('MatchMatchBundle:Partie:matchParEquipe.html.twig',array('equipe'=>$equipe,'parties'=>$resultat,'bets'=>$bets));

    }


}
