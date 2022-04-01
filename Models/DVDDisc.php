<?php
require_once(ROOT . "Models/Product.php");

class DVDDisc extends Product
{

    /**
     * Inserts a new DVD Disc to db
     * 
     * @param string $sku unique identifier for each product
     * @param string $name of the inserted product
     * @param number $price of the inserted product
     * @param number $size of the DVD file in MB
     * 
     * @return bool execution status true if success and false in faild
     */
    public function add($sku, $name, $price, $size)
    {
        return $this->insertProduct($sku, $name, $price, static::class, [
            "size" => $size
        ]);
    }


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
     * @param array $dvddisc wanted to extract its size
     * 
     * @return string the size of the DVD Disc in MB
     */
    public function getDetails($dvddisc){
        return "Size: " . $dvddisc["size"] . " MB";
    }
}
?>