<?php
namespace App\EventListener;
use App\Entity\Product;
use App\Entity\SousCategory;
use App\Entity\SousSousCategory;
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
        $Sous_sous_category = $this->entityManager->getRepository(SousSousCategory::class)->findAll();
        $Sous_category = $this->entityManager->getRepository(SousCategory::class)->findAll();


       

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
        $url1 = new UrlConcrete(

            $urlGenerator->generate('simulation', [], UrlGeneratorInterface::ABSOLUTE_URL)

        );
        $urlContainer->addUrl($url1, 'simulation');

        
        //url brands
        $barnds = [
            'Rupes',
            'Mipa',
            'Mirka',
            'Iwata',
            'Troton',
            'App',
            'Cristal',
            'Intfradis',
            'Finixa',
            'Prevost',
            'Gys',
        ];
        foreach($barnds as $brand){

            $url2 = new UrlConcrete(

                $urlGenerator->
                generate('productsInBrand', ['brand' =>$brand], UrlGeneratorInterface::ABSOLUTE_URL)
            );

            $urlContainer->addUrl($url2, 'nos_marques');

        }

        //url de Sous_sous_category
           foreach($Sous_sous_category as $sscategory){

            $url3 = new UrlConcrete(
                $urlGenerator->generate('productsInCategory', ['id' => $sscategory->getId()], UrlGeneratorInterface::ABSOLUTE_URL) // The route to use for the URL
            );

            $urlContainer->addUrl($url3, 'Sous_sous_category');

        }

        //url de Sous_category

        foreach($Sous_category as $scategory){

            $url4 = new UrlConcrete(
                $urlGenerator->generate('productsInSCategory', ['id' => $scategory->getId()], UrlGeneratorInterface::ABSOLUTE_URL) // The route to use for the URL
            );

            $urlContainer->addUrl($url4, 'Sous_category');

        }

    }
}
