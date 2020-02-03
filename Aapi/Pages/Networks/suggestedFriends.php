<?php

$request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());

    $sql = "SELECT U.username,U.name, U.uid, U.bio, U.profile_pic, U.profile_bg FROM users U WHERE U.status=:status AND U.uid<>:uid ORDER BY U.uid DESC LIMIT 5 ";
    
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("uid", $data->uid, PDO::PARAM_INT);
        $status = '1';
        $stmt->bindParam("status", $status);
        $stmt->execute();
        $welcomeFriends = $stmt->fetchAll(PDO::FETCH_OBJ);

        $welcomeFriendsCount = count($welcomeFriends);
        for ($z = 0; $z < $welcomeFriendsCount; $z++) {
            $welcomeFriends[$z]->role = internalFriendsCheck($data->uid, $welcomeFriends[$z]->uid);
            $welcomeFriends[$z]->profile_pic = profilePic($welcomeFriends[$z]->profile_pic);
            if (empty($welcomeFriends[$z]->name)) {
                $welcomeFriends[$z]->name = $welcomeFriends[$z]->username;
            }
        }

        $db = null;
        echo '{"welcomeFriends": ' . json_encode($welcomeFriends) . '}';
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }