<?php

namespace Equipe\EquipeBundle\Controller;



use Equipe\EquipeBundle\Entity\Equipe;
use Equipe\EquipeBundle\Entity\Joueurs;
use Equipe\EquipeBundle\Form\JoueursType;



use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Akeneo\Component\SpreadsheetParser\SpreadsheetParser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;



class GestionJoueursController extends Controller
{




    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */

    public function AjouterJoueursAction(Request $request)
    {
        $joueurs = new Joueurs();
        $form = $this->createForm(JoueursType::class, $joueurs);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $eq = $this->getDoctrine();
            $eq = $eq->getManager();
            $eq->persist($joueurs);
            $eq->flush();
            return $this->redirectToRoute('_afficher_joueurs');

        }

        if ($request->isMethod('post')) {
            $eq = $this->getDoctrine()->getManager();
            $xx=$request->get('worksheet');
            $workbook = SpreadsheetParser::open('C:\Users\Nader\Documents\GitHub\ValidationWeb\russia\web\public\File\testing.xlsx');


            $myWorksheetIndex = $workbook->getWorksheetIndex('myworksheet');

            foreach ($workbook->createRowIterator($myWorksheetIndex) as $rowIndex => $values) {
                dump($rowIndex, $values);
                $joueur = new Joueurs();
                $joueur->setPrenomjoueur($rowIndex . $values[0]);
                $joueur->setNomjoueur($values[0]);
                $joueur->setPostion($values[0]);

                $Equipe = $eq->getRepository("EquipeEquipeBundle:Equipe")->find($values[3]);

                $joueur->setIdequipe($Equipe);
                $em = $this->getDoctrine()->getManager();
                $em->persist($joueur);
                $em->flush();

            }
        }

        return $this->render('EquipeEquipeBundle:GestionJoueurs:_ajouttttt_joueur.html.twig', array(
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
////////////////////////////////////////////////////
    public function AfficherJoueursClient1Action($idequipe)
    {
        $user = $this->getUser();
        $js = $this->getDoctrine()->getManager();
        $joueur = $js->getRepository("EquipeEquipeBundle:Joueurs")->findByidequipe($idequipe);
        $serializer= new Serializer([new ObjectNormalizer()]);
        $formatted= $serializer->normalize($joueur);
        return new JsonResponse($formatted);
        //return $this->render('EquipeEquipeBundle:GestionJoueurs:afficher_joueurs_client.html.twig', array('joueur' => $joueur, 'user' => $user));
    }




}

