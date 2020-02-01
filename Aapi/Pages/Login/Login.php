<?php

$request = \Slim\Slim::getInstance()->request();
$data = json_decode($request->getBody());
//$data->username = 'ajuwaya1';
//$data->password = 'webhost123';

try {
    $db = getDB();
    $sql = "SELECT uid,notification_created,username,name,profile_pic,tour FROM users WHERE (username=:username or email=:username) and password=:password ";
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
?>