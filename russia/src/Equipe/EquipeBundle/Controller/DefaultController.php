<?php

namespace Equipe\EquipeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EquipeEquipeBundle:Default:index.html.twig');
    }
}
