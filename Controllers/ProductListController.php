<?php
class ProductListController extends Controller
{
    function index()
    {
        require(ROOT . "Models/Product.php");
        require(ROOT . "Models/Book.php");
        require(ROOT . "Models/DVDDisc.php");
        require(ROOT . "Models/Furniture.php");

        $books = new Book();
        $dvdDiscs = new DVDDisc();
        $furnitures = new Furniture();

        $data["products"] = array();

        foreach ($books->getAll() as $book) {
            $data["products"][$book["id"]] = array(
                "id" => $book["id"],
                "sku" => $book["sku"],
                "name" => $book["name"],
                "price" => $book["price"],
                "details" => "Weight: " . $book["weight"] . "KG"
            );
        }

        foreach ($dvdDiscs->getAll() as $dvdDisc) {
            $data["products"][$dvdDisc["id"]] = array(
                "id" => $dvdDisc["id"],
                "sku" => $dvdDisc["sku"],
                "name" => $dvdDisc["name"],
                "price" => $dvdDisc["price"],
                "details" => "Size: " . $dvdDisc["size"] . " MB"
            );
        }

        foreach ($furnitures->getAll() as $furniture) {
            $data["products"][$furniture["id"]] = array(
                "id" => $furniture["id"],
                "sku" => $furniture["sku"],
                "name" => $furniture["name"],
                "price" => $furniture["price"],
                "details" => "Dimension: " . $furniture["height"] . "x" . $furniture["width"] . "x" . $furniture["length"]
            );
        }
        
        ksort($data["products"]); // Sort products according to ID
        
        $data["title"] = "Product List";
        
        $this->set($data);
        $this->render("index");
    }
    
    
    function delete($id=-1)
    {
        require(ROOT . "Models/Product.php");

        if ($id != -1) {
            $product = new Product();
            $product->delete($id);
        } 
        
        header("Location: /");
    }
}
?>