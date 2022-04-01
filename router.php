<?php
    /**
     * Class handles routing URLs to its destination
     */
    class Router
    {
        /**
         * Parse a URL to its main components to call the right controller
         * 
         * @param string $url contains the url extracted from the request
         * @param Request $request contains the request done by user
         * 
         * @return void
         */
        static public function parse($url, $request)
        {
            $url = trim($url);
            $url_components = explode('/', $url);
            $url_components = array_slice($url_components, 1);
            
            $route = Router::route($url_components);

            $request->controller = $route["controller"];
            $request->action = $route["action"];
            $request->params = $route["params"]; 
        }


        /**
         * Handles routing user to the right controller without calling function according to user input
         * 
         * @param string $url_components user hitted
         * 
         * @return array contains controller, action and params handles this route
         */
        static public function route($url_components) 
        {
            switch ($url_components[0]) {
                case "":
                    return array(
                        "controller" => "Product",
                        "action" => "list",
                        "params" => []
                    );
                
                case "add-product":
                    return array(
                        "controller" => "Product",
                        "action" => "add",
                        "params" => []
                    );

                case "api":
                    // Enable only POST requests for this resources
                    if ($_SERVER['REQUEST_METHOD'] != "POST")
                        header("Location: /");
                        
                    switch (@$url_components[1]) {
                        case "delete-product":
                            return array(
                                "controller" => "Product",
                                "action" => "delete",
                                "params" => []
                            );
                    }
                default:
                    die("404 - Page Not Found.");
            }
        }
    }
?>