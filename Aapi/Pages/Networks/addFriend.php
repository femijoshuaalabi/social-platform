<?php
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