<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IpoetryBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/**
 * Description of IndexController
 *
 * @author d.krasavin
 */
class IndexController extends Controller
{

    public function indexAction(){
         return $this->render('IpoetryBundle:Default:index.html.twig');
    }
}
