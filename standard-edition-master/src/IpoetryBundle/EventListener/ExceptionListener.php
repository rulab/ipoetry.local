<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace IpoetryBundle\EventListener;
/**
 * Description of ExceptionListener
 * слушаем исключения для ipoetry
 * @author d.krasavin
 */
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Dumper\HTMLDumper;

class ExceptionListener {
    private $parameter;
    public function __construct($param)
    {
        $this->parameter = $param;
    }
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        // You get the exception object from the received event
        $exception = $event->getException();
        $message = sprintf(
            'iPoetry Error : %s with code: %s trace: %s',
            $exception->getFile(),
            $exception->getMessage(),
            $exception->getCode(),
            VarDumper::dump($exception->getTrace())
        );
        //$container = new ContainerBuilder();
        //$container->register('loginvk','IpoetryBundle\Controller\LoginVkController');
        //$container->addCompilerPass(new TransportCompilerPass());
        // Customize your response object to display the exception details
        $response = new Response();
        //$response->sendHeaders();
        //echo preg_match('/(failed to open stream: HTTP request failed! HTTP\/1\.1 401 Unauthorized)/i', $message);
        if (preg_match('/(failed to open stream: HTTP request failed! HTTP\/1\.1 401 Unauthorized)/i', $message)==1)
            $response->setContent('<meta http-equiv="refresh" content="0;'.$this->parameter.'">'.  $message);              
        else       
            $response->setContent($message);

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Send the modified response object to the event
        $event->setResponse($response);
    }    
}
