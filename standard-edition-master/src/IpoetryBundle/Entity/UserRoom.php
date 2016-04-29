<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace IpoetryBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * Description of UserRoom
 *
 * @author d.krasavin
 * маппер личного кабинета пользователя.
* @ORM\Entity
* @ORM\Table(name="ipoetry_user")
*/
class UserRoom {
    /**
    * @ORM\Column(type="integer")
    * @ORM\user_id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $user_id;

    /**
    * @ORM\Column(type="string", length=50)
    * @ORM\user_name
    */
    private $user_name;

    /**
    * @ORM\Column(type="string", length=50)
    * @ORM\user_lastname
    */
    private $user_lastname;

    /**
    * @ORM\Column(type="string", length=20)
    * @ORM\user_password
    */
    private $user_password;
    
    /**
    * @ORM\Column(type="string", length=255)
    * @ORM\user_email
    */
    private $user_email;

    /**
    * @ORM\Column(type="string", length=11)
    * @ORM\user_phone
    */
    private $user_phone;

    /**
    * @ORM\Column(type="integer")
    * @ORM\user_photo_id
    */
    private $user_photo_id;
 
    public function GetUserName(){
        return $this->user_name;
    }

    public function SetUserName($username){
        $this->user_name=$username;
    }

    public function GetUserLastName(){
        return $this->user_lastname;
    }

    public function SetUserLastName($userlastname){
        $this->user_lastname=$userlastname;
    }

    public function GetUserPassword(){
        return $this->user_password;
    }
    
    public function SetUserPassword($userpassword){
        $this->user_password=$userpassword;
    }

    public function GetUserEmail(){
        return $this->user_email;
    }

    public function SetUserEmail($useremail){
        $this->user_email=$useremail;
    }

    public function GetUserPhone(){
        return $this->user_phone;
    }

    public function SetUserPhone($userphone){
        $this->user_phone=$userphone;
    }

}