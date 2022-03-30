<?php
class Product
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
    protected function insertGeneralInformation($sku, $name, $price, $type)
    {
        $sql = "INSERT INTO product (sku, name, price, type) VALUES (:sku, :name, :price, :type)";

        $req = Database::getBdd()->prepare($sql);

        return $req->execute([
            "sku" => $sku,
            "name" => $name,
            "price" => $price
        ]);
    }


    /**
     * Joins specific custom product type with its general information according to its ID
     * 
     * @param int|string $id of the product in the database
     * @param string $tableName of the product type
     * 
     * @return object An object map the product details
     */
    protected function join($id, $tableName) {
        $sql = "SELECT * FROM product p INNER JOIN " . $tableName . " ON p.id = " . $tableName . ".id = ?";
        $req = Database::getBdd()->prepare($sql);
        $req->execute([$id]);
        return $req->fetch();
    }


    /**
     * Joins all custom product type with thier general information
     * 
     * @param int|string $id of the product in the database
     * @param string $tableName of the product type
     * 
     * @return object An object map the product details
     */
    protected function joinAll($tableName) {
        $sql = "SELECT * FROM product p INNER JOIN " . $tableName . " ON p.id = " . $tableName . ".id";
        $req = Database::getBdd()->prepare($sql);
        $req->execute([]);
        return $req->fetchAll();
    }


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

    
    /**
     * Gets the ID of last inserted product in the database
     * 
     * @return string the last product's ID
     */
    protected function getLastProductId()
    {
        $sql = "SELECT * FROM product ORDER BY id DESC LIMIT 1";
        $req = Database::getBdd()->prepare($sql);
        $req->execute();
        return $req->fetch()['id'];
    }
}
?>