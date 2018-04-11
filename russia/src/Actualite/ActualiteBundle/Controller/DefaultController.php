<?php

namespace Actualite\ActualiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ActualiteActualiteBundle:Default:index.html.twig');
    }
}
