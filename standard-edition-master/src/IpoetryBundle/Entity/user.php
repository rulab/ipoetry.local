<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace IpoetryBundle\Entity;
/**
 * Description of user
 *
 * @author d.krasavin
 * используется для проверки аутентификации пользователя в IpoetryBundle\Controller\uRoomController.php
 */
class user {
private $user_name;
private $user_password;

public function GetUser_name(){
    return $this->user_name;
}
public function GetUser_password(){
    return $this->user_password;
}
public function SetUser_name($user_name){
    $this->user_name=$user_name;
}
public function SetUser_password($user_password){
    $this->user_password=$user_password;
}

}
