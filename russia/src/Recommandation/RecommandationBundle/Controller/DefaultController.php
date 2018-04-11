<?php

namespace Recommandation\RecommandationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('RecommandationRecommandationBundle:Default:index.html.twig');
    }
}
