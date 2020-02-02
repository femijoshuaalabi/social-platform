<?php

$request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $usernameEmail = $data->usernameEmail;
    $type = $data->type;
    $valid = 0;

    try {
        $db = getDB();

        if ($type) {
            if (filter_var($usernameEmail, FILTER_VALIDATE_EMAIL)) {
                $sql = "SELECT uid FROM users WHERE email=:usernameEmail";
                $valid = 1;
            }
        } else {
            if (preg_match('/^[a-zA-Z0-9]{3,}$/', $usernameEmail)) {
                $sql = "SELECT uid FROM users WHERE username=:usernameEmail";
                $valid = 1;
            }
        }

        if ($valid) {
            $stmt = $db->prepare($sql);
            $stmt->bindParam("usernameEmail", $usernameEmail, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();


            if ($count == 0)
                echo '{"usernameEmailCheck": [{"status":"1"}]}';
            else
                echo '{"usernameEmailCheck": []}';
        }
        $db = null;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }