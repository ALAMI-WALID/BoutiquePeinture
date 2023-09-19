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
      * @var string 
      */
      public $Papiercale;

    /**
     * @var string
     */
    public $Matiere;
    /**
     * @var string
     */
    public $qualitePapier;
    /**
     * @var string
     */
    public $bransMasquage;

    /**
     * @var string
     */
    public $dimensionpapier;
    /**
     * @var string
     */
    public $dimensiontuyau; 

    /**
     * @var string
     */
    public $dimensionFiltre;

    /**
     * @var string
     */
    public $typefiltreCabine;
    
    /**
     * @var string 
     */
    public $raccordAir;
    /**
     * @var string
     */
    public $TypeTuyau;
    /**
     * @var string
     */
    public $colorsAppret;
    
    /**
     * @var string
     */
    public $epaisseur;
    /**
     * @var string
     */

     public $FiltreContenance;

     /**
     * @var string
     */

     public $Grain;

     /**
      * @var string
      */
    public $marqueabrasif;


    /**
     * @var string
     */

     public $pack;
    /**
     * @var string
     */
    public $potbombe;
     /**
      * @var string
      */
    public $marquepestole;

     /**
      * @var 
      */
    public $Diluant;

    /**
     * @var TypePeinture[]
     */

     public $TypePeinture = [];


     /**
      * @var string
      */
      public $marque;

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