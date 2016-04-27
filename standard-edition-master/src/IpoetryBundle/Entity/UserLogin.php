<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace IpoetryBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Description of UserLogin
 *
 * @author denvkr
 */
class UserLogin {
    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      maxMessage = "Your login cannot be longer than {{ limit }} characters",
     *      minMessage = "Your login must be at least {{ limit }} characters long"
     * )
     */
    private $login;
    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Your password must be at least {{ limit }} characters long",
     *      maxMessage = "Your password cannot be longer than {{ limit }} characters"
     * )
     */
    private $password;

    private $save;

    function SetLogin($login){
       $this->login=$login;
    }
    function GetLogin(){
        return $this->login;
    }
    function SetPassword($password){
        $this->password=$password;
    }
    function GetPassword(){
        return $this->password;
    }
    function SetSave($save){
        $this->save=$save;
    }
    function GetSave(){
        return $this->save;
    }
}
