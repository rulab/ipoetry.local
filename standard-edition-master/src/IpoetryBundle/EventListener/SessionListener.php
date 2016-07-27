<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace IpoetryBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Description of SessionListener
 *
 * @author d.krasavin
 */
class SessionListener {
    private $parameter;
    public function __construct($param)
    {
        $this->parameter = $param;
    }
    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($event->getRequestType() !== HttpKernelInterface::MASTER_REQUEST) {
            return;
        }

        if ($event->getRequest()->hasSession()){
            $session = $event->getRequest()->getSession();
            $metadataBag = $session->getMetadataBag();

            $Created = $metadataBag->getCreated();
            $lastUsed = $metadataBag->getLastUsed();
            $inactivity=getdate(time()-$Created);
            // the session was created just now
            //echo $lastUsed.' '.$inactivity['minutes'].' '.$this->parameter;
            //if ($lastUsed === null) {
            //    return;
            //}

            if (intval($inactivity['minutes'])>intval($this->parameter) )
               $session->invalidate(); 
            /*
            \Symfony\Component\VarDumper\VarDumper::dump(array(
                'session lastused'=>$lastUsed,
                'session Created'=>$Created,
                'session inactivity'=>$inactivity,
                'intval($inactivity[minutes])'=>intval($inactivity['minutes']),
                'intval($this->parameter)'=>intval($this->parameter)));
            */
        }

    }
}
