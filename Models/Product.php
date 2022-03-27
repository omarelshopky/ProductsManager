<?php
abstract class Product
{

    /**
     * Inserts the general information of a new product to db
     * 
     * @param string $sku unique identifier for each product
     * @param string $name of the inserted product
     * @param number $price of the inserted product
     * 
     * @return object execution result
     */
    public function create($sku, $name, $price)
    {
        $sql = "INSERT INTO product (sku, name, price) VALUES (:sku, :name, :price)";

        $req = Database::getBdd()->prepare($sql);

        return $req->execute([
            "sku" => $sku,
            "name" => $name,
            "price" => $price
        ]);
    }


    /**
     * Selects specific product details from the db
     * 
     * @param int|string $id of the product in the database
     * 
     * @return object An object map the product details
     */
    abstract public function show($id);


    /**
     * Deletes specific product from the db
     * 
     * @param int|string $id of the product want to be deleted
     * 
     * @return object execution result
     */
    public function delete($id)
    {
        $sql = "DELETE FROM product WHERE id = ?";
        $req = Database::getBdd()->prepare($sql);
        return $req->execute([$id]);
    }
}
?>