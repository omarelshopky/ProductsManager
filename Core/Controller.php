<?php
    class Controller
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
         * Filters inputs cames from the user
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
         * Filters each input in a form data
         * 
         * @param array $form of data want to be filtered
         * 
         * @return void
         */
        protected function secure_form($form)
        {
            foreach ($form as $key => $value)
            {
                $form[$key] = $this->secure_input($value);
            }
        }

    }
?>