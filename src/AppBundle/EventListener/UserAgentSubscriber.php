<?php

namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UserAgentSubscriber implements EventSubscriberInterface
{
    private $logger;
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
    	
    	if (!$event->isMasterRequest()) {
        	return;
    	}
    
        $request = $event->getRequest();
        $userAgent = $request->headers->get('User-Agent');
        $this->logger->info('Hello there browser: '.$userAgent);
        
        //$response = new Response('Come back later');
        //$event->setResponse($response); //setResponse fait partie du GetResponseEvent
        
        
        $isMac = stripos($userAgent, 'Mac') !== false;
    	if ($request->query->get('notMac')) {
        	$isMac = false;
	    }
	    $request->attributes->set('isMac', $isMac);
    
    
        //return;
        /*$request->attributes->set('_controller', function($id) {
        	return new Response('Hello '.$id);
    	});*/
    }

    public static function getSubscribedEvents()
    {
        return array(
            'kernel.request' => 'onKernelRequest'
        );
    }
}
