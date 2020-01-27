<?php
/*****************************************************************************
                           INTERNAL FUNCTION
*****************************************************************************/

/** Configuration */
function configurations() {
    $sql = "SELECT language_labels,applicationName,applicationDesc,forgot,newsfeedPerPage,friendsPerPage,photosPerPage,groupsPerPage,notificationPerPage, uploadImage,bannerWidth, profileWidth,gravatar,friendsWidgetPerPage,upload FROM configurations WHERE con_id='1' ";
    try {
        $db = getDB();
        $stmt = $db->query($sql);
        $configuration = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        return $configuration;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

/** Internal Profile Upload */
function internalProfilePicUpload($uid, $image) {

    try {
        if ($uid > 0) {
            $db = getDB();
            $sql = "UPDATE users SET profile_pic=:image,profile_pic_status=:status WHERE uid=:uid";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("image", $image, PDO::PARAM_STR);
            $stmt->bindParam("uid", $uid, PDO::PARAM_INT);
            $status = '1';
            $stmt->bindParam("status", $status);
            $stmt->execute();


            $sql1 = "INSERT INTO user_uploads (image_path,uid_fk,image_type) VALUES (:image,:uid,:status)";
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("image", $image, PDO::PARAM_STR);
            $stmt1->bindParam("uid", $uid, PDO::PARAM_INT);
            $status = '2';
            $stmt1->bindParam("status", $status);
            $stmt1->execute();

            $sql2 = "SELECT uid,profile_pic FROM users WHERE uid=:uid";
            $stmt2 = $db->prepare($sql2);
            $stmt2->bindParam("uid", $uid, PDO::PARAM_INT);
            $stmt2->execute();

            $profileBGImageUpload = $stmt2->fetchAll(PDO::FETCH_OBJ);
            $db = null;

            return $profileBGImageUpload;
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

/** internalConversationLast */
function internalConversationLast($c_id){
    try {    
        if($c_id > 0)
        {
            $db = getDB();
            $sql = "SELECT R.reply,R.user_id_fk,R.read_status FROM conversation_reply R WHERE R.c_id_fk=:c_id ORDER BY R.cr_id DESC LIMIT 1";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("c_id", $c_id, PDO::PARAM_INT);
            $stmt->execute();
            $conversationLastReply = $stmt->fetch(PDO::FETCH_OBJ);
            $db = null;
            $conversationLastReply->reply=htmlCode(nameFilter($conversationLastReply->reply, 15));
            return $conversationLastReply;
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }  
}