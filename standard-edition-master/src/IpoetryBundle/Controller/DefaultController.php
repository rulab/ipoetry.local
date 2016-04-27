<?php

namespace IpoetryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IpoetryBundle:Default:index.html.twig');
    }
}
