<?php
class ProductController extends Controller
{
    function list()
    {
        $data["title"] = "Product List";
        $data["products"] = array();
         
        // Creates array of products with all available types
        foreach ($GLOBALS["PRODUCT_TYPES"] as $type) {
            require(ROOT . "Models/".$type.".php");

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
        
        $this->set($data);
        $this->render("List");
    }
    
    
    function delete()
    {
        $data = $this->handlePostRequest(["product_type", "id"]);
        if (is_null($data)) return;

        // Check the product type to Prevent LFI and RFI
        if(!in_array($data["product_type"], $GLOBALS["PRODUCT_TYPES"], true)) {
            echo json_encode(array(
                "msg" => "Invalid Product Type"
            ));
            return;
        }

        // Check numeric state of the product ID
        if (!is_numeric($data["id"])){
            echo json_encode(array(
                "msg" => "Invalid Product ID"
            ));
            return;
        }
        
        // Delete the product
        require(ROOT . "Models/".$data["product_type"].".php");
        $product = new $data["product_type"]();
        $state = $product->delete($data["id"]);
            
        echo json_encode(array(
            "msg" => $state
        ));
        return;
    }


    function add() 
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            require_once(ROOT . "Models/Product.php");

            $data = $this->handlePostRequest(Product::$attributes);
            if (is_null($data)) return;

            // Check the product type to Prevent LFI and RFI
            if(!in_array($data["type"], $GLOBALS["PRODUCT_TYPES"], true)) {
                echo json_encode(array(
                    "msg" => "Invalid Product Type"
                ));
                return;
            }
            require(ROOT . "Models/".$data["type"].".php");
            $product = new $data["type"]();

            // Check if there any missing parameters for this product type
            $missingParameters = $this->getMissingParameters($data, $data["type"]::$attributes);

            if (count($missingParameters) > 0) {
                echo json_encode(array(
                    "msg" => "Missing Parameters: " . join(", ", $missingParameters)
                ));
                return;
            }

            // Check the SKU uniqness 
            if ($product->checkSKU($data["sku"])) {
                echo json_encode(array(
                    "msg" => "SKU Must be Unique for each product"
                ));
                return;
            }

            // Check numeric state of the product attributes
            $hasNumericProblem = $this->checkNumericState($data, array_merge($data["type"]::$attributes, ["price"]) );
            if (count($hasNumericProblem) > 0) {
                echo json_encode(array(
                    "msg" => "Invalid Numeric Parameters: " . join(", ", $hasNumericProblem)
                ));
                return;
            }

            // Check Name and SKU Length
            if (strlen($data["name"]) > 200) {
                echo json_encode(array(
                    "msg" => "Name can be 200 char maximum"
                ));
                return;
            }
            if (strlen($data["sku"]) > 100) {
                echo json_encode(array(
                    "msg" => "SKU can be 100 char maximum"
                ));
                return;
            }

            // Add new product to db
            $state = $product->add($data);

            echo json_encode(array(
                "msg" => $state
            ));

        } else {
            $data["title"] = "Product Add";
            
            $this->set($data);
            $this->render("Add");
        }
    }
}
?>