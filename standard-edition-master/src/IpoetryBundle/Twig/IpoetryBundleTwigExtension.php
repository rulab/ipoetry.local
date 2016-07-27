<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IpoetryBundle\Twig;
/**
 * Description of IpoetryBundleTwigExtension
 *
 * @author d.krasavin
 */
class IpoetryBundleTwigExtension extends \Twig_Extension
 {
    public function getFunctions()
    {
        return array(
            'geturlpart'=>new \Twig_Function_Function(array($this,'get_urlpart')),
        );
    }
    //$url-раздел для выборки части
    //$direction- направление поиска
    public function get_urlpart($url,$direction=-1)
    {
        if ($direction<0){
            $fp=strrpos ( $url , '_' , 0 );
            //$fp2=strrpos ( $url , '/' , ($fp+1) );
        }
        return substr ( $url ,-($fp-2)  );
    }
    public function getName(){
        return 'IpoetryBundle_Twig_Extension';
    }       
}
