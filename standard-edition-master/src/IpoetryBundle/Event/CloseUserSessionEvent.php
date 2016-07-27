<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace IpoetryBundle\Event;
use Symfony\Component\EventDispatcher\Event;
/**
 * Description of CloseUserSessionEvent
 *
 * @author Нехай
 */
class CloseUserSessionEvent {
    private $code;

    public function setCode($code)
    {
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }

}
