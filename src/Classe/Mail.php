<?php

namespace App\Classe;
use Mailjet\Client;
use Mailjet\Resources;


class Mail
{   
    
                
                private $api_key = '1c437027b04731f5bd48d14c8d19c990';
                private $api_key_secret = '3579eb81c2eb5d8ba92ab7b15c7944b9';

                

public function send($to_email, $to_name, $subject, $content)
         {
            
            $mj = new Client($this->api_key ,$this->api_key_secret,true,['version' => 'v3.1']);
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "developpeur@peintureautoexpert.com",
                            'Name' => "Mailjet"
                        ],
                        'To' => [
                            [
                                'Email' => $to_email,
                                'Name' => $to_name,
                            ]
                        ],
                        'TemplateID' => 4839195,
                        'TemplateLanguage' => true,
                        'Subject' => $subject,
                        'Variables' => [
                            'content' => $content,
                        ]
    
                    ]
                ]
            ];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            $response->success() ;
          
    
    }

    

}