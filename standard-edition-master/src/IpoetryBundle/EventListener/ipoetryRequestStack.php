<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IpoetryBundle\EventListener;
use \Symfony\Component\HttpFoundation\RequestStack;
/**
 * Description of ipoetryRequestStack
 *
 * @author denvkr
 */
class ipoetryRequestStack extends RequestStack {
public function getCurrentRequest(){
    \Symfony\Component\VarDumper\VarDumper::dump(array(parent::getCurrentRequest()));
}
}