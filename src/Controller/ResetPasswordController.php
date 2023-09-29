<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Classe\MegaMenu;
use App\Entity\ResetPassword;
use App\Entity\User;
use App\Form\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordController extends AbstractController
{
    private $entityManager;

    private $megaMenu;
    public function __construct(EntityManagerInterface $entityManager, MegaMenu $megaMenu)
    {
        $this->entityManager = $entityManager;
        $this->megaMenu = $megaMenu;

    }

    #[Route('/mot-de-passe-oublie', name: 'reset_password')]
    public function index(Request $request): Response
    {
        $createdAt = new DateTimeImmutable(); 
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';

        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if($request->get('email')){
            $user = $this->entityManager->getRepository(User::class)->findOneByEmail($request->get('email'));
            if ($user) {
                // 1 : Enregistrer en base la demande de reset_password avec user, token, createdAt.
                $reset_password = new ResetPassword();
                $reset_password->setUser($user);
                $reset_password->setToken(uniqid());
                $reset_password->setCreatAt($createdAt);
                $this->entityManager->persist($reset_password);
                $this->entityManager->flush();

                // 2 : Envoyer un email à l'utilisateur avec un lien lui permettant de mettre à jour son mot de passe.
                $url = $this->generateUrl('update_password', [
                    'token' => $reset_password->getToken()
                ]);

                $content = "<br/>Vous avez demandé à réinitialiser votre mot de passe sur le site Peinture Auto Expert.<br/><br/>";
                $content .= "Merci de bien vouloir cliquer sur le lien suivant pour <a href='".$YOUR_DOMAIN.$url."'>mettre à jour votre mot de passe</a>.";

                $mail = new Mail();
                $mail->resetPassword($user->getEmail(), $user->getFirstname(),$user->getFirstname().' '.$user->getLastname(), 'Réinitialiser votre mot de passe sur Peinture Auto Expert', $content);
                $this->addFlash('notice', 'Vous allez recevoir dans quelques secondes un mail avec la procédure pour réinitialiser votre mot de passe.');

            } else {
                    $this->addFlash('notice', 'Cette adresse email est inconnue.');
                }

        }


        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();

        return $this->render('reset_password/index.html.twig', [
            'controller_name' => 'ResetPasswordController',
             'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories


        ]);
    }

    #[Route('/modifier-mon-mot-de-passe/{token}', name: 'update_password')]
    public function update(Request $request, $token, UserPasswordEncoderInterface $encoder){

        $reset_password = $this->entityManager->getRepository(ResetPassword::class)->findOneByToken($token);

        if (!$reset_password) {
            return $this->redirectToRoute('reset_password');
        }

        // Vérifier si le createdAt = now - 1h
        $now = new \DateTime();
        if ($now > $reset_password->getCreatAt()->modify('+ 1 hour')) {
            $this->addFlash('notice', 'Votre demande de mot de passe a expiré. Merci de la renouveller.');
            return $this->redirectToRoute('reset_password');
        }

         // Rendre une vue avec mot de passe et confirmez votre mot de passe.
         $form = $this->createForm(ResetPasswordType::class);
         $form->handleRequest($request);
 
         if ($form->isSubmitted() && $form->isValid()) {
             $new_pwd = $form->get('new_password')->getData();
 
             // Encodage des mots de passe
             $password = $encoder->encodePassword($reset_password->getUser(), $new_pwd);
             $reset_password->getUser()->setPassword($password);
 
             // Flush en base de donnée.
             $this->addFlash('notice', 'Votre mot de passe a bien été mis à jour.');
             $this->entityManager->flush();
 
             // Redirection de l'utilisateur vers la page de connexion.
             return $this->redirectToRoute('app_login');
         }
         $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();


         return $this->render('reset_password/update.html.twig', [
            'form' => $form->createView(),
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories
        ]);

 

    }

}
