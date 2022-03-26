<?php

class Dispatcher
{
    /** @var Request the request user sent to the server */
    private $request;


    /**
     * Calls the action needed from specific controller user requested
     */
    public function dispatch()
    {
        $this->request = new Request();
        Router::parse($this->request->url, $this->request);

        $controller = $this->loadController();

        call_user_func_array([$controller, $this->request->action], $this->request->params);
    }


    /**
     * Loads the controller file from its name
     * 
     * @return Controller the right controller user requested
     */
    public function loadController()
    {
        $name = $this->request->controller . "Controller";
        $file = ROOT . 'Controllers/' . $name . '.php';
        require($file);
        $controller = new $name();
        return $controller;
    }

}
?>