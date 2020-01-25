<?php

/*****************************************************************************
                            AJUWAYA CONNECT API
*****************************************************************************/

require '../config.php';
require 'AJYFunction/functions.php';
require 'AJYFunction/FunctionBuilder.php';
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

/*****************************************************************************
                            INIT ROUTING
*****************************************************************************/

$app->post('/login', 'login'); /* User login */

$app->run();






/*****************************************************************************
                           INTERNAL FUNCTION
*****************************************************************************/
function configurations() {
    $sql = "SELECT language_labels,applicationName,applicationDesc,forgot,newsfeedPerPage,friendsPerPage,photosPerPage,groupsPerPage,notificationPerPage, uploadImage,bannerWidth, profileWidth,gravatar,friendsWidgetPerPage,upload FROM configurations WHERE con_id='1' ";
    try {
        $db = getDB();
        $stmt = $db->query($sql);
        $configuration = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        return $configuration;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function internalProfilePicUpload($uid, $image) {

    try {
        if ($uid > 0) {
            $db = getDB();
            $sql = "UPDATE users SET profile_pic=:image,profile_pic_status=:status WHERE uid=:uid";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("image", $image, PDO::PARAM_STR);
            $stmt->bindParam("uid", $uid, PDO::PARAM_INT);
            $status = '1';
            $stmt->bindParam("status", $status);
            $stmt->execute();


            $sql1 = "INSERT INTO user_uploads (image_path,uid_fk,image_type) VALUES (:image,:uid,:status)";
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("image", $image, PDO::PARAM_STR);
            $stmt1->bindParam("uid", $uid, PDO::PARAM_INT);
            $status = '2';
            $stmt1->bindParam("status", $status);
            $stmt1->execute();

            $sql2 = "SELECT uid,profile_pic FROM users WHERE uid=:uid";
            $stmt2 = $db->prepare($sql2);
            $stmt2->bindParam("uid", $uid, PDO::PARAM_INT);
            $stmt2->execute();

            $profileBGImageUpload = $stmt2->fetchAll(PDO::FETCH_OBJ);
            $db = null;

            return $profileBGImageUpload;
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}



/*****************************************************************************
                            API STUCTURES
*****************************************************************************/

//Login Function
function login() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    //$data->username = 'femicontact';
    //$data->password = 'webhost123';

    try {
        $db = getDB();
        $sql = "SELECT uid,notification_created,username,name,profile_pic,tour FROM users WHERE (username=:username or email=:username) and password=:password AND status='1' ";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("username", $data->username, PDO::PARAM_STR);
        $password = md5($data->password);
        $stmt->bindParam("password", $password, PDO::PARAM_STR);
        $stmt->execute();
        $mainCount = $stmt->rowCount();
        $login = $stmt->fetchAll(PDO::FETCH_OBJ);
        if (!empty($login)) {
            $uid = $login[0]->uid;
            $key = SITE_KEY . $uid;
            $login[0]->token = md5($key);
            $notification_created = $login[0]->notification_created;
            if ($mainCount == 1) {
                $photos_query = $db->query("SELECT id FROM user_uploads WHERE uid_fk='$uid' and group_id_fk='0'");
                $photos_count = $photos_query->rowCount(); /* Photos Count */
                $updates_query = $db->query("SELECT msg_id FROM messages WHERE uid_fk='$uid' and group_id_fk='0'");
                $updates_count = $updates_query->rowCount(); /* Updates Count */
                $time = time();
                $updates_query = $db->query("UPDATE users SET last_login='$time',photos_count='$photos_count',updates_count='$updates_count' WHERE uid='$uid'");

                if (empty($notification_created)) {
                    /* Last login update */
                    $db->query("UPDATE users SET notification_created='$time' WHERE uid='$uid'") or die(mysqli_error($this->db));
                }
            }
        }
        $db = null;
        /* Username Modification */
        if ($login[0]->name) {
            $name = htmlCode($login[0]->name);
        } else {
            $name = $login[0]->username;
        }

        $login[0]->name = $name;
        /* Profile Pic Modification */
        if ($login) {
            $login[0]->profile_pic = profilePic($login[0]->profile_pic);
            $login[0]->configurations = configurations();
        }

        echo '{"login": ' . json_encode($login) . '}';
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}