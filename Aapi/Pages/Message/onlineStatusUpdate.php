<?php
$request = \Slim\Slim::getInstance()->request();
$data = json_decode($request->getBody());
$user_one = $data->uid;
$time = time();

try {
    $key = md5(SITE_KEY . $data->uid);
    if ($key == $data->token) {
        $db = getDB();
        $sql = "SELECT uid_fk from last_seen WHERE uid_fk = :uid_fk";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("uid_fk", $user_one, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->rowCount();

        if ($count < 1) {
            $sql1 = "INSERT INTO last_seen(uid_fk,last_update_timestamp,last_seen) VALUES (:uid_fk,NOW(),:last_seen)";
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("uid_fk", $user_one, PDO::PARAM_INT);
            $stmt1->bindParam("last_seen", $time, PDO::PARAM_STR);
            $stmt1->execute();
        } else {
            $sql4 = "UPDATE last_seen SET last_update_timestamp = NOW(), last_seen = :last_seen WHERE uid_fk = :uid_fk";
            $stmt4 = $db->prepare($sql4);
            $stmt4->bindParam("last_seen", $time, PDO::PARAM_STR);
            $stmt4->bindParam("uid_fk", $user_one, PDO::PARAM_INT);
            $stmt4->execute();
        }
        echo '{"updates": "insert"}';

        $db = null;
    }
} catch (PDOException $e) {
    echo '{"error":{"text":' . $e->getMessage() . '}}';
}