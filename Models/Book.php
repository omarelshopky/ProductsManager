<?php
require_once(ROOT . "Models/Product.php");

class Book extends Product
{
    static public $attributes = ["weight"];


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
     * Selects All Books details from the db
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
     * Gets a line containing the book weight detials
     * 
     * @param array $book wanted to extract its weight
     * 
     * @return string the weight of the book in KG
     */
    public function getDetails($book){
        return "Weight: " . $book["weight"] . "KG";
    }
}
?>