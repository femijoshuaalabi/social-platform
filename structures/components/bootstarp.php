<?php

class Bootstarp {

    private $_controllerPath = 'page_controller/';
    private $_errorFile = 'error.php';
    private $_defaultFile = 'index.php';
    
    public $_requestURL = '';

    public function __construct(){
       $this->_requestURL = new Http();
    }
    
    public function Distribution(){
        $this->_loadInBuiltController();
        $this->_callControllerMethod();
    }
    
    private function _loadInBuiltController() {
        $getURL = $this->_requestURL->getURL()[0];
        if(file_exists('PagesController.php')){
            require 'PagesController.php';
             if(empty($this->_requestURL->getURL()[0]) || $this->_requestURL->getURL()[0] == 'index'){
                 $getURL = 'index';
             }
            $this->_controller = new PagesControl($getURL);
        }
    }
    
     private function _callControllerMethod() {
        $length = count($this->_requestURL->getURL());
        if ($length > 1) {
            if (!method_exists($this->_controller, $this->_requestURL->getURL()[1])) {
                header("location:".BASE_URL .'404.php');
                exit;
            }
        }

        switch ($length) {
            case 9:
                $this->_controller->{$this->_requestURL->getURL()[1]}($this->_requestURL->getURL()[2], $this->_requestURL->getURL()[3], $this->_requestURL->getURL()[4], $this->_requestURL->getURL()[5], $this->_requestURL->getURL()[6],$this->_requestURL->getURL()[7], $this->_requestURL->getURL()[7]);
                break;
            case 8:
                $this->_controller->{$this->_requestURL->getURL()[1]}($this->_requestURL->getURL()[2], $this->_requestURL->getURL()[3], $this->_requestURL->getURL()[4], $this->_requestURL->getURL()[5], $this->_requestURL->getURL()[6],$this->_requestURL->getURL()[7]);
                break;
            case 7:
                $this->_controller->{$this->_requestURL->getURL()[1]}($this->_requestURL->getURL()[2], $this->_requestURL->getURL()[3], $this->_requestURL->getURL()[4], $this->_requestURL->getURL()[5], $this->_requestURL->getURL()[6]);
                break;
            case 6:
                $this->_controller->{$this->_requestURL->getURL()[1]}($this->_requestURL->getURL()[2], $this->_requestURL->getURL()[3], $this->_requestURL->getURL()[4], $this->_requestURL->getURL()[5]);
                break;
            case 5:
                $this->_controller->{$this->_requestURL->getURL()[1]}($this->_requestURL->getURL()[2], $this->_requestURL->getURL()[3], $this->_requestURL->getURL()[4]);
                break;
            case 4:
                $this->_controller->{$this->_requestURL->getURL()[1]}($this->_requestURL->getURL()[2], $this->_requestURL->getURL()[3]);
                break;
            case 3:
                $this->_controller->{$this->_requestURL->getURL()[1]}($this->_requestURL->getURL()[2]);
                break;
            case 2:
                $this->_controller->{$this->_requestURL->getURL()[1]}();
                break;
            default:
                $this->_controller->index();
                break;
        }
    }


}


?>