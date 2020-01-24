<?php
class Http{
     function __construct() {
         
    }
    public function getURL() {
        $this->get_url = isset($_GET['url']) ? $_GET['url'] : null;
        $this->get_url = rtrim($this->get_url, '/');
        $this->get_url = filter_var($this->get_url, FILTER_SANITIZE_URL);
        $this->_url = explode('/', $this->get_url);
        return $this->_url;
    }
}