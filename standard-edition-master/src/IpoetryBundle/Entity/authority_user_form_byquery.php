<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManager;
/**
 * Description of authority_user_form_byquery
 *
 * @author denvkr
 * @ORM\NativeQuery
 */
class authority_user_form_byquery {
    //put your code here
    public function __construct(){
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('\Entity\authority_user_form', 'q');
        $rsm->addFieldResult('q', 'cnt_usr', 'cnt_usr');
        $entityManager=new EntityManager();
        $query = $this->_em->createNativeQuery('SELECT count(id) as cnt_usr FROM userinfo WHERE name = ? and password = ?', $rsm);
        $query->setParameter(1, $_REQUEST['name']);
        $query->setParameter(1, $_REQUEST['password']);
        $userinfo = $query->getResult();
        return $userinfo->getcnt_usr;
    }
}
