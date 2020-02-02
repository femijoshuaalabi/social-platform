<?php

/*****************************************************************************
                            AJUWAYA CONNECT API
*****************************************************************************/
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../config.php';
require 'AJYFunction/functions.php';
require 'AJYFunction/FunctionBuilder.php';
require 'AJYFunction/InternalFunctions.php';
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

/*****************************************************************************
                            INIT ROUTING
*****************************************************************************/

$app->post('/login', 'login'); /* User login */


$app->post('/signup', 'signup'); /* User Signup  */
$app->post('/usernameEmailCheck', 'usernameEmailCheck'); /* SignUp Check */ 
$app->post('/send_code_to_mail', 'send_code_to_mail'); /* send code to_mail */ 
$app->post('/ValidateEmailWithPin', 'ValidateEmailWithPin'); /* Validate Email With Pin */


$app->post('/conversationLists', 'conversationLists'); /* Message conversation List */
$app->post('/conversationReplies', 'conversationReplies'); /* Message conversation Replies */
$app->post('/ReplyConversation', 'ReplyConversation'); /* Reply Conversation */
$app->post('/istypingStatus', 'istypingStatus'); /* is typing  */
$app->post('/istypingStatusRemove', 'istypingStatusRemove'); /* is typing Remove  */
$app->post('/istypingStatusUpdate', 'istypingStatusUpdate'); /* is typing Update */

$app->run();




/*****************************************************************************
                                 LOGIN BLOCK
*****************************************************************************/

/* Login */
function login() {
    require 'Pages/Login/Login.php';
}

/*****************************************************************************
                                 REGISTRATION BLOCK
*****************************************************************************/

/* ### Username Check ### */
function usernameEmailCheck() {
    require 'Pages/Registration/usernameEmailCheck.php';
}

/* ### send_code_to_mail ### */
function send_code_to_mail() {
    require 'Pages/Registration/send_code_to_mail.php';
}

function ValidateEmailWithPin() {
    require 'Pages/Registration/ValidateEmailWithPin.php';
}

function signup() {
    require 'Pages/Registration/signup.php';
}


/*****************************************************************************
                                 MESSAGE BLOCK
*****************************************************************************/

/* Converstaions */
function conversationLists() {
    require 'Pages/Message/conversationLists.php';
}

/*Conversation Replies*/
function conversationReplies() {
    require 'Pages/Message/conversationReplies.php';
}

/*User Reply to Messages*/
function ReplyConversation(){
    require 'Pages/Message/ReplyConversation.php'; 
}

/*Is typing Status*/
function istypingStatus() {
    require 'Pages/Message/istypingStatus.php'; 
}

/*Remove is Typing*/
function istypingStatusRemove() {
    require 'Pages/Message/istypingStatusRemove.php';
}

function istypingStatusUpdate() {
    require 'Pages/Message/istypingStatusUpdate.php';
}





