<?php
class Furniture extends Product
{
    static private $tableName = "furniture";


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
     * @return object execution result
     */
    public function create($sku, $name, $price, $height, $width, $length)
    {
        $this->insertGeneralInformation($sku, $name, $price, Furniture::$tableName);

        $id = $this->getLastProductId();

        $sql = "INSERT INTO book (id, height, width, length) VALUES (:id, :height, :width, :length)";
        $req = Database::getBdd()->prepare($sql);

        return $req->execute([
            'id' => $id,
            'height' => $height,
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
        return $this->join($id, Furniture::$tableName);
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
        return $this->joinAll(Furniture::$tableName);
    }
}
?>