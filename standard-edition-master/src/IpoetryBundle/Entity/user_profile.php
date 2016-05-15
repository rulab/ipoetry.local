<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 *                 $form = $formFactory->createBuilder('form',$defaults, array('action' => $action,'method' => 'POST'))
                        ->add('login','text')
                        ->add('password','text')
                        ->add('mail_address','email')
                        ->add('name','text')
                        ->add('last_name','text')
                        ->add('address','text')
                        ->add('age','text')
                        ->add('drivers_length','text')
                        ->add('rent_request','textarea')
                        ->add('captcha', CaptchaType::class,$options)
                        ->getForm();

 */

class user_profile {
    protected $login;
    protected $password;
    protected $mail_address;
    protected $name;
    protected $last_name;
    protected $address;
    protected $age;
    protected $drivers_length;
    protected $rent_request;
    protected $captcha;
public function getLogin(){
    return $this->login;
}
public function SetLogin($login){
    $this->login=$login;
}
public function getPassword(){
    return $this->password;
}
public function SetPassword($password){
    $this->password=$password;
}
public function getMail_address(){
    return $this->mail_address;
}
public function SetMail_address($mail_address){
    $this->password=$mail_address;
}
public function getName(){
    return $this->name;
}
public function SetName($name){
    $this->name=$name;
}
public function getLast_name(){
    return $this->last_name;
}
public function SetLast_name($last_name){
    $this->name=$last_name;
}
public function getAddress(){
    return $this->address;
}
public function SetAddress($address){
    $this->name=$address;
}
public function getAddress(){
    return $this->address;
}
public function SetAddress($address){
    $this->address=$address;
}
public function getAge(){
    return $this->age;
}
public function SetAge($age){
    $this->age=$age;
}
public function getDrivers_length(){
    return $this->drivers_length;
}
public function SetDrivers_length($drivers_length){
    $this->drivers_length=$drivers_length;
}
public function getRent_request(){
    return $this->rent_request;
}
public function SetRent_request($rent_request){
    $this->rent_request=$rent_request;
}
public function getCaptcha(){
    return $this->captcha;
}
public function SetCaptcha($captcha){
    $this->captcha=$captcha;
}
}