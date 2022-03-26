<?php
    /**
     * Class gets the url requested by the user
     */
    class Request
    {
        public $url;

        public function __construct()
        {
            $this->url = $_SERVER["REQUEST_URI"];
        }
    }

?>