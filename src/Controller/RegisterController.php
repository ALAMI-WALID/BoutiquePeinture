<?php

namespace App\Controller;
use App\Classe\Mail;
use App\Classe\MegaMenu;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class RegisterController extends AbstractController
{
    private $entityManager;

    private $megaMenu;
    public function __construct(EntityManagerInterface $entityManager, MegaMenu $megaMenu)
    {
        $this->entityManager = $entityManager;
        $this->megaMenu = $megaMenu;

    }
    #[Route('/inscription', name: 'register', options: ['sitemap'=> ['section' =>'register']])]
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {   
        $notification = null;
        $user = new User();
        $form = $this->createForm(RegisterType::class,$user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() ){
            $user=$form->getData();
            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());
            if (!$search_email) {



            $password = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($password);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $notification = "Votre inscription s'est correctement déroulée. Vous pouvez dès à présent vous connecter à votre compte.";

            //l'email de l'inscription 
            $mail = new Mail();
            $content = "Bonjour ".$user->getFirstname()."<br/><br><br/>Bienvenue dans la communauté Peinture Auto Expert, la référence en matière de peinture automobile et d'outillage de carrosserie made in France !<br><br/>Nous sommes ravis de vous accueillir parmi nos membres. Vous avez fait le choix de la qualité, de l'excellence et du savoir-faire français, et nous sommes là pour vous accompagner dans votre passion pour l'automobile.<br><br/>Chez Peinture Auto Expert, nous comprenons votre désir de transformer votre véhicule en une œuvre d'art. C'est pourquoi nous mettons à votre disposition une sélection exclusive de produits de peinture haut de gamme, d'apprêts performants, de vernis résistants et d'accessoires spécialisés. Chaque produit que vous trouverez dans notre boutique a été soigneusement choisi pour répondre aux exigences des amateurs passionnés et des professionnels exigeants.<br><br/>Mais Peinture Auto Expert, ce n'est pas seulement des produits exceptionnels. C'est aussi une équipe de passionnés prête à vous offrir un service personnalisé et des conseils d'experts. Nous sommes là pour vous accompagner à chaque étape de votre projet, que ce soit pour une réparation, une restauration ou simplement pour sublimer votre véhicule.<br><br/>En tant que membre privilégié de notre communauté, vous bénéficierez d'avantages exclusifs, d'offres spéciales et d'accès en avant-première à nos nouveautés. Vous ferez partie d'une communauté qui partage votre passion pour l'automobile et qui est fière de promouvoir le made in France.<br><br/>Nous vous invitons à parcourir notre site web, à explorer nos produits et à vous laisser inspirer. N'hésitez pas à nous contacter si vous avez des questions ou besoin de conseils supplémentaires. Nous sommes là pour vous aider à réaliser vos rêves automobiles.<br><br/>Encore une fois, bienvenue chez Peinture Auto Expert ! Préparez-vous à vivre une expérience exceptionnelle où qualité, performance et esthétique se rejoignent pour vous offrir le meilleur de la peinture automobile made in France.<br><br/>Cordialement,<br/><br/>L'équipe Peinture Auto Expert";
            $mail->welcome($user->getEmail(), $user->getFirstname(), 'Bienvenue sur Peinture Auto Expert', $content);

            }else{
                $notification = "L'email que vous avez renseigné existe déjà.";
            }
        }
        $categories = $this->megaMenu->mega();
        $Scategories = $this->megaMenu->megaS();
        $SScategories = $this->megaMenu->megaSS();

        return $this->render('register/index.html.twig',[
            'form' => $form->createView(),
            'notification' =>$notification,
            'categories' =>$categories,
            'Scategories' =>$Scategories,
            'SScategories'=>$SScategories

        ]);
    }
}
