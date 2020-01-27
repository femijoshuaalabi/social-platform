<?php

/*****************************************************************************
                            AJUWAYA CONNECT API
*****************************************************************************/

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

$app->post('/conversationLists', 'conversationLists'); /* Message conversation List */

$app->run();




/*****************************************************************************
                            API STUCTURES
*****************************************************************************/

/* Login */
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





/* Converstaions */
function conversationLists() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());

    // $data->uid = 475;
    // $data->last_time = '';
    // $data->conversation_uid = '';
    // $data->token = '2b8ce5597e34dadfabd7d239901c3765';

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
            ) AND u.status=:status AND c.c_id=r.c_id_fk AND u.uid<>:conversation_uid
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
                $conversations[$z]->lastReply=internalConversationLast($conversations[$z]->c_id);
                
            }
            
            $db = null;
            echo '{"conversations": ' . json_encode($conversations) . '}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
    
}

