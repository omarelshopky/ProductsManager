<?php
class DVDDisc extends Product
{
    static private $tableName = "dvd_disc";

    /**
     * Inserts a new DVD Disc to db
     * 
     * @param string $sku unique identifier for each product
     * @param string $name of the inserted product
     * @param number $price of the inserted product
     * @param number $size of the DVD file in MB
     * 
     * @return object execution result
     */
    public function create($sku, $name, $price, $size)
    {
        $this->insertGeneralInformation($sku, $name, $price, DVDDisc::$tableName);

        $id = $this->getLastProductId();

        $sql = "INSERT INTO dvd_disc (id, size) VALUES (:id, :size)";
        $req = Database::getBdd()->prepare($sql);

        return $req->execute([
            'id' => $id,
            'size' => $size
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
        return $this->join($id, DVDDisc::$tableName);
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
        return $this->joinAll(DVDDisc::$tableName);
    }
}
?>