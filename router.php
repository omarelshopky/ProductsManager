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
            $explode_url = explode('/', $url);
            $explode_url = array_slice($explode_url, 1);
            
            $endpoint = "/" . $explode_url[0];
            
            $request->controller = Router::route($endpoint);
            $request->action = (array_key_exists(1, $explode_url))? $explode_url[1] : "index";
            $request->params = (array_key_exists(2, $explode_url))? array_slice($explode_url, 2) : []; 
        }


        /**
         * Handles routing user to the right controller
         * 
         * @param string $endpoint user want to hit
         * 
         * @return string Controller's name handles this route
         */
        static public function route($endpoint) 
        {
            switch ($endpoint) {
                case "/":
                    return "ListProducts";

                case "/add-product":
                    return "AddProduct";

                default:
                    die("404 - Page Not Found.");
            }
        }
    }
?>