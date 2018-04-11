<?php

namespace Russia\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('UserBundle:Default:index.html.twig');
    }
    public function adminAction()
    {
        return $this->render('UserBundle:Default:admin.html.twig');
    }
    public function clientAction()
    {
        return $this->render('UserBundle:Default:client.html.twig');
    }
    public function succesAction()
    {
        return $this->render('UserBundle:Default:login_Succes.html.twig');
    }
}
