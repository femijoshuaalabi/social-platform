<?php
class PagesControl extends Controller {
    
    public $PageName = '';
    
    public $check_if_profile = '';
            
    function __construct($PageName) {
        parent::__construct();
        $this->PageName = $PageName;
        $this->check_if_profile = $this->view->check_if_profile;
        echo $this->check_if_profile;
    }
    public function index(){
       $this->view->render($this->PageName);
    }
    
    public function photos($param1 = null, $param2 = null,$param3 = null){
        $this->view->render($this->PageName,'photos','profile');
    }
}