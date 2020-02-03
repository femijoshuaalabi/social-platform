<?php

$request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $message_user = $data->message_user;
    $user_two = internalUsernameDetails($message_user);

    try {
        $key = md5(SITE_KEY . $data->uid);
        if ($message_user) {
            $db = getDB();
            $sql = "SELECT * from last_seen WHERE uid_fk = :uid_fk AND TIMESTAMPDIFF(SECOND, last_update_timestamp, NOW()) < 5;";
            $stmt6 = $db->prepare($sql);
            $stmt6->bindParam("uid_fk", $user_two, PDO::PARAM_INT);
            $stmt6->execute();
            $count = $stmt6->rowCount();
            $online = '';
            if ($count > 0) {
                echo '{"updates": "Yes"}';
            } else {
                $sql = "SELECT * from last_seen WHERE uid_fk = :uid_fk";
                $stmt = $db->prepare($sql);
                $stmt->bindParam("uid_fk", $user_two, PDO::PARAM_INT);
                $stmt->execute();
                $onlineStatus = $stmt->fetchAll(PDO::FETCH_OBJ);
                echo '{"updates": ' . json_encode($onlineStatus) . '}';
            }
            $db = null;
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }