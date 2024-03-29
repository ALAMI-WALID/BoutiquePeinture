<?php

namespace App\Controller;

use App\Classe\MegaMenu;
use App\Form\ChangePasswordType;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;


class AccountPasswordController extends AbstractController
{
    private $entityManager;
    private $megaMenu;

    public function __construct(EntityManagerInterface $entityManager, MegaMenu $megaMenu)
    {
        $this->entityManager = $entityManager;
        $this->megaMenu = $megaMenu;

    }
    #[Route('/compte/modifier-mon-mot-de-passe', name: 'account_password', options: ['sitemap'=> ['section' =>'set_password']])]
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $notification = null;
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){            
            $old_password=$form->get('old_password')->getData();

            if($encoder->isPasswordValid($user,$old_password)){
                $new_password=$form->get('new_password')->getData();
                $password = $encoder->encodePassword($user,$new_password);
                $user->setPassword($password);
                $this->entityManager->persist($user);
                $this->entityManager->flush();
        
                $notification = "Votre mot de passe a bien été mise à jour !";
            
        }
            else{

                $notification = "Votre mot de passe actuel n'est pas le bon !";
            }
        }
        
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();

        return $this->render('account/password.html.twig',[
            'form' => $form->createView(),
            'notification'=> $notification,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories
        ]);
    }
}
