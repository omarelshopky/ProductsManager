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
        
    }

    // function create()
    // {
    //     if (isset($_POST["title"]))
    //     {
    //         require(ROOT . "Models/Task.php");

    //         $task= new Task();

    //         if ($task->create($_POST["title"], $_POST["description"]))
    //         {
    //             header("Location: " . WEBROOT . "tasks/index");
    //         }
    //     }

    //     $this->render("create");
    // }

    // function edit($id)
    // {
    //     require(ROOT . "Models/Task.php");
    //     $task= new Task();

    //     $d["task"] = $task->showTask($id);

    //     if (isset($_POST["title"]))
    //     {
    //         if ($task->edit($id, $_POST["title"], $_POST["description"]))
    //         {
    //             header("Location: " . WEBROOT . "tasks/index");
    //         }
    //     }
    //     $this->set($d);
    //     $this->render("edit");
    // }
}
?>