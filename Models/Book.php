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
     * @return object execution result
     */
    public function create($sku, $name, $price, $weight)
    {
        $this->insertGeneralInformation($sku, $name, $price, static::class);

        $id = $this->getLastProductId();

        $sql = "INSERT INTO book (id, weight) VALUES (:id, :weight)";
        $req = Database::getBdd()->prepare($sql);

        return $req->execute([
            'id' => $id,
            'weight' => $weight
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