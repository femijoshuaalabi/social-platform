<?php
class View {
    
    public $check_for_parentName = '';
            
    function __construct() {
        //echo 'this is the view';
    }
    public function render($PageName,  $pageNameParam= '', $parentPage = ''){
        $this->check_for_parentName = $PageName;
        $PageUrl = 'public/' . $PageName . '/index.php';
        if(file_exists($PageUrl)){
            require 'public/' . $PageName . '/index.php';
        }else {
            $username = $PageName;
            try {
                $db = getDB();
                $sql = "SELECT username FROM users WHERE username = '$username'";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $mainCount = $stmt->rowCount();

                if($mainCount == 1){
                    $this->_controller = new PagesControl('profile');
                    $this->_controller->index();
                    $this->check_for_parentName = 'profile';
                }else{
                    require 'public/404/index.php';
                    exit();
                }

            } catch (PDOException $e) {
                require 'public/505/index.php';
                exit();
            }
        }
        
        if(isset($pageNameParam) && $pageNameParam !== ''){
           switch ($pageNameParam) {
              case 'photos': 
                  if($parentPage == $this->check_for_parentName){
                      
                    $PageUrl = 'public/' . $parentPage .'/'. $pageNameParam.'.php';
                    if(file_exists($PageUrl)){
                        require 'public/' . $parentPage .'/'. $pageNameParam.'.php';
                    }else {
                        echo '404 pages';
                    }
                    
                  }else{
                      echo '404 pages';
                  }
           } 
        }
    }

}