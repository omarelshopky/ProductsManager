<?php
    abstract class Controller
    {
        var $vars = [];
        var $layout = "default";

        /**
         * Merges all the data will be passed to the view
         * 
         * @param array Elements want to merge with the current variables
         * 
         * @return void
         */
        function set($d)
        {
            $this->vars = array_merge($this->vars, $d);
        }


        /**
         * Loads the layout requested in the views directory
         * 
         * @param string $filename wanted to be render
         * 
         * @return void
         */
        function render($filename)
        {
            extract($this->vars); // Imports data so they can be callable from any file
            ob_start();
            require(ROOT . "Views/" . ucfirst(str_replace('Controller', '', get_class($this))) . '/' . $filename . '.php');
            $content_for_layout = ob_get_clean();

            if ($this->layout == false)
            {
                $content_for_layout;
            }
            else
            {
                require(ROOT . "Views/Layouts/" . $this->layout . '.php');
            }
        }


        /**
         * Gets the missing parameter for specific function use POST requests
         * 
         * @param array $data want to check if have a missing parts
         * @param array $paramHeaders needed for the function
         * 
         * @return array contains the missing headers
         */
        private function getMissingParameters($data, $paramHeaders) {
            $missingParameter = array();
            
            foreach ($paramHeaders as $parameter) {
                if (!array_key_exists($parameter, $data))
                    array_push($missingParameter, $parameter);     
            }
            
            return $missingParameter;
        }


        /**
         * Handles general validation done to accept a post request
         * 
         * @param array $paramHeader needed for the requested process
         * 
         * @return array $data sent in the request body
         */
        protected function handlePostRequest($paramHeader) {

            // Takes the body data from the request
            $data = json_decode(file_get_contents('php://input'), true);
            
            if (is_null($data)){
                echo json_encode(array(
                    "msg" => "Invalid JSON Format"
                ));
                return;
            }
            
            // Check if there any missing parameters
            $missingParameters = $this->getMissingParameters($data, $paramHeader);

            if (count($missingParameters) > 0) {
                echo json_encode(array(
                    "msg" => "Missing Parameters: " . join(", ", $missingParameters)
                ));
                return;
            }

            return $this->secure_form($data);
        }


        /**
         * Filters mallisious special characters from the user input
         * 
         * @param string $data user provide as an input
         * 
         * @return void
         */
        private function secure_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }


        /**
         * Conducts filters on each entity in a data array
         * 
         * @param array $data came from the user input
         * 
         * @return array the data array after conduct the filters
         */
        protected function secure_form($data)
        {
            foreach ($data as $key => $value)
            {
                $data[$key] = $this->secure_input($value);
            }

            return $data;
        }

    }
?>