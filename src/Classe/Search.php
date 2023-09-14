<?php

namespace App\Classe;
use App\Entity\Buses;
use App\Entity\Category;
use App\Entity\Product;

class Search{

    /**
     * @var int
     */
    public $page = 1;

    /**
    * @var string
    */

    public $string ='';

    /**
    * @var Product[]
    */
    public $subtitle = []; 

    /**
     * @var Category[]
     */

     public $categories = [];

     /**
     * @var Contenance[]
     */

     public $Contenance = [];

      /**
     * @var TypePeinture[]
     */

     public $TypePeinture = [];



     /**
      * @var Buses[]
      */
      public $buses =[];

     /**
      * @var null|integer 
      */
    public $max;

    /**
      * @var null|integer 
      */
      public $min;

      /**
     * @var boolean
     */
    public $promo = false;


}