<?php

class Core{

    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];


    public function __construct()
    {
        //print_r($this->getUrl());

        $url = $this->getUrl();

        if(file_exists('../app/controllers/'.ucwords($url[0]).'.php')){

            // if exist set as current controller

            $this->currentController = ucwords($url[0]);

            //unset 0 index

            unset($url[0]);
        }

        //require the contoller

        require_once('../app/controllers/'.$this->currentController.'.php');

        //instanciate the controller class

        $this->currentController = new $this->currentController;

        // check for the second part of the url

        if(isset($url[1])){

            if(method_exists($this->currentController,$url[1])){

                $this->currentMethod  = $url[1];
                unset($url[1]);
            }
        }

        //Get Parameter

        $this->params = $url?array_values($url):[];

        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

    }

    public function getUrl(){

        if(isset($_GET['url'])){

            $url = rtrim($_GET['url'],'/');
            $url = filter_var($url,FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url;
        }
    }


}



?>