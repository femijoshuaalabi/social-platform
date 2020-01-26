<?php
class View {
    
    public $check_for_parentName = '';
            
    function __construct() {
        //echo 'this is the view';
    }
    public function render($PageName,  $pageNameParam= '', $parentPage = ''){
        $this->check_for_parentName = $PageName;
        $PageUrl = 'public/' . $PageName . '.php';
        if(file_exists($PageUrl)){
            require 'public/' . $PageName . '.php';
        }else{
            require 'public/404/index.php';
            exit();
        }
    }
}