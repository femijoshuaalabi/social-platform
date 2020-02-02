<?php

$request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $uid = $data->uid;
    $message_user = $data->message_user;

    $user_one = $uid;
    $user_two = internalUsernameDetails($message_user);

    //$user_one = 475;
    //$user_two = 476;

    try {
        $key = md5(SITE_KEY . $data->uid);
        if ($key == $data->token) {
            $db = getDB();
            if ($user_one != $user_two) {
                if ($user_one > 0 && $user_two > 0) {
                    $sql = "SELECT istyping from istyping WHERE user_one = :user_two and user_two = :user_one and istyping = '1'";
                    $stmt = $db->prepare($sql);
                    $stmt->bindParam("user_one", $user_one, PDO::PARAM_INT);
                    $stmt->bindParam("user_two", $user_two, PDO::PARAM_INT);
                    $stmt->execute();
                    $count = $stmt->rowCount();

                    if ($count > 0) {
                        echo '{"istyping": "Yes"}';
                    }else{
                        echo '{"istyping": "No"}';
                    }

                    $db = null;
                }
            }
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }