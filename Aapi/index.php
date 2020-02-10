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
$app->post('/NewConversationLists', 'NewConversationLists'); /* Message conversation List */ 
$app->post('/conversationReplies', 'conversationReplies'); /* Message conversation Replies */
$app->post('/conversationNewReplies', 'conversationNewReplies'); /* Conversation New Replies */
$app->post('/ReplyConversation', 'ReplyConversation'); /* Reply Conversation */
$app->post('/messageSearchFriend', 'messageSearchFriend'); /* Reply Conversation */

$app->post('/istypingStatus', 'istypingStatus'); /* is typing  */
$app->post('/istypingStatusRemove', 'istypingStatusRemove'); /* is typing Remove  */
$app->post('/istypingStatusUpdate', 'istypingStatusUpdate'); /* is typing Update */ 
$app->post('/onlineStatus', 'onlineStatus'); /* online Status */ 

$app->post('/friendsList', 'friendsList'); /* User friends List */
$app->post('/suggestedFriends', 'suggestedFriends'); /* Suggested Friends */  
$app->post('/addFriend', 'addFriend'); /* Add Friend */

$app->post('/feedImageUpload', 'feedImageUpload'); /* Feed Image Upload */
$app->post('/deletePhoto', 'deletePhoto'); /* Feed Image Upload */

$app->post('/onlineStatusUpdate', 'onlineStatusUpdate'); /* online Status Update */ 

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

function NewConversationLists(){
    require 'Pages/Message/NewConversationLists.php';
}

/*Conversation Replies*/
function conversationReplies() {
    require 'Pages/Message/conversationReplies.php';
}

function conversationNewReplies() {
    require 'Pages/Message/conversationNewReplies.php';
}

function messageSearchFriend(){
    require 'Pages/Message/messageSearchFriend.php';
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

function onlineStatusUpdate() {
    require 'Pages/Message/onlineStatusUpdate.php';
}

function onlineStatus() {
    require 'Pages/Message/onlineStatus.php';
}

/*****************************************************************************
                                 NEWSFEED FUNCTION
*****************************************************************************/

function suggestedFriends() {
    require 'Pages/Networks/suggestedFriends.php';
}

function addFriend() {
    require 'Pages/Networks/addFriend.php';
}

function friendsList() {
    require 'Pages/Networks/friendsList.php';
}


/*****************************************************************************
                                FILE UPLOADS
*****************************************************************************/

function feedImageUpload() {
    $request = \Slim\Slim::getInstance()->request();
    $x = $request->post();


    try {
        $uploadUid = 1;
        $token = $_POST['update_token'];
        $upload_types = $_POST['upload_types'];
        $time = time();
        $key = md5(SITE_KEY . $uploadUid);


        if ($key == $token) {
            $upload_path = '../' . UPLOAD_PATH;
            $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP","mp4","3gp","mp3","pdf","sql");
            $group_id = $_POST['group_id'];
            $conversationImage = $_POST['conversationImage'];
            if (empty($group_id)) {
                $group_id = '';
            }
            if (empty($conversationImage)) {
                $conversationImage = '';
            }

            $v = '';
            $i = 1;

            $user_id = (string) $x['update_uid'];
            if ($user_id > 0) {
                foreach ($_FILES['photos']['name'] as $name => $value) {
                    $filename = stripslashes($_FILES['photos']['name'][$name]);
                    $size = filesize($_FILES['photos']['tmp_name'][$name]);
                    //get the extension of the file in a lower case format
                    $ext = getExtension($filename);
                    $ext = strtolower($ext);
                    if (in_array($ext, $valid_formats)) {
                        $configurations = configurations();
                        $uploadImage = $configurations[0]->uploadImage;
                        //$uploadImageSize;
                        if ($size < (8000 * $uploadImage)) {

                            $actual_image_name = 'user' . $user_id . '_' . time() . $i . "." . $ext;
                            $uploadedfile = $_FILES['photos']['tmp_name'][$name];
                            $newwidth = $configurations[0]->upload;
                            $filename = compressImage($ext, $uploadedfile, $upload_path, $actual_image_name, $newwidth);
                            //if(move_uploaded_file($_FILES['photos']['tmp_name'][$name], $upload_path.$actual_image_name))
                            if ($filename) {
                                if(isset($upload_types)){
                                    internalImageUpload($user_id, $actual_image_name, $group_id, $conversationImage,$upload_types);
                                }else{
                                    internalImageUpload($user_id, $actual_image_name, $group_id, $conversationImage);
                                }
                                $newdata = internalGetUploadImage($user_id, $actual_image_name);

                                if ($newdata) {
                                    if (empty($v)){
                                        $v = $newdata[0]->id;
                                    }else {
                                        $v = $newdata[0]->id;
                                    }
                                    $explode = explode('.', $actual_image_name);
                                    if($explode[1] == 'mp4'){
                                        echo '<div class="MessageUploadPreview image-area" id="MessageUploadPreview'.$v.'">' .
                                                '<video class="media-content" id="" poster="" playsinline controls>'.
                                                '<source src="' . BASE_URL . UPLOAD_PATH . $actual_image_name . '" type="video/mp4" />'.
                                                '</video>'.
                                                '<a class="remove-image MessageUploadDelete" id="photo' . $v . '" style="display: inline;">&#215;</a>' .
                                            '</div>';
                                    }elseif($explode[1] == 'mp3'){
                                        echo '<div class="MessageUploadPreview image-area" id="MessageUploadPreview'.$v.'">' .
                                               '<audio class="media-content" controls>' .
                                                '<source src="' . BASE_URL . UPLOAD_PATH . $actual_image_name . '" type="audio/ogg">'.
                                                '<source src="' . BASE_URL . UPLOAD_PATH . $actual_image_name . '" type="audio/mpeg">'.
                                                '</audio>'.
                                                '<a class="remove-image MessageUploadDelete" id="photo' . $v . '" style="display: inline;">&#215;</a>' .
                                            '</div>';
                                    }elseif($explode[1] == 'jpg' || $explode[1] == 'png'){
                                        echo '<div class="MessageUploadPreview image-area" id="MessageUploadPreview'.$v.'">' .
                                                '<img class="media-content" src="' . BASE_URL . UPLOAD_PATH . $actual_image_name . '"  alt="'.$actual_image_name.'" id="' . $v . '" />' .
                                                '<a class="remove-image MessageUploadDelete" id="photo' . $v . '" style="display: inline;">&#215;</a>' .
                                            '</div>';
                                   }else {
                                    echo '<div class="MessageUploadPreview image-area" id="MessageUploadPreview'.$v.'">' .
                                            '<div class="media-content"><p>File Uploaded</p></div>'.
                                            '<a class="remove-image MessageUploadDelete" id="photo' . $v . '" style="display: inline;">&#215;</a>' .
                                        '</div>';
                                   }
                                }
                            }
                            else {
                                echo "Fail upload fail.";
                            }
                        } else {
                            echo '<span class="imgList">You have exceeded the size limit!</span>';
                        }
                    } else {
                        echo '<span class="imgList">Unknown extension!</span>';
                    }
                    $i = $i + 1;
                }
            }
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

/* Delete Photo */

function deletePhoto() {

    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $uid = $data->uid;
    $pid = $data->pid;
    $group_id = $data->group_id;
    $photo_uid = $data->photo_uid;
    $group_owner_id = internalGroupOwner($group_id);

    try {
        $key = md5(SITE_KEY . $uid);
        if ($key == $data->token) {
            $db = getDB();
            if ($group_owner_id == $uid) {
                $uid = $photo_uid;
            }

            if (empty($group_id)) {
                $sql1 = "UPDATE users SET photos_count=photos_count-1 WHERE uid=:uid";
                $stmt1 = $db->prepare($sql1);
                $stmt1->bindParam("uid", $uid, PDO::PARAM_INT);
                $stmt1->execute();
            }

            $sql = "SELECT id,image_path FROM user_uploads U WHERE id=:pid AND uid_fk=:uid";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("uid", $uid, PDO::PARAM_INT);
            $stmt->bindParam("pid", $pid, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->rowCount();

            if ($count > 0) {

                $data = $stmt->fetchAll(PDO::FETCH_OBJ);
                $final_image = "../" . UPLOAD_PATH . $data[0]->image_path;

                unlink($final_image);

                $sql1 = "SELECT uploads,msg_id FROM messages WHERE uid_fk=:uid AND uploads!=0 AND  uploads LIKE :searchID";
                $stmt1 = $db->prepare($sql1);
                $stmt1->bindParam("uid", $uid, PDO::PARAM_INT);
                $searchID = "%" . $pid . "%";
                $stmt1->bindParam("searchID", $searchID, PDO::PARAM_STR);
                $stmt1->execute();
                $photoResult = $stmt1->fetchAll(PDO::FETCH_OBJ);
                $msgid = $photoResult[0]->msg_id;
                $str = $photoResult[0]->uploads;

                $tmp = explode(",", $str);
                $key = array_search($pid, $tmp);
                if ($key) {
                    $tmp[$key] = null;
                }
                $tmp = array_filter($tmp);
                $newSet = implode(",", $tmp);
                $newSet = (string) $newSet;

                if ($newSet == $str) {
                    $pattern = '/(\,)?' . $pid . '(\,)?/i';
                    $newSet = preg_replace($pattern, '', $str);
                }

                if (strlen($newSet) == 0) {
                    $newSet = '';
                }

                $sql2 = "UPDATE messages SET uploads=:newSet WHERE msg_id=:msgid and uid_fk=:uid";
                $stmt2 = $db->prepare($sql2);
                $stmt2->bindParam("uid", $uid, PDO::PARAM_INT);
                $stmt2->bindParam("msgid", $msgid, PDO::PARAM_INT);
                $stmt2->bindParam("newSet", $newSet, PDO::PARAM_STR);
                $stmt2->execute();

                $sql3 = "DELETE FROM user_uploads WHERE id=:pid AND uid_fk=:uid";
                $stmt3 = $db->prepare($sql3);
                $stmt3->bindParam("uid", $uid, PDO::PARAM_INT);
                $stmt3->bindParam("pid", $pid, PDO::PARAM_INT);
                $stmt3->execute();


                $db = null;
                echo '{"deletePhoto": [{"status":"1"}]}';
            }
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}














