<?php

namespace App\Classe;
use Mailjet\Client;
use Mailjet\Resources;


class Mail
{   
    
                
                private $api_key = '879d04506a21c1f48cee943197eecbf4';
                private $api_key_secret = '588307969731d5d7b6ac510f60bddf7f';

                

public function send($to_email, $to_name, $subject, $content)
         {
            
            $mj = new Client($this->api_key ,$this->api_key_secret,true,['version' => 'v3.1']);
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "info@peintureautoexpert.com",
                            'Name' => "peinture Auto Expert"
                        ],
                        'To' => [
                            [
                                'Email' => $to_email,
                                'Name' => $to_name,
                            ]
                        ],
                        'TemplateID' => 5129983,
                        'TemplateLanguage' => true,
                        'Subject' => $subject,
                        'Variables' => [
                            'content' => $to_name,
                        ]
    
                    ]
                ]
            ];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            $response->success() ;
          
    
    }

    public function welcome($to_email, $to_name, $subject)
         {
            
            $mj = new Client($this->api_key ,$this->api_key_secret,true,['version' => 'v3.1']);
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "info@peintureautoexpert.com",
                            'Name' => "PEINTURE AUTO EXPERT"
                        ],
                        'To' => [
                            [
                                'Email' => $to_email,
                                'Name' => $to_name,
                            ]
                        ],
                        'TemplateID' => 5129983,
                        'TemplateLanguage' => true,
                        'Subject' => $subject,
                        'Variables' => [
                            'content' => $to_name,
                        ]
    
                    ]
                ]
            ];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            $response->success() ;
          
    
    }

    public function resetPassword($to_email,$name, $to_name, $subject, $content)
         {
            
            $mj = new Client($this->api_key ,$this->api_key_secret,true,['version' => 'v3.1']);
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "info@peintureautoexpert.com",
                            'Name' => "peinture Auto Expert"
                        ],
                        'To' => [
                            [
                                'Email' => $to_email,
                                'Name' => $to_name,
                            ]
                        ],
                        'TemplateID' => 5138348,
                        'TemplateLanguage' => true,
                        'Subject' => $subject,
                        'Variables' => [
                            'content' => $content,
                            'name'=>$name,
                        ]
    
                    ]
                ]
            ];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            $response->success() ;
          
    
    }


    

}

