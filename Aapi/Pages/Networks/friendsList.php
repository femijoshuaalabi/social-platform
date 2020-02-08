<?php
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