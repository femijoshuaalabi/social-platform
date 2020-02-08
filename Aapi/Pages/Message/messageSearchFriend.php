<?php
$request = \Slim\Slim::getInstance()->request();
$data = json_decode($request->getBody());

$sql = "SELECT '' as status,U.username,U.name,U.uid,U.email,U.profile_pic,U.present_state,U.present_lga,U.occupation FROM users U, friends F WHERE U.name LIKE :searchword AND U.status='1' AND U.uid=F.friend_two AND F.friend_one=:uid AND F.role='fri' ORDER BY F.friend_id DESC";
try {
    $key = md5(SITE_KEY . $data->uid);
    if ($key == $data->token) {

        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("uid", $data->uid, PDO::PARAM_INT);
        $q = "%" . $data->searchword . "%";
        $stmt->bindParam("searchword", $q, PDO::PARAM_STR);
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