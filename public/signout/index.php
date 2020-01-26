<?php
session_start();
$_SESSION['uid']='';
$_SESSION['token']='';
$userData='';
if(session_destroy())
{
$url= BASE_URL.'login';
header("Location: $url");
echo "<script>window.location='$url'</script>";
}
?>