<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Security\GoogleAuthenticator;

class GoogleController extends AbstractController
{
    /**
     * Link to this controller to start the "connect" process
     *
     * @Route("/connect/google", name="connect_google")
     * @param ClientRegistry $clientRegistry 
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectAction(ClientRegistry $clientRegistry)
    {
      
        // Redirect to Google!
        return $clientRegistry
            ->getClient('google_main') // Key used in config/packages/knpu_oauth2_client.yaml
            ->redirect();
    }

    /**
     * 
     * @Route("/connect/google/check", name="connect_google_check")
     * @param Request $request 
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectCheckAction(Request $request)
    {
        
        
        if(!$this->getUser()){
            return new JsonResponse(array('status'=>false,'message'=>'User not found'));

        }else{

            return $this->redirectToRoute('app_home');
        }
        
    }
}

