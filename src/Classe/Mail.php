<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private $api_key = '1c437027b04731f5bd48d14c8d19c990';
    private $api_key_secret = '99bf2f5727910c8c74a49659b4741cda';

    public function send()
    {
    //     $mj = new Client($this->api_key, $this->api_key_secret,true,['version' => 'v3.1']);
    //     $body = [
    //         'Messages' => [
    //             [
    //                 'From' => [
    //                     'Email' => "w_alami@stu-digital-campus.fr",
    //                     'Name' => "stu-digital-campus.fr"
    //                 ],
    //                 'To' => [
    //                     [
    //                         'Email' => $to_email,
    //                         'Name' => $to_name
    //                     ]
    //                 ],
    //                 'TemplateID' => 4839195,
    //                 'TemplateLanguage' => true,
    //                 'Subject' => $subject,
    //                 'Variables' => [
    //                     'content' => $content,
    //                 ]
    //             ]
    //         ]
    //     ];
    //     $response = $mj->post(Resources::$Email, ['body' => $body]);
    //     $response->success(); 
    //     dd($response->getData());
    // 

            $mj = new Client(getenv('1c437027b04731f5bd48d14c8d19c990'), getenv('99bf2f5727910c8c74a49659b4741cda'),true,['version' => 'v3.1']);
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "w_alami@stu-digital-campus.fr",
                            'Name' => "stu-digital-campus.fr"
                        ],
                        'To' => [
                            [
                                'Email' => 'walidalami1998@gmail.com',
                                'Name' => 'walid'
                            ]
                        ],
                        'Subject' => "Your email flight plan!",
                        'TextPart' => "Dear passenger 1, welcome to Mailjet! May the delivery force be with you!",
                        'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href=\"https://www.mailjet.com/\">Mailjet</a>!</h3><br />May the delivery force be with you!"
                    ]
                ]
            ];
            $response = $mj->post(Resources::$Email, ['body' => $body]);
            $response->success()&& var_dump($response->getData());
            
}
}