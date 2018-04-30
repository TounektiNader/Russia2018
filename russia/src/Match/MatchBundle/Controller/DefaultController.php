<?php

namespace Match\MatchBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Match\MatchBundle\Entity\Bet;
use Match\MatchBundle\Entity\Equipe;
use Match\MatchBundle\Entity\Partie;
use Match\MatchBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MatchMatchBundle:Default:index.html.twig');
    }


    public function usersAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository('MatchMatchBundle:User')->findAll();

        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $user, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 5)/*page number*/

        );

        return $this->render('MatchMatchBundle:Default:users.html.twig', array("users"=>$result



        ));
    }



    public function promotesAction($id,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository('MatchMatchBundle:User')->find($id);



        $userManager = $this->get('fos_user.user_manager');
        $user->addRole('ROLE_ADMIN');
        $userManager->updateUser($user);


        $users = $em->getRepository('MatchMatchBundle:User')->findAll();



        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $users, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            $request->query->getInt('limit', 5)/*page number*/

        );

        return $this->render('MatchMatchBundle:Default:users.html.twig', array("users"=>$result



        ));
    }

    public function accAction()
    {$tasks = $this->getDoctrine()->getManager()
        ->getRepository('MatchMatchBundle:Bet')
        ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
        //return $this->render('MatchMatchBundle:Default:son.html.twig');
    }
    public function differentAction($id)
    {
        $tasks = $this->getDoctrine()->getManager()
            ->getRepository('MatchMatchBundle:Bet')
            ->find($id);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
        //return $this->render('MatchMatchBundl
    }


    public function newBetAction($valeur,$idUser,$idPartie)
    {
        $em = $this->getDoctrine()->getManager();
        $partie = new Partie();
        $user = new User();
        $bet = new Bet();

        $partie = $em->getRepository('MatchMatchBundle:Partie')->find($idPartie);
        $user = $em->getRepository('MatchMatchBundle:User')->find($idUser);

        $bet->setUsername($user);
        $bet->setEtat("Traite");
        $bet->setValeur($valeur);
        $bet->setIdpartie($partie);


        $em->persist($bet);
        $em->flush();

        $user->setJeton($user->getJeton()-1);
        $em->persist($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($bet);
        return new JsonResponse($formatted);

    }

    public function MesBetAction($idUser)
    {
        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository('MatchMatchBundle:User')->find($idUser);


        $bets= $em->getRepository(Bet::class)->mesBets($user);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($bets);
        return new JsonResponse($formatted);

    }


    public function EquipeGaAction($idPartie)
    {


        $equipeGagner = new Equipe();

        $equipe = new Equipe();
        $equipe->setIdequipe(0);

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




        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($equipeGagner);
        return new JsonResponse($formatted);

    }


    public function registerJAction($nom,$prenom,$username,$usernameCano,$mail,$mailCano,$pass,$conf,$num,$natio)
    {

        $user = new User();
        $user->setEnabled(false);
        $user->setNom($nom);
        $user->setPrenom($prenom);

        $user->setNum($num);
        $user->setNationalite($natio);
        $user->setUsername($username);
        $user->setUsernameCanonical($usernameCano);
        $user->setEmail($mail);
        $user->setEmailCanonical($mailCano);
        $options = [
            'cost' => 13,
        ];
        $passwordhashed = password_hash($pass, PASSWORD_BCRYPT, $options);

        $user->setPassword($passwordhashed);
        $user->setJeton(20);
        $user->setConfirmationToken($conf);


        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }


    public function VariableRandAction()
    {
        $equipe = new Equipe();
        $equipe->setIdequipe(1);

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring = $randstring.$characters[rand(0, strlen($characters))];
        }
        $equipe->setGroupe($randstring);

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($equipe);
        return new JsonResponse($formatted);

    }

    public function validerUserAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('MatchMatchBundle:User')->find($id);
        $user->setEnabled(true);


        $em->persist($user);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($user);
        return new JsonResponse($formatted);
    }

}
