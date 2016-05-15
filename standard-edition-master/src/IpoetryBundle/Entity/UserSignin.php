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
class UserSignin {
    private $user_id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      maxMessage = "Your name cannot be longer than {{ limit }} characters",
     *      minMessage = "Your name must be at least {{ limit }} characters long"
     * )
     */
    private $user_name;
    
    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      maxMessage = "Your lastname cannot be longer than {{ limit }} characters",
     *      minMessage = "Your lastname must be at least {{ limit }} characters long"
     * )
     */
    private $user_lastname;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 8,
     *      max = 20,
     *      minMessage = "Your password must be at least {{ limit }} characters long",
     *      maxMessage = "Your password cannot be longer than {{ limit }} characters"
     * )
     */
    private $user_password;
    
    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      maxMessage = "Your email cannot be longer than {{ limit }} characters",
     *      minMessage = "Your email must be at least {{ limit }} characters long"
     * )
     */
    private $user_email;

    /**
     * @Assert\Length(
     *      min = 0,
     *      max = 0,
     *      minMessage = "Your vcode must be at least {{ limit }} characters long",
     *      maxMessage = "Your vcode cannot be longer than {{ limit }} characters"
     * )
     */
    private $vcode;

    function SetUserid($id){
       $this->user_id=$id;
    }
    function GetUserid(){
        return $this->user_id;
    }
    function SetUsername($username){
       $this->user_name=$username;
    }
    function GetUsername(){
        return $this->user_name;
    }
    function SetUserlastname($userlastname){
       $this->user_lastname=$userlastname;
    }
    function GetUserlastname(){
        return $this->user_lastname;
    }
    function SetUserpassword($userpassword){
        $this->user_password=$userpassword;
    }
    function GetUserpassword(){
        return $this->user_password;
    }
    function SetUseremail($useremail){
        $this->user_email=$useremail;
    }
    function GetUseremail(){
        return $this->user_email;
    }
    function SetVcode($vcode){
        $this->vcode=$vcode;
    }
    function GetVcode(){
        return $this->vcode;
    }
    /*
    function SetSave($save){
        $this->save=$save;
    }
    function GetSave(){
        return $this->save;
    }
     */
}
