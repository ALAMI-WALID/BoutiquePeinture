<?php
namespace App\Security;

use App\Entity\User;
use League\OAuth2\Client\Provider\GoogleUser;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use App\Classe\Mail;

class GoogleAuthenticator extends OAuth2Authenticator
{
    private ClientRegistry $clientRegistry;
    private EntityManagerInterface $entityManager;
    private RouterInterface $router;

    public function __construct(ClientRegistry $clientRegistry, EntityManagerInterface $entityManager, RouterInterface $router)
    {
        $this->clientRegistry = $clientRegistry;
        $this->entityManager = $entityManager;
        $this->router = $router;
    }

    public function supports(Request $request): ?bool
    {
        // continue ONLY if the current ROUTE matches the check ROUTE
        return $request->attributes->get('_route') === 'connect_google_check';
    }

    public function authenticate(Request $request): Passport
    {
        $client = $this->clientRegistry->getClient('google_main');
        $accessToken = $this->fetchAccessToken($client);

        return new SelfValidatingPassport(
            new UserBadge($accessToken->getToken(), function () use ($accessToken, $client) {
                /** @var GoogleUser $googleUser */
                $googleUser = $client->fetchUserFromToken($accessToken);

                $email = $googleUser->getEmail();

                // have they logged in with Google before? Easy!
                $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);



                //User doesnt exist, we create it !
                if (!$existingUser) {
                    $existingUser = new User();
                    $existingUser->setEmail($email);
                        // Generate a random password aléatoire
                    $randomPassword = bin2hex(random_bytes(12));

                    // Set the password for the user
                    $existingUser->setPassword(password_hash($randomPassword, PASSWORD_BCRYPT));

                    $existingUser->setLastname($googleUser->getLastname());
                    $existingUser->setFirstname(($googleUser->getFirstname()));

                    $this->entityManager->persist($existingUser);
                    $this->entityManager->flush();

                    $mail = new Mail();
                    $content = "Bonjour ".$user->getFirstname()."<br/><br><br/>Bienvenue dans la communauté Peinture Auto Expert, la référence en matière de peinture automobile et d'outillage de carrosserie made in France !<br><br/>Nous sommes ravis de vous accueillir parmi nos membres. Vous avez fait le choix de la qualité, de l'excellence et du savoir-faire français, et nous sommes là pour vous accompagner dans votre passion pour l'automobile.<br><br/>Chez Peinture Auto Expert, nous comprenons votre désir de transformer votre véhicule en une œuvre d'art. C'est pourquoi nous mettons à votre disposition une sélection exclusive de produits de peinture haut de gamme, d'apprêts performants, de vernis résistants et d'accessoires spécialisés. Chaque produit que vous trouverez dans notre boutique a été soigneusement choisi pour répondre aux exigences des amateurs passionnés et des professionnels exigeants.<br><br/>Mais Peinture Auto Expert, ce n'est pas seulement des produits exceptionnels. C'est aussi une équipe de passionnés prête à vous offrir un service personnalisé et des conseils d'experts. Nous sommes là pour vous accompagner à chaque étape de votre projet, que ce soit pour une réparation, une restauration ou simplement pour sublimer votre véhicule.<br><br/>En tant que membre privilégié de notre communauté, vous bénéficierez d'avantages exclusifs, d'offres spéciales et d'accès en avant-première à nos nouveautés. Vous ferez partie d'une communauté qui partage votre passion pour l'automobile et qui est fière de promouvoir le made in France.<br><br/>Nous vous invitons à parcourir notre site web, à explorer nos produits et à vous laisser inspirer. N'hésitez pas à nous contacter si vous avez des questions ou besoin de conseils supplémentaires. Nous sommes là pour vous aider à réaliser vos rêves automobiles.<br><br/>Encore une fois, bienvenue chez Peinture Auto Expert ! Préparez-vous à vivre une expérience exceptionnelle où qualité, performance et esthétique se rejoignent pour vous offrir le meilleur de la peinture automobile made in France.<br><br/>Cordialement,<br/><br/>L'équipe Peinture Auto Expert";
                    $mail->welcom($user->getEmail(), $user->getFirstname(), 'Bienvenue sur Peinture Auto Expert', $content);
                }
                

                return $existingUser;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {

        // change "app_dashboard" to some route in your app
        return new RedirectResponse(
            $this->router->generate('app_home')
        );

        // or, on success, let the request continue to be handled by the controller
        //return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        return new Response($message, Response::HTTP_FORBIDDEN);
    }

//    public function start(Request $request, AuthenticationException $authException = null): Response
//    {
//        /*
//         * If you would like this class to control what happens when an anonymous user accesses a
//         * protected page (e.g. redirect to /login), uncomment this method and make this class
//         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
//         *
//         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
//         */
//    }
}