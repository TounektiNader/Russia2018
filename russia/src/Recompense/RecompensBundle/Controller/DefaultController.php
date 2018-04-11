<?php

namespace Recompense\RecompensBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('RecompenseRecompensBundle:Default:index.html.twig');
    }
}
