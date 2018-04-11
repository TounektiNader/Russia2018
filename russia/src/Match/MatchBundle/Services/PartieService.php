<?php
/**
 * Created by PhpStorm.
 * User: Nader
 * Date: 21/03/2018
 * Time: 23:21
 */

namespace Match\MatchBundle\Services;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Match\MatchBundle\Entity\Partie;


class PartieService  extends Controller
{


    public function updateEtatPartie($idPartie)
     {

     $em = $this->getDoctrine()->getManager();
     $partie = $em->getRepository('MatchMatchBundle:Partie')->find($idPartie);

     $partie.setEtatmatch('Jouee');

    $em->remove($partie);
    $em->flush();

   }




}