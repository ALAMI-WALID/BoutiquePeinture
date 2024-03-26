<?php 

namespace App\Classe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Product;

class Favoris
{
    private $session;
    public function __construct(EntityManagerInterface $entityManager , SessionInterface $session){

        $this->session = $session;
        $this->entityManager = $entityManager;
    }
    

    
    public function add($id)
    {
        $favoris = $this->session->get('favoris', []);

        if (!empty($favoris[$id])) {
            $favoris[$id]++;
        } else {
            $favoris[$id] = 1;
        }

        $this->session->set('favoris', $favoris);
    }

    public function get()
    {
        return $this->session->get('favoris');
    }

    public function remove()
    {
        return $this->session->remove('favoris');
    }
    
    public function delete($id)
    {
        $favoris = $this->session->get('favoris', []);
        unset($favoris[$id]);

        return  $this->session->set('favoris', $favoris);
    }

    // public function decrease($id)
    // {
    //     $cart = $this->session->get('favoris', []);
    //     if($cart[$id] > 1)
    //     {
    //         //retirer une quantité(-1)
    //         $cart[$id]--;

    //     }else
    //     {
    //         //supprimer mon produit
    //         unset($cart[$id]);

    //     }

    //     return  $this->session->set('cart', $cart);
    // }
    public function getfull()
    {
        $favorisComplete = [];
        
        if($this->get()){
            
        foreach($this->get() as $id => $quantity){
            $produit_object = $this->entityManager->getRepository( Product::class)->findOneById($id);
            if(!$produit_object){
                $this->delete($id);
                continue;
            }
            $favorisComplete[] = [
                'product'=>$produit_object,
                'quantity'=>$quantity
            ];
        }
    }
        return $favorisComplete;
    }




}