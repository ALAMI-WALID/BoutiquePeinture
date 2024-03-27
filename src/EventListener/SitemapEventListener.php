<?php
namespace App\EventListener;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsEventListener(event: SitemapPopulateEvent::class, method: 'onSitemapPopulate')]

class SitemapEventListener

{   
    
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public  function onSitemapPopulate(SitemapPopulateEvent $event): void
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        $urlContainer = $event->getUrlContainer();
        $urlGenerator = $event->getUrlGenerator();

        
        //url de produit/slug
        foreach($products as $product){

            $url = new UrlConcrete(
                $urlGenerator->generate('product', ['slug' => $product->getSlug()], UrlGeneratorInterface::ABSOLUTE_URL) // The route to use for the URL
            );

            $urlContainer->addUrl($url, 'produit');

        }



        //url de simulateur 
        $urll = new UrlConcrete(

            $urlGenerator->generate('simulation', [], UrlGeneratorInterface::ABSOLUTE_URL)

        );
        $urlContainer->addUrl($urll, 'simulation');



    }
}
