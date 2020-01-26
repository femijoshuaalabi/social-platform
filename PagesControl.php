<?php
class PagesControl extends Controller {
    
    public $PageName = '';
    
    public $check_if_profile = '';
            
    function __construct($PageName) {
        parent::__construct();
        $this->PageName = $PageName;
        $this->check_if_profile = $this->view->check_if_profile;
        $this->_requestURL = new Http();
        $exclude_session = ['','index','login','register','contact-us'];
        if (!in_array($this->_requestURL->getURL()[0], $exclude_session)) {
            $userSession = new UserSession();
            $this->view->sessionUsername = $userSession->sessionUsername;
            $this->view->sessionUid = $userSession->sessionUid;
            $this->view->sessionName = $userSession->sessionName;
            $this->view->sessionToken = $userSession->sessionToken;
            $this->view->public_username = $userSession->public_username;
            if($PageName == 'profile'){
                $this->view->public_username = $this->_requestURL->getURL()[0];
            }
        }
    }


    public function index(){
       $this->view->render($this->PageName.'/index');
    }

    /*****************************************************************************
                            PAGES QUERIES DECLARATION BELOW
    *****************************************************************************/

    //LOGIN QUERIES START HERE
    public function login_error($param1 = null, $param2 = null,$param3 = null){
        $this->view->render($this->PageName.'/error');
    }
    //LOGIN QUERIES ENDS HERE

    public function getMessages($param1 = null, $param2 = null,$param3 = null){
        $this->view->render($this->PageName.'/getMessages');
    }

    //PROFILE QUERIES START HERE
    public function profile_photos($param1 = null, $param2 = null,$param3 = null){
        $this->view->render($this->PageName.'/photos');
    }
    //PROFILE QUERIES ENDS HERE
}