<?php

namespace Equipe\EquipeBundle\Controller;

use Equipe\EquipeBundle\Entity\Equipe;
use Equipe\EquipeBundle\Form\EquipeType;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;




class GestionEquipeController extends Controller
{



    public function AjouterEquipeAction(Request $request)
    {
        $equipe=new Equipe();
        $form=$this->createForm(EquipeType::class,$equipe);
        $form->handleRequest($request);
        if($form->isValid())
        {
            $eq=$this->getDoctrine();
            $eq=$eq->getManager();
            $eq->persist($equipe);
            $eq->flush();
            return $this->redirectToRoute('_afficher_equipe');

        }
        return $this->render('EquipeEquipeBundle:GestionEquipe:ajouter_equipe.html.twig', array(
            'form'=>$form->createView()
        ));
    }






    public function AfficherEquipeAction()
    {
        $eq=$this->getDoctrine();

        $repository=$eq->getRepository(Equipe::class);

        $equipes=$repository->findAll();

        return $this->render('EquipeEquipeBundle:GestionEquipe:afficher_equipe.html.twig', array(
            'equipes'=>$equipes
    ));
    }

    public function ModifierEquipeAction(Request $request , $idequipe)
    {


                $eq = $this->getDoctrine()->getManager();

                $equipe = $eq->getRepository("EquipeEquipeBundle:Equipe")->find($idequipe);
                $form=$this->createForm(EquipeType::class,$equipe);
                $form->handleRequest($request);

                if($form->isValid()){
                    $eq=$this->getDoctrine()->getManager();
                    $eq->persist($equipe);
                    $eq->flush();
                return $this->redirectToRoute('_afficher_equipe');


            }

        return $this->render('EquipeEquipeBundle:GestionEquipe:modifier_equipe.html.twig', array('form'=>$form->createView()));
    }

    public function SupprimerEquipeAction($idequipe)
    {
        $eq=$this->getDoctrine()->getManager();
        $equipe=$eq->getRepository(Equipe::class)->find($idequipe);
        $eq->remove($equipe);
        $eq->flush();
        return $this->redirectToRoute('_afficher_equipe');

    }

    public function rechercheEquipeAJAXDQLAction(Request $request)
    {
        $eq = $this->getDoctrine()->getManager();
        $equipe=$eq->getRepository(Equipe::class)->findAll();

        if($request->isXmlHttpRequest())
        {
            $serializer=new Serializer(array(new ObjectNormalizer()));

            $nomEquipe=$request->request->get('search');
            $equipe=$eq->getRepository(Equipe::class)->findSerieDQL($nomEquipe);
            $data=$serializer->normalize($equipe);
            return new JsonResponse($data);
        }
        return $this->render('EquipeEquipeBundle:GestionEquipe:afficher_equipe.html.twig',['equipe'=>$equipe]);
    }


    public function RechercherAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $equipe = $this->getDoctrine()->getRepository(mode::class)->findByEquipe($request->get('idequipe'));
            return $this->render('EquipeEquipeBundle:GestionEquipe:afficher_Equipe_Client.html.twig', array("equipes" => $equipe));

        }
        $eq=$this->getDoctrine()->getManager();
        $equipe=$eq->getRepository("EquipeEquipeBundle:Equipe")->findAll();
        return $this->render('EquipeEquipeBundle:GestionEquipe:afficher_Equipe_Client.html.twig',array('equipes'=>$equipe));

    }

    public function AfficherEquipeClientAction()
    {
        $user=$this->getUser();
        $eq=$this->getDoctrine()->getManager();
        $equipe=$eq->getRepository("EquipeEquipeBundle:Equipe")->findAll();
        return $this->render('EquipeEquipeBundle:GestionEquipe:afficher_Equipe_Client.html.twig',array('equipes'=>$equipe,'user'=>$user));

    }


    public function PieChartAction($idequipe)
    {
        $equipe = new Equipe();
        $user=$this->getUser();

        $ob = new Highchart();
        $ob->chart->renderTo('piechart');
        $ob->title->text('Statistics of the team');
        $ob->plotOptions->pie(array(
            'allowPointSelect'  => true,
            'cursor'    => 'pointer',
            'dataLabels'    => array('enabled' => false),
            'showInLegend'  => true
        ));


        $em = $this->getDoctrine()->getManager();
        $equi = $em->getRepository("EquipeEquipeBundle:Equipe")->find($idequipe);
        $Chart = $em->getRepository("EquipeEquipeBundle:Equipe")->findByidequipe($idequipe);

        if($Chart != null){
            $matchjouee= 0;
            $matchperdu= 0;
            $matchgagne= 0;
            $matchnull=0;
            $butencaisse=0;
            $butmarque= 0;
            $moyennematchgagne=0;
            $moyennematchperdu=0;
            $moyennematchnull=0;
            $moyennebutmarque=0;

            foreach ($Chart as $Charts)
            {
                $matchjouee = $Charts->getMatchjouee();
                $matchperdu = $Charts->getMatchperdu();
                $matchgagne = $Charts->getMatchgagne();
                $matchnull = $Charts->getMatchnull();
                $butencaisse = $Charts->getButencaisse();
                $butmarque = $Charts->getButmarque();

                $moyennematchgagne= $matchgagne*100/$matchjouee;
                $moyennematchperdu=$matchperdu*100/$matchjouee;
                $moyennematchnull=$matchnull*100/$matchjouee;
                $moyennebutmarque=$butmarque*100/$butencaisse;

            }

            $Chart = array(
                array('Moyenne de Match gagne',$moyennematchgagne ),
                array('Moyenne de Match perdu',$moyennematchperdu ),
                array('Moyenne de Match null', $moyennematchnull),
                array('Moyenne de but marque', $moyennebutmarque),
//                array('But Encaisse',$butencaisse ),
//                array('But marque',$butmarque ),
            );
            $ob->series(array(array('type' => 'pie','name' => 'Browser share', 'data' => $Chart)));

            return $this->render('EquipeEquipeBundle:GestionEquipe:Statistique.html.twig', array(
                'chart' => $ob,'equipe'=>$equipe,'user'=>$user,'equipe'=>$equi
            ));
        }
    }

/////////////////////////////////////////////////////////////////

    public function AfficherEquipeClient1Action()
    {
        $user=$this->getUser();
        $eq=$this->getDoctrine()->getManager();
        $equipe=$eq->getRepository("EquipeEquipeBundle:Equipe")->findAll();
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($equipe);
        return new JsonResponse($formatted);
        //return $this->render('EquipeEquipeBundle:GestionEquipe:afficher_Equipe_Client.html.twig',array('equipes'=>$equipe,'user'=>$user));

    }

}
