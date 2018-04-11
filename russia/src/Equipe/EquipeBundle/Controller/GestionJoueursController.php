<?php

namespace Equipe\EquipeBundle\Controller;



use Equipe\EquipeBundle\Entity\Equipe;
use Equipe\EquipeBundle\Entity\Joueurs;
use Equipe\EquipeBundle\Form\JoueursType;


use Spreadsheet_Excel_Reader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;



class GestionJoueursController extends Controller
{
   /* public function AjouterJoueursAction(Request $request)
    {
        $joueur = new Joueurs();

        $form = $this->createFormBuilder($joueur)
            ->add('nomjoueur')
            ->add('prenomjoueur')
            ->add('postion')
            ->add('idequipe', EntityType::class, array(
                'class' => 'Equipe\EquipeBundle\Entity\Equipe',
                'choice_label' => 'nomequipe',
                'multiple' => false,
                'data_class'=>null
            ))
            ->add('Ajouter', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($joueur);
            $em->flush();

            return $this->redirectToRoute('_afficher_equipe');

        }
        return $this->render('EquipeEquipeBundle:GestionJoueurs:ajouter_joueurs.html.twig', array(
            'form' => $form->createView()
        ));
    }*/

    public function AjouterJoueursAction(Request $request)
    {
        $joueurs=new Joueurs();
    $form=$this->createForm(JoueursType::class,$joueurs);
    $form->handleRequest($request);
    if($form->isValid())
    {
    $eq=$this->getDoctrine();
    $eq=$eq->getManager();
    $eq->persist($joueurs);
    $eq->flush();
    return $this->redirectToRoute('_afficher_joueurs');

    }
        return $this->render('EquipeEquipeBundle:GestionJoueurs:ajouter_joueurs.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function AfficherJoueursAction()
    {
        $js = $this->getDoctrine();

        $repository = $js->getRepository(Joueurs::class);

        $joueurs = $repository->findAll();

        return $this->render('EquipeEquipeBundle:GestionJoueurs:afficher_joueurs.html.twig', array(
            'joueurs' => $joueurs
        ));
    }

    public function SupprimerJoueurAction($idjoueur)
    {
        $js = $this->getDoctrine()->getManager();
        $joueur = $js->getRepository(Joueurs::class)->find($idjoueur);
        $js->remove($joueur);
        $js->flush();
        return $this->redirectToRoute('_afficher_joueurs');
    }



    public function ModifierJoueurAction(Request $request, $idjoueur)
    {

        $eq = $this->getDoctrine()->getManager();
        $joueurs = $eq->getRepository("EquipeEquipeBundle:Joueurs")->find($idjoueur);
        $form = $this->createForm(JoueursType::class, $joueurs);
        $form->handleRequest($request);
        if ($form->isValid()) {

            $eq->persist($joueurs);
            $eq->flush();


            return $this->redirectToRoute('_afficher_joueurs');
        }
        return $this->render('EquipeEquipeBundle:GestionJoueurs:modifier_joueur.html.twig', array(
            'form' => $form->createView()
        ));
    }


    public function AfficherJoueursClientAction($idequipe)
    {
        $user = $this->getUser();
        $js = $this->getDoctrine()->getManager();
        $joueur = $js->getRepository("EquipeEquipeBundle:Joueurs")->findByidequipe($idequipe);
        return $this->render('EquipeEquipeBundle:GestionJoueurs:afficher_joueurs_client.html.twig', array('joueur' => $joueur, 'user' => $user));
    }





}

