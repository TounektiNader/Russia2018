<?php

namespace Match\MatchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
    {
        return $this->render('MatchMatchBundle:Default:son.html.twig');
    }
}
