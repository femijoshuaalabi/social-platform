<?php

class Bootstarp {
    
    public $_requestURL = '';
    public $_pageName = '';

    public function __construct(){
       $this->_requestURL = new Http();
    }
    
    public function Distribution(){
        $this->_loadInBuiltController();
        $this->_callControllerMethod();
    }
    
    private function _loadInBuiltController() {
        $getURL = $this->_requestURL->getURL()[0];
        $PageUrl = 'public/' . $getURL . '/index.php';
        require 'PagesControl.php';
        if(file_exists($PageUrl)){
            /*****************************************************************************
                                    SET SESSION FOR URL QUERIES
            *****************************************************************************/
            if($this->_requestURL->getURL()[0] == 'message'){
                $_SESSION['public_username'] = $this->_requestURL->getURL()[1];
            }
            if(empty($this->_requestURL->getURL()[0]) || $this->_requestURL->getURL()[0] == 'index'){
                $getURL = 'index';
            }
           $this->_controller = new PagesControl($getURL);
           $this->_pageName = $this->_requestURL->getURL()[0];
        }else{
            $username = $this->_requestURL->getURL()[0];
            try {
                $db = getDB();
                $sql = "SELECT username FROM users WHERE username = '$username'";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $mainCount = $stmt->rowCount();

                if($mainCount == 1){
                    if($this->_requestURL->getURL()[0] !== $_SESSION['username']){
                        $_SESSION['public_username'] = $this->_requestURL->getURL()[0];
                    }
                    $this->_controller = new PagesControl('profile');
                    $this->_pageName = 'profile';
                }else{
                    require 'public/404/index.php';
                    exit();
                }

                $db = null;

            } catch (PDOException $e) {
                require 'public/505/index.php';
                exit();
            }
        }
    }
    
     private function _callControllerMethod() {
        $length = count($this->_requestURL->getURL());
        if ($length > 1) {

            $page = $this->_pageName;
            $pageMethod = $page .'_'. $this->_requestURL->getURL()[1];

            if (!method_exists($this->_controller, $this->_pageName.'_'.$this->_requestURL->getURL()[1])) {
                if($page == 'message'){
                    $pageMethod = 'getMessages';
                }else {
                    header("location:".BASE_URL .'404.php');
                    exit;
                }
                
            }
        }

        switch ($length) {
            case 9:
                $this->_controller->{$pageMethod}($this->_requestURL->getURL()[2], $this->_requestURL->getURL()[3], $this->_requestURL->getURL()[4], $this->_requestURL->getURL()[5], $this->_requestURL->getURL()[6],$this->_requestURL->getURL()[7], $this->_requestURL->getURL()[7]);
                break;
            case 8:
                $this->_controller->{$pageMethod}($this->_requestURL->getURL()[2], $this->_requestURL->getURL()[3], $this->_requestURL->getURL()[4], $this->_requestURL->getURL()[5], $this->_requestURL->getURL()[6],$this->_requestURL->getURL()[7]);
                break;
            case 7:
                $this->_controller->{$pageMethod}($this->_requestURL->getURL()[2], $this->_requestURL->getURL()[3], $this->_requestURL->getURL()[4], $this->_requestURL->getURL()[5], $this->_requestURL->getURL()[6]);
                break;
            case 6:
                $this->_controller->{$pageMethod}($this->_requestURL->getURL()[2], $this->_requestURL->getURL()[3], $this->_requestURL->getURL()[4], $this->_requestURL->getURL()[5]);
                break;
            case 5:
                $this->_controller->{$pageMethod}($this->_requestURL->getURL()[2], $this->_requestURL->getURL()[3], $this->_requestURL->getURL()[4]);
                break;
            case 4:
                $this->_controller->{$pageMethod}($this->_requestURL->getURL()[2], $this->_requestURL->getURL()[3]);
                break;
            case 3:
                $this->_controller->{$pageMethod}($this->_requestURL->getURL()[2]);
                break;
            case 2:
                $this->_controller->{$pageMethod}();
                break;
            default:
                $this->_controller->index();
                break;
        }
    }


}


?>