<?php

namespace Match\MatchBundle\Controller;

use Match\MatchBundle\Entity\Bet;
use Match\MatchBundle\Entity\Partie;
use Match\MatchBundle\Form\EquipeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Match\MatchBundle\sms\SmsGateway;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Match\MatchBundle\Entity\Equipe;

class BetController extends Controller
{

    public function mesBetsAction()
    {

        //rani badeltha w lazem njarebha


        $us = $this->getUser();

        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository('MatchMatchBundle:User')->find($us->getId());


        $bets= $em->getRepository(Bet::class)->mesBets($user);

        $resultats = $em->getRepository('MatchMatchBundle:Resultat')->findAll();
        return $this->render('MatchMatchBundle:Bet:mes_bets.html.twig', array('bets'=>$bets,'resultats'=>$resultats
        ));
    }


    public function envoismmsAction()
    {
        $us = $this->getUser();
        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository('MatchMatchBundle:User')->find($us->getId());


        $bets= $em->getRepository(Bet::class)->mesBets($user);

        $resultats = $em->getRepository('MatchMatchBundle:Resultat')->findAll();
        $smsGateway = new SmsGateway('nader.tounekti@esprit.tn', 'mahamahamaha');

        $deviceID = 84004;
        $number ='+21650649211';
        $message = ' Bonsoir Tt le monde';

        $result = $smsGateway->sendMessageToNumber($number , $message, $deviceID);
        return $this->render('MatchMatchBundle:Bet:mes_bets.html.twig', array('bets'=>$bets,'resultats'=>$resultats)
        );
    }

    public function forumindexAction()
    {
        $us = $this->getUser();

        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository('MatchMatchBundle:User')->find($us->getId());


        $bets= $em->getRepository(Bet::class)->mesBets($user);

        $resultats = $em->getRepository('MatchMatchBundle:Resultat')->findAll();



        $snappy = $this->get('knp_snappy.pdf');
        $html = $this->renderView('MatchMatchBundle:Bet:pdf.html.twig', array('bets'=>$bets,'resultats'=>$resultats,'user'=>$user)
        );



        $filename = 'myFirstSnappyPDF';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );


        return $this->render('MatchMatchBundle:Bet:forumindex.html.twig'
        );
    }

    public function reportAction(Request $request)
    {


        $em = $this->getDoctrine()->getManager();
        $equipes= $em->getRepository(Equipe::class)->findEquipe('A');
        $groupes= $em->getRepository(Partie::class)->selectDQL();
        $equipe = new Equipe();

        $form = $this->createForm(EquipeType::class,$equipe);


        if($form->handleRequest($request)->isValid())
        {

            $groupe=$request->get('CGroup');


            $equip= $em->getRepository(Equipe::class)->findEquipe($groupe);

            return $this->render('MatchMatchBundle:Bet:report.html.twig',array('equipes'=>$equip,'form'=>$form->createView(),'groupes'=>$groupes));
        }

        return $this->render('MatchMatchBundle:Bet:report.html.twig',array('equipes'=>$equipes,'form'=>$form->createView(),'groupes'=>$groupes));



    }
}
