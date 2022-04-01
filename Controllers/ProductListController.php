<?php
class ProductListController extends Controller
{
    function index()
    {
        require(ROOT . "Models/Book.php");
        require(ROOT . "Models/DVDDisc.php");
        require(ROOT . "Models/Furniture.php");

        $data["products"] = array();
         
        foreach ($GLOBALS["PRODUCT_TYPES"] as $type) {

            $products = new $type();
            foreach ($products->getAll() as $product) {
                $data["products"][$product["id"]] = array(
                    "id" => $product["id"],
                    "sku" => $product["sku"],
                    "name" => $product["name"],
                    "price" => $product["price"],
                    "type" => $product["type"],
                    "details" => $products->getDetails($product)
                );
            }
        };
        
        ksort($data["products"]); // Sort products according to ID
        
        $data["title"] = "Product List";
        
        $this->set($data);
        $this->render("index");
    }
    
    
    function delete($productType="", $id=-1)
    {
        // Prevent LFI and RFI
        if(!in_array($productType, $GLOBALS["PRODUCT_TYPES"], true) || $id === -1)
            header("Location: /");

        require(ROOT . "Models/".$productType.".php");
        
        $product = new $productType();
        $product->delete($id);
        
        header("Location: /");
    }
}
?>