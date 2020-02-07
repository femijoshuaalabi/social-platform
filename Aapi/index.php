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
    
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());

    //$data->uid = 1;
    $data->last_time = '';
    $data->conversation_uid = '';
    //$data->token = '2b8ce5597e34dadfabd7d239901c3765';

    $uid=$data->uid;
    $last_time=$data->last_time;
    $conversation_uid=$data->conversation_uid;


    /* More Records*/
    $morequery="";
    if($last_time)
    {
        $morequery=" and c.time<'".$last_time."' ";
    }
    /* More Button End*/

    try {
        $key=md5(SITE_KEY.$data->uid);
        if($key==$data->token)
        {
            $db = getDB();
            $sql = "SELECT DISTINCT u.uid,c.c_id,u.name,u.profile_pic,u.username,u.email,c.time
            FROM conversation c, users u, conversation_reply r
            WHERE CASE
            WHEN c.user_one = :user_one
            THEN c.user_two = u.uid
            WHEN c.user_two = :user_one
            THEN c.user_one= u.uid
            END
            AND (
            c.user_one =:user_one
            OR c.user_two =:user_one
            ) AND u.status=:status AND c.c_id=r.c_id_fk AND u.uid<>:conversation_uid AND r.user_id_fk<>:conversation_uid AND r.read_status = 1
            $morequery ORDER BY c.time DESC LIMIT 15";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("user_one", $uid,PDO::PARAM_INT);
            $stmt->bindParam("conversation_uid", $conversation_uid);
            $status='1';
            $stmt->bindParam("status", $status);
            $stmt->execute();
            $conversations = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            $count=count($conversations);
            for($z=0;$z<$count;$z++)
            {
                /* TimeAgo */
                $n_time=$conversations[$z]->time;
                $conversations[$z]->timeAgo=date("c", $n_time);
                
                /*Username Check*/
                if(empty($conversations[$z]->name))
                {
                    $conversations[$z]->name=$conversations[$z]->username;
                    
                }
                /*ProfilePic Check*/
                $conversations[$z]->profile_pic=profilePic($conversations[$z]->profile_pic);
                $conversations[$z]->unreadMessageCount=internalConversationUnreadMessage($conversations[$z]->c_id,$data->uid);
                $conversations[$z]->lastReply=internalConversationLast($conversations[$z]->c_id);
            }
            
            $db = null;
            echo '{"conversations": ' . json_encode($conversations) . '}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

/*Conversation Replies*/
function conversationReplies() {
    require 'Pages/Message/conversationReplies.php';
}

function conversationNewReplies() {
    require 'Pages/Message/conversationNewReplies.php';
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
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $uid = $data->uid;
    $fid = $data->fid;

    try {
        $key = md5(SITE_KEY . $data->uid);
        if ($key == $data->token && $uid > 0) {

            $db = getDB();
            $role = "fri";
            $time = time();
            $sql = "SELECT friend_id FROM friends WHERE friend_one=:uid AND friend_two=:fid AND role=:role";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("uid", $uid, PDO::PARAM_INT);
            $stmt->bindParam("fid", $fid, PDO::PARAM_INT);
            $stmt->bindParam("role", $role, PDO::PARAM_STR);
            $stmt->execute();

            $count = $stmt->rowCount();
            if ($count == 0 && $uid > 0 && $fid > 0 && $uid != $fid) {
                $sql1 = "INSERT INTO friends(friend_one,friend_two,role,created) VALUES (:uid,:fid,:role,:time)";
                $stmt1 = $db->prepare($sql1);
                $stmt1->bindParam("uid", $uid, PDO::PARAM_INT);
                $stmt1->bindParam("fid", $fid, PDO::PARAM_INT);
                $stmt1->bindParam("role", $role, PDO::PARAM_STR);
                $stmt1->bindParam("time", $time);
                $stmt1->execute();
                $sql2 = "UPDATE users SET friend_count=friend_count+1 WHERE uid=:uid";
                $stmt2 = $db->prepare($sql2);
                $stmt2->bindParam("uid", $uid, PDO::PARAM_INT);
                $stmt2->execute();

                $db = null;
                echo '{"friend": [{"status":"1"}]}';


                $mainUserDetails = internalUserDetails($uid);
                $mainUser = $mainUserDetails[0]->name;
                $mainUsername = $mainUserDetails[0]->username;

                $followUserDetails = internalUserDetails($fid);
                $to = $followUserDetails[0]->email;

                $followName = $followUserDetails[0]->name;
                $followUser = $followUserDetails[0]->username;
                $messageUid = $followUserDetails[0]->uid;
                $emailNotifications = $followUserDetails[0]->emailNotifications;
                $applicationName = SITE_NAME;
                if (SMTP_CONNECTION > 0 && $uid != $fid && $emailNotifications > 0) {
                    $friendLink = BASE_URL . $mainUsername;
                    $subject = $mainUser . ' is now following you on ' . $applicationName;
                    $body = "Hello " . $followName . ",<br/> <br/>" . $mainUser . " is now following you on " . $applicationName . ". <br/><br/><a href='" . $friendLink . "'>Profile Link</a><br/><br/>Support
                    <br/>" . $applicationName . "<br/>" . BASE_URL . "<br/><br/>
                    You are receiving this because you are subscribed to notifications on our website.
                    <a href='" . BASE_URL . "settings.php'>Edit your email alerts</a>";

                    sendMail($to, $subject, $body);
                }
            }
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function friendsList() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $page = $data->page;
    $rowsPerPage = $data->rowsPerPage;


    if ($page) {
        //$page=$page+1;
        $offset = ($page - 1) * $rowsPerPage;
        $con = $offset . "," . $rowsPerPage;
    } else {
        $con = $rowsPerPage;
    }

    $public_uid = $data->uid;
    $username = $data->username;

    /* Public Username Check */
    if ($data->username) {
        $public_uid = internalUsernameDetails($data->username);
    } else {
        $public_uid = $data->uid;
    }

    $sql = "SELECT '' as status,U.username,U.name,U.uid,U.email,U.profile_pic,U.present_state,U.present_lga,U.occupation FROM users U, friends F WHERE U.status='1' AND U.uid=F.friend_two AND F.friend_one=:uid AND F.role='fri' ORDER BY F.friend_id DESC LIMIT $con";
    try {
        $key = md5(SITE_KEY . $data->uid);
        if ($key == $data->token) {

            $db = getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("uid", $public_uid, PDO::PARAM_INT);
            $stmt->execute();
            $friendsList = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            $friendsListCount = count($friendsList);
            for ($z = 0; $z < $friendsListCount; $z++) {
                $friendsList[$z]->role = internalFriendsCheck($data->uid, $friendsList[$z]->uid);
                $friendsList[$z]->profile_pic = profilePic($friendsList[$z]->profile_pic);
                if (empty($friendsList[$z]->name)) {
                    $friendsList[$z]->name = $friendsList[$z]->username;
                }
            }
            echo '{"friendsList": ' . json_encode($friendsList) . '}';
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}


/*****************************************************************************
                                FILE UPLOADS
*****************************************************************************/

function feedImageUpload() {
    $request = \Slim\Slim::getInstance()->request();
    $x = $request->post();


    try {
        $uploadUid = $_POST['update_uid'];
        $token = $_POST['update_token'];
        $upload_types = $_POST['upload_types'];
        $time = time();
        $key = md5(SITE_KEY . $uploadUid);


        if ($key == $token) {
            $upload_path = '../' . UPLOAD_PATH;
            $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP","mp4","3gp");
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
                                        echo '<img src="' . BASE_URL . UPLOAD_PATH . $actual_image_name . '"  class="preview" style="display:none;" id="' . $v . '"/><video class="player preview" id="" poster="" playsinline controls>'.
                                        '<source src="' . BASE_URL . UPLOAD_PATH . $actual_image_name . '" type="video/mp4" />'.
                                        '</video>';
                                    }else{
                                        echo '<div class="MessageUploadPreview" id="MessageUploadPreview'.$v.'"><img src="' . BASE_URL . UPLOAD_PATH . $actual_image_name . '"  class="preview" id="' . $v . '"/><div class="MessageUploadDelete" id="photo' . $v . '"><a href="#"><i class="mdi mdi-delete"></i></a></div></div>';
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














