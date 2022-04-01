<?php
require_once(ROOT . "Models/Product.php");

class DVD extends Product
{
    static public $attributes = ["size"];


    /**
     * Selects specific DVD Disc details from the db
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
     * Gets a line containing the DVD Dics Size detials
     * 
     * @param array $dvd wanted to extract its size
     * 
     * @return string the size of the DVD Disc in MB
     */
    public function getDetails($dvd){
        return "Size: " . (int)$dvd["size"] . " MB";
    }
}
?>