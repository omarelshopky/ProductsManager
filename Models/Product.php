<?php
abstract class Product extends Model
{
    static public $attributes = ["sku", "name", "price", "type"];
    
    /**
     * Inserts new product from specific type to db
     * 
     * @param string $sku unique identifier for each product
     * @param string $name of the inserted product
     * @param number $price of the inserted product
     * @param string $type of the product 
     * @param array $data associated to this product type
     * 
     * @return bool execution status true if success and false in faild
     */
    public function add($data)
    {
        $state = $this->insert("Product", $data);

        if ($state) {
            return $this->insert($data["type"], array_merge($data, ["id" => $this->getLastProductId()])); 
        } else
            return false;
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
        $sql = "SELECT * FROM product p INNER JOIN " . strtolower($tableName) . " ON p.id = " . strtolower($tableName) . ".id = ?";
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
        $sql = "SELECT * FROM product p INNER JOIN " . strtolower($tableName) . " ON p.id = " . strtolower($tableName) . ".id";
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
    private function getLastProductId()
    {
        $sql = "SELECT * FROM product ORDER BY id DESC LIMIT 1";
        $req = Database::getBdd()->prepare($sql);
        $req->execute();
        return $req->fetch()['id'];
    }


    /**
     * Gets a line containing the product detials
     * 
     * @param array $product wanted to extract its details
     * 
     * @return string line of the product detials
     */
    abstract public function getDetails($product);


    /**
     * Checks whether there is a product has this sku or not
     * 
     * @param string $sku to be checked
     * 
     * @return bool true if there is a product with this sku, and false if not
     */
    public function checkSKU($sku) {
        $sql = "SELECT * FROM product WHERE sku = ?";
        $req = Database::getBdd()->prepare($sql);
        $req->execute([$sku]);

        return !empty($req->fetchAll());
    }
}
?>