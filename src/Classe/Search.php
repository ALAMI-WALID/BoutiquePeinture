<?php

namespace App\Classe;
use App\Entity\Category;

class Search{

    /**
     * @var int
     */
    public $page = 1;

    /**
    * @var string
    */

    public $string = '';

    /**
     * @var Category[]
     */

     public $categories = [];

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