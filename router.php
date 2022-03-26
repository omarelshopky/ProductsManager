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
            
            if ($url == "/")
            {
                $request->controller = "tasks";
                $request->action = "index";
                $request->params = [];
            }
            else
            {
                $explode_url = explode('/', $url);
                $explode_url = array_slice($explode_url, 1);
                
                $request->controller = $explode_url[0];
                $request->action = $explode_url[1];
                $request->params = array_slice($explode_url, 2);
            }

        }
    }
?>