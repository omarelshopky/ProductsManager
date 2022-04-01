<?php
require_once(ROOT . "Models/Product.php");

class Book extends Product
{
    
    /**
     * Inserts a new Book to db
     * 
     * @param string $sku unique identifier for each product
     * @param string $name of the inserted product
     * @param number $price of the inserted product
     * @param number $weight of the Book in KG
     * 
     * @return bool execution status true if success and false in faild
     */
    public function add($sku, $name, $price, $weight)
    {
        return $this->insertProduct($sku, $name, $price, static::class, [
            "weight" => $weight
        ]);
    }


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