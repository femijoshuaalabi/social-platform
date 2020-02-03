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


/* ### internal Username Details ### */
function internalUsernameDetails($username) {
    $sql = "SELECT uid FROM users WHERE username=:username AND status='1'";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("username", $username,PDO::PARAM_STR);
        $stmt->execute();
        $usernameDetails = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $usernameDetails[0]->uid;
        
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
    
}


/* ### Get User Details ### */
function internalUserDetails($uid) {
    $sql = "SELECT uid,username,name,bio,email,profile_pic,profile_bg,group_count,emailNotifications FROM users WHERE uid=:uid AND status='1'";
    try {
        
        if($uid>0)
        {
            $db = getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("uid", $uid, PDO::PARAM_INT);
            $stmt->execute();
            $userDetails = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            /* Username Modification*/
            if($userDetails[0]->name)
            $name=$userDetails[0]->name;
            else
                $name=$userDetails[0]->username;
            
            //$userDetails[0]->name = nameFilter(htmlCode($name),16);
            $userDetails[0]->name = htmlCode($name);
            
            $userDetails[0]->bio = nameFilter($userDetails[0]->bio,60);
            
            if(count($userDetails)){
                /* Profile Pic Modifiaction */
                $userDetails[0]->profile_pic = profilePic($userDetails[0]->profile_pic);
            }
            $db = null;
            
            return $userDetails;
        }
        else
        {
            $userDetails='';
            return $userDetails;
        }
        
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

/* Conversation Create */
function internalConversationCreate($user_one,$message_user) {
    /* Message user id */
    $user_two=internalUsernameDetails($message_user);
    try {
        $db = getDB();
        if($user_one!=$user_two)
        {
            if($user_one>0 && $user_two>0 )
            {
                $sql= "SELECT c_id FROM conversation WHERE (user_one=:user_one and user_two=:user_two) or (user_one=:user_two and user_two=:user_one)";
                $stmt = $db->prepare($sql);
                $stmt->bindParam("user_one", $user_one,PDO::PARAM_INT);
                $stmt->bindParam("user_two", $user_two,PDO::PARAM_INT);
                $stmt->execute();
                $conversation = $stmt->fetchAll(PDO::FETCH_OBJ);
                
                if(count($conversation)==0)
                {
                    $time=time();
                    $ip=$_SERVER['REMOTE_ADDR'];
                    $sql1 = "INSERT INTO conversation(user_one,user_two,ip,time) VALUES (:user_one,:user_two,:ip,:time)";
                    $stmt1 = $db->prepare($sql1);
                    $stmt1->bindParam("user_one", $user_one,PDO::PARAM_INT);
                    $stmt1->bindParam("user_two", $user_two,PDO::PARAM_INT);
                    $stmt1->bindParam("ip", $ip);
                    $stmt1->bindParam("time", $time);
                    $stmt1->execute();
                    
                    $sql2="SELECT c_id FROM conversation WHERE user_one=:user_one ORDER BY c_id DESC LIMIT 1";
                    $stmt2 = $db->prepare($sql2);
                    $stmt2->bindParam("user_one", $user_one,PDO::PARAM_INT);
                    $stmt2->execute();
                    $conversation2 = $stmt2->fetchAll(PDO::FETCH_OBJ);
                    return $conversation2[0]->c_id;
                }
                else
                {
                    return  $conversation[0]->c_id;
                }
                $db = null;
            }
        }
        
    }
    catch(PDOException $e)
    {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


/* ### Upload Image Path ### */
function internalGetImagePath($id) {
    $sql = "SELECT image_path FROM user_uploads WHERE id=:id ";
    try {
        if(strlen($id)>0)
        {
            $db = getDB();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $id,PDO::PARAM_INT);
            $stmt->execute();
            $internalGetImagePath = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            return BASE_URL.UPLOAD_PATH.$internalGetImagePath[0]->image_path;
        }
        else
        {
            return '';
        }
        
        
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


/* ### Friend Valid Check ### */
function internalFriendsCheck($uid, $fid) {
    $sql = "SELECT role FROM friends WHERE friend_one=:uid AND friend_two=:fid";
    try {
        $db = getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("uid", $uid);
        $stmt->bindParam("fid", $fid);
        $stmt->execute();
        $friendsCheck = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        return $friendsCheck[0]->role;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}





