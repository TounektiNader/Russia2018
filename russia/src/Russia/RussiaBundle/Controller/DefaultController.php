<?php

namespace Russia\RussiaBundle\Controller;

use Match\MatchBundle\Entity\Media;
use Match\MatchBundle\Entity\Notifacation;
use Match\MatchBundle\Form\EquipeType;
use Match\MatchBundle\MatchMatchBundle;
use Match\MatchBundle\Entity\Equipe;
use Match\MatchBundle\Entity\Partie;
use Match\MatchBundle\Entity\Bet;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Swift_Message;

class DefaultController extends Controller
{
    public function indexAction()
    {   $em=$this->getDoctrine()->getManager();
        $us = $this->getUser();


        $mediaT =$em->getRepository(Media::class)->findOneBy(array('natio'=>'Tunisien'));
        $mediaF =$em->getRepository(Media::class)->findOneBy(array('natio'=>'Français'));
        $mediaB =$em->getRepository(Media::class)->findOneBy(array('natio'=>'Belge'));
        $mediaI =$em->getRepository(Media::class)->findOneBy(array('natio'=>'Islandais'));
        $mediaM =$em->getRepository(Media::class)->findOneBy(array('natio'=>'Marocain'));
        $mediaW =$em->getRepository(Media::class)->findOneBy(array('natio'=>'World'));



        $notifgain =$em->getRepository(Notifacation::class)->notifcationGain($us);
        $notifperte =$em->getRepository(Notifacation::class)->notifcationPerte($us);
        $mark =$em->getRepository(Notifacation::class)->notifcation($us);



        $notification = new Notifacation();
        foreach ($mark as $notification)
        {
            $notification->setEtat(1);
            $em->persist($notification);
            $em->flush();

        }


        return $this->render('RussiaRussiaBundle:Default:index.html.twig',array('notifgain'=>$notifgain,'notifperte'=>$notifperte,
            'mediaT'=>$mediaT,
            'mediaI'=>$mediaI,
            'mediaF'=>$mediaF,
            'mediaM'=>$mediaM,
            'mediaW'=>$mediaW,
            'mediaB'=>$mediaB
        ));
    }
    public function ActualiteAction()
    {
        return $this->render('RussiaRussiaBundle:Default:actualite.html.twig');
    }
    public function ContactAction(Request $request)
    {
        if($request->getMethod()=="POST") {
            $us=$this->getUser();
            $subject=$request->get('subject');
            $name=$request->get('name');
            
            $mail=$request->get('email');
            $message2=$request->get('message');
            $message = Swift_Message::newInstance()
                ->setFrom('russia2018young@gmail.com')
                ->setTo('russia2018young@gmail.com')
                ->setSubject($subject)
                ->setBody("Ce mail est de la part de  ".$name." avec le mail suivant  ".$mail."  avec ce messsage  ".$message2.""
                );
            $this->get('mailer')->send($message);

            return $this->render('RussiaRussiaBundle:Default:contact.html.twig');

        }


        return $this->render('RussiaRussiaBundle:Default:contact.html.twig');
    }
    public function LoginAction()
    {
        return $this->render('RussiaRussiaBundle:Default:login.html.twig');
    }
    public function RegistreAction()
    {
        return $this->render('RussiaRussiaBundle:Default:registre.html.twig');
    }
    public function AdminAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();

        $equipes= $em->getRepository(Equipe::class)->findEquipe('A');
        $groupes= $em->getRepository(Partie::class)->selectDQL();
        $equipe = new Equipe();

        $form = $this->createForm(EquipeType::class,$equipe);




        $cadeau=$em->getRepository("RecompenseRecompensBundle:Cadeau")->findAll();
        $countcadeau =   count ($cadeau);


        $user=$em->getRepository("UserBundle:User")->findAll();
        $countuser =   count ( $user);




        $partie=$em->getRepository("RussiaRussiaBundle:Partie")->findAll();
        $counpartie =   count ( $partie);





        $hotel=$em->getRepository("RussiaRussiaBundle:Hotels")->findAll();
        $counhotel =   count ( $hotel);




        $resto=$em->getRepository("RussiaRussiaBundle:Restos")->findAll();
        $counresto =   count ( $resto);




        $cafe=$em->getRepository("RussiaRussiaBundle:Cafes")->findAll();
        $councafe =   count ( $cafe);


        $somme = $counhotel+$councafe+$counresto ;

        $recompense = $em->getRepository("RecompenseRecompensBundle:Cadeau")
            ->findBy(array( "categorie" => "Voiture"));
        $countvoiture=count($recompense);
        $recompense2 = $em->getRepository("RecompenseRecompensBundle:Cadeau")
            ->findBy(array( "categorie" => "Telephone"));
        $counttel=count($recompense2);
        $recompense3 = $em->getRepository("RecompenseRecompensBundle:Cadeau")
            ->findBy(array( "categorie" => "Ticket"));
        $countTicket=count($recompense3);
        $recompense4 = $em->getRepository("RecompenseRecompensBundle:Cadeau")
            ->findBy(array( "categorie" => "Bon_Achat"));
        $countBon_Achat=count($recompense4);
        $users=$em->getRepository('UserBundle:User')
            ->findBy(array(), array('jeton' => 'desc'));

        $user1=$users[0];
        $user2=$users[1];
        $user3=$users[2];
        $user4=$users[3];



        $bettraite = $em->getRepository("MatchMatchBundle:Bet")->findBy(array( "etat" => "Traite"));
        $counttraite=count($bettraite);
        $betgain = $em->getRepository("MatchMatchBundle:Bet")->findBy(array( "etat" => "Gain"));
        $countgain=count($betgain);
        $betperte = $em->getRepository("MatchMatchBundle:Bet")->findBy(array( "etat" => "Perte"));
        $countperte=count($betperte);

        /**********************************************************************************/


        $equipesEurope=$em->getRepository("MatchMatchBundle:Equipe")->findby(array('continent'=>'Europe'));
        $equipesAsie=$em->getRepository("MatchMatchBundle:Equipe")->findby(array('continent'=>'Asie'));
        $equipesAmeriqueSud=$em->getRepository("MatchMatchBundle:Equipe")->findby(array('continent'=>'Amérique du Sud'));
        $equipesAfrique=$em->getRepository("MatchMatchBundle:Equipe")->findby(array('continent'=>'Afrique'));
        $equipesAmeriqueNord=$em->getRepository("MatchMatchBundle:Equipe")->findby(array('continent'=>'Amérique du Nord'));






          /********************************************************************/
        $cadeauVoiture=$em->getRepository("RecompenseRecompensBundle:Cadeau")
            ->findBy(array( "categorie"=>"Voiture"));
        $recompense5 = $em->getRepository("RecompenseRecompensBundle:Recompense")
            ->findBy(array( "idcadeau"=>$cadeauVoiture));
        $countRecVoiture=count($recompense5);

        $cadeauBon=$em->getRepository("RecompenseRecompensBundle:Cadeau")
            ->findBy(array( "categorie"=>"Bon_Achat"));
        $recompense6 = $em->getRepository("RecompenseRecompensBundle:Recompense")
            ->findBy(array( "idcadeau"=>$cadeauBon));
        $countRecBon=count($recompense6);

        $cadeauTicket=$em->getRepository("RecompenseRecompensBundle:Cadeau")
            ->findBy(array( "categorie"=>"Ticket"));
        $recompense7 = $em->getRepository("RecompenseRecompensBundle:Recompense")
            ->findBy(array( "idcadeau"=>$cadeauTicket));
        $countRecTicket=count($recompense7);

        $cadeauTelephone=$em->getRepository("RecompenseRecompensBundle:Cadeau")
            ->findBy(array( "categorie"=>"Telephone"));
        $recompense8 = $em->getRepository("RecompenseRecompensBundle:Recompense")
            ->findBy(array( "idcadeau"=>$cadeauTelephone));
        $countRecTelephone=count($recompense8);
        $totals=$recompense8 = $em->getRepository("RecompenseRecompensBundle:Recompense")
            ->findAll();
        $countTotal=count($totals);


        /**********************************************************************/

        $bets= $em->getRepository('MatchMatchBundle:Bet')->findAll();

        $betsalll =$em->getRepository(Bet::class)->DistancBets();


        $nombreJetonPerte=0;
        $nombreJetonGain=0;
        $nombretotal=0;
        foreach ($bets as $bet) {
            if ($bet->getEtat() == 'Perte') {
                $nombreJetonPerte = ($nombreJetonPerte + 1);
            }
            if ($bet->getEtat() == 'Gain') {
                $nombreJetonGain = ($nombreJetonGain + 2);
            }

            $nombretotal= $nombretotal+$bet->getUsername()->getJeton();

        }


        $tabjetongagne = array();
        $tabjetonperdu = array();

        $betsperdu =$em->getRepository(Bet::class)->countbetPerduBets();
        $betsgagne =$em->getRepository(Bet::class)->countbetgagneBets();


        $l=0;
        foreach ($betsperdu as $bet) {



            $tabjetonperdu[$l] = $bet;


            $tabjetongagne[$l] = $bet;

            $l++;
        }


        $i=0;
        foreach ($betsgagne as $bet) {






            $tabjetongagne[$i] = $bet;

            $i++;
        }


         /*********************************************************************/

        $contttt= $em->getRepository(Equipe::class)->continent();

      $region=$em->getRepository('MatchMatchBundle:Equipe')->findAll();
        /*********************************************************************/

        if($form->handleRequest($request)->isValid())
        {

            $groupe=$request->get('CGroup');


            $equip= $em->getRepository(Equipe::class)->findEquipe($groupe);

            return $this->render('RussiaRussiaBundle:Default:indexadmin.html.twig',array(
                'equipes'=>$equip,
                'form'=>$form->createView(),
                'groupes'=>$groupes,
                  'cntcadeau'=>$countcadeau,
            'cntuser'=>$countuser,
            'countpartie'=>$counpartie,
            'somme'=>$somme,
            'voiture'=>$countvoiture,
            'tel'=>$counttel,
            'Ticket'=>$countTicket,
            'Bon_Achat'=>$countBon_Achat,
            'user1'=>$user1,
            'user2'=>$user2,
            'user3'=>$user3,
            'user4'=>$user4,
                'counttraite'=>$counttraite,
                'countgain'=>$countgain,
                'countperte'=>$countperte,
                'nombrejetonperte'=>$nombreJetonPerte,
                'nombrejetongain'=>$nombreJetonGain,
                'nombretotal'=>$nombretotal,
                 'bets'=>$bets,
                'tabjetonperdu'=>$tabjetonperdu,
                'tabjetongagne'=>$tabjetongagne,
                'betsall'=> $betsalll,
                'region'=>$region,
                'contient'=>$contttt,
                'Voiture'=>$countRecVoiture,
                'Bon'=>$countRecBon,
                'ticket'=>$countRecTicket,
                'Tel'=>$countRecTelephone,
                'Total'=>$countTotal,
                'equipesEurope'=>$equipesEurope,
                'equipesAsie'=>$equipesAsie,
                'equipesAmeriqueSud'=>$equipesAmeriqueSud,
                'equipesAfrique'=>$equipesAfrique,
                'equipesAmeriqueNord'=>$equipesAmeriqueNord






            ));
        }








        return $this->render('RussiaRussiaBundle:Default:indexadmin.html.twig',array(


            'cntcadeau'=>$countcadeau,
            'cntuser'=>$countuser,
            'countpartie'=>$counpartie,
            'somme'=>$somme,
            'voiture'=>$countvoiture,
            'tel'=>$counttel,
            'Ticket'=>$countTicket,
            'Bon_Achat'=>$countBon_Achat,
            'user1'=>$user1,
            'user2'=>$user2,
            'user3'=>$user3,
            'user4'=>$user4,
            'equipes'=>$equipes,
            'form'=>$form->createView(),
            'groupes'=>$groupes,
            'counttraite'=>$counttraite,
            'countgain'=>$countgain,
            'countperte'=>$countperte,
            'nombrejetonperte'=>$nombreJetonPerte,
            'nombrejetongain'=>$nombreJetonGain,
            'nombretotal'=>$nombretotal,
            'bets'=>$bets,
            'tabjetonperdu'=>$tabjetonperdu,
            'tabjetongagne'=>$tabjetongagne,
            'betsall'=> $betsalll,
            'region'=>$region,
            'contient'=>$contttt,
            'Voiture'=>$countRecVoiture,
            'Bon'=>$countRecBon,
            'ticket'=>$countRecTicket,
            'Tel'=>$countRecTelephone,
            'Total'=>$countTotal,
            'equipesEurope'=>$equipesEurope,
            'equipesAsie'=>$equipesAsie,
            'equipesAmeriqueSud'=>$equipesAmeriqueSud,
            'equipesAfrique'=>$equipesAfrique,
            'equipesAmeriqueNord'=>$equipesAmeriqueNord


        ));
    }
    public function mailAction()
    {



    }





    public function statutBetAction()
    {



    }


}
