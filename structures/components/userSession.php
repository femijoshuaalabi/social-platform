<?php
session_start();

class UserSession{

    public $sessionUid;
    public $sessionToken;
    public $sessionUsername;
    public $username;
    public $sessionName;
    public $public_username;

    function __construct(){

        $this->sessionUid=$_SESSION['uid']; 
        $this->sessionToken=$_SESSION['token']; 
        $this->sessionUsername=$_SESSION['username']; 
        $this->username=$_SESSION['username']; 
        $this->sessionName=$_SESSION['name'];

        // Session Private
        $this->public_username='';
        if(isset($_SESSION['public_username']) || isset($_SESSION['msgID'])){
            $this->public_username=$_SESSION['public_username']; 
            $this->username=$_SESSION['public_username']; 
        }else if(empty($this->sessionUid)){
            $url= BASE_URL.'login';
            header("location:$url");
        }

        if(isset($_GET['username'])){
            $this->public_username=$_GET['username']; 
            $this->username=$_GET['username']; 
        }
    }
}
?>


