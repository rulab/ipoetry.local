<?php 

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * @ORM\Entity
 * Description of authority_user_form
 * @author denvkr
 */
class authority_user_form {
    /**
     * @ORM\cnt_usr
     * @ORM\Column(type="integer", length=3)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $cnt_usr;
    
    public function Getcnt_usr(){
        return $this->cnt_usr; 
    }

    public function Setcnt_usr($cnt_user){
        return $this->cnt_usr=$cnt_user; 
    }
    
}
?>