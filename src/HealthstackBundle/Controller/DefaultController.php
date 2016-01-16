<?php

namespace HealthstackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HealthstackBundle:Default:index.html.twig');
    }
}
