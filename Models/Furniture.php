<?php
require_once(ROOT . "Models/Product.php");

class Furniture extends Product
{

    /**
     * Inserts a new Furniture to db
     * 
     * @param string $sku unique identifier for each product
     * @param string $name of the inserted product
     * @param number $price of the inserted product
     * @param number $height of the Furniture in CM
     * @param number $width of the Furniture in CM
     * @param number $length of the Furniture in CM
     * 
     * @return bool execution status true if success and false in faild
     */
    public function add($sku, $name, $price, $height, $width, $length)
    {
        return $this->insertProduct($sku, $name, $price, static::class, [
            "height" => $height,
            "width" => $width,
            "length" => $length
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