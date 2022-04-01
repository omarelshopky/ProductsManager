<?php
require_once(ROOT . "Models/Product.php");

class Furniture extends Product
{

    static public $attributes = ["height", "width", "length"];


    /**
     * Selects specific Book details from the db
     * 
     * @param int|string $id of the product in the database
     * 
     * @return object An object map the product details
     */
    public function get($id)
    {
        return $this->join($id, static::class);
    }


    /**
     * Selects All DVD Disc details from the db
     * 
     * @param int|string $id of the product in the database
     * 
     * @return object An object map the product details
     */
    public function getAll()
    {
        return $this->joinAll(static::class);
    }


    /**
     * Gets a line containing the furniture dimension detials
     * 
     * @param array $furniture wanted to extract its dimension
     * 
     * @return string the dimension of thefurniture in HxWxL format
     */
    public function getDetails($furniture){
        return "Dimension: " . $furniture["height"] . "x" . $furniture["width"] . "x" . $furniture["length"];
    }
}
?>