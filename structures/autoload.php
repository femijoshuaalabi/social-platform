<?php
spl_autoload_register(function($class){
    require "structures/components/" . $class .".php";
});

