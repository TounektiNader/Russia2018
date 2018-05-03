<?php

namespace Equipe\EquipeBundle\Controller;

use Equipe\EquipeBundle\Entity\Favoris;
use Equipe\EquipeBundle\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class GestionFavorisController extends Controller
{
    public function MakeFavoriteAction($id,$idEquipe)
    {
       // $user = $this->getUser();
        $em=$this->getDoctrine()->getManager();
        $Equipe=$em->getRepository("EquipeEquipeBundle:Equipe")->find($idEquipe);
        $User=$em->getRepository("UserBundle:User")->find($id);

       // $Joueur=$em->getRepository("EquipeEquipeBundle:Joueurs")->findById($idJoueur);
        $favoris= new Favoris();

            $favoris->setIduser($User);



            $favoris->setIdequipe($Equipe);


            $em->persist($favoris);
            $em->flush();


        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($favoris);
        return new JsonResponse($formatted);

    }

    public function AffichageFavori1Action()
    {

        $em=$this->getDoctrine()->getManager();
        $Favorisss= $em->getRepository("EquipeEquipeBundle:Favoris")->nombreFavoris();


        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize(array($Favorisss[0][0]));
        return new JsonResponse($data);
    }
    public function AffichageFavori2Action()
    {

        $em=$this->getDoctrine()->getManager();
        $Favorisss= $em->getRepository(Favoris::class)->nombreFavoris();


        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize(array($Favorisss[1][0]));
        return new JsonResponse($data);
    }
    public function AffichageFavori3Action()
    {

        $em=$this->getDoctrine()->getManager();
        $Favorisss= $em->getRepository(Favoris::class)->nombreFavoris();


        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize(array($Favorisss[2][0]));
        return new JsonResponse($data);
    }
    public function AffichageFavori4Action()
    {

        $em=$this->getDoctrine()->getManager();
        $Favorisss= $em->getRepository(Favoris::class)->nombreFavoris();


        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize(array($Favorisss[3][0]));
        return new JsonResponse($data);
    }
    public function AffichageFavori5Action()
    {

        $em=$this->getDoctrine()->getManager();
        $Favorisss= $em->getRepository(Favoris::class)->nombreFavoris();


        $encoder = new JsonEncoder();
        $normalizer = new ObjectNormalizer();
        $serializer = new Serializer(array($normalizer), array($encoder));
        $data = $serializer->normalize(array($Favorisss[4][0]));
        return new JsonResponse($data);
    }

}
