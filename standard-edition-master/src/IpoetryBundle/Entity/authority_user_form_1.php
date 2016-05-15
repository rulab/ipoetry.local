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

/**
 * Description of authority_user_class
 *
 * @author denvkr
 * @ORM\Entity
 * @UniqueEntity(fields="name", message="Username already taken")
 */
class authority_user_form {
    //put your code here
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", length=11)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $ID;
    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $login;
    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=8)
     * @ORM\Column(type="string", length=20)
     */    
    private $password;
    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $mail_address;
    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank()
     */
    private $Name;
    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=50)
     */
    private $Last_Name;  
    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=250)
     */
    private $Address; 
    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="integer", length=11)
     */
    private $Age;
    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="integer", length=11)
     */    
    private $drivers_length;
    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=1024)
     */
    private $rent_request;
    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="integer", length=11)
     */
    private $Rent_Event_ID;
    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=250)
     */
    private $Mail_Link_Info;
    
    public function getLogin(){
        return $this->login;
    }
    public function setLogin($login){
        $this->login=$login;
    }
    
    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){
        $this->password=$password;
    }
    
    public function getMail_Address(){
        return $this->mail_address;
    }
    public function setMail_Address($mail_address){
        $this->mail_address=$mail_address;
    }
    
    public function getName(){
        return $this->Name;
    }
    public function setName($Name){
        $this->Name=$Name;
    }
    
    public function getLast_Name(){
        return $this->Last_Name;
    }
    public function setLast_Name($Last_Name){
        $this->Last_Name=$Last_Name;
    }

    public function getAddress(){
        return $this->Address;
    }
    public function setAddress($Address){
        $this->Address=$Address;
    }
    
    public function getAge(){
        return $this->Age;
    }
    public function setAge($Age){
        $this->Age=$Age;
    }
    
    public function getDrivers_Length(){
        return $this->drivers_length;
    }
    public function setDrivers_Length($drivers_length){
        $this->drivers_length=$drivers_length;
    }
    
    public function getRent_Request(){
        return $this->rent_request;
    }
    public function setRent_Request($rent_request){
        $this->rent_request=$rent_request;
    }
    
    public function getRent_Event_Id(){
        return $this->Rent_Event_ID;
    }
    public function setRent_Event_Id($Rent_Event_ID){
        $this->Rent_Event_ID=$Rent_Event_ID;
    }
    
    public function getMail_Link_Info(){
        return $this->Mail_Link_Info;
    }
    public function setMail_Link_Info($Mail_Link_Info){
        $this->Mail_Link_Info=$Mail_Link_Info;
    }
}
?>