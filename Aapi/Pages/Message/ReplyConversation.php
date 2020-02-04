<?php

$request = \Slim\Slim::getInstance()->request();
$data = json_decode($request->getBody());
$uid=$data->uid;
$c_id=$data->c_id;
$reply=$data->reply;
$lat='';
$lang='';
$uploads=$data->uploads;
$time=time();
$ip=$_SERVER['REMOTE_ADDR'];

try {
    $key=md5(SITE_KEY.$data->uid);
    if($key==$data->token && $uid > 0 && $c_id > 0) {
        $db = getDB();
        $sql = "INSERT INTO conversation_reply (user_id_fk,reply,ip,time,c_id_fk,lat,lang,uploads) VALUES (:uid,:reply,:ip,:time,:c_id,:lat,:lang,:uploads)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("uid", $uid, PDO::PARAM_INT);
        $stmt->bindParam("c_id", $c_id,PDO::PARAM_INT);
        $stmt->bindParam("reply", $reply,PDO::PARAM_STR);
        $stmt->bindParam("ip", $ip);
        $stmt->bindParam("time", $time);
        $stmt->bindParam("lat", $lat,PDO::PARAM_STR);
        $stmt->bindParam("lang", $lang,PDO::PARAM_STR);
        $stmt->bindParam("uploads", $uploads,PDO::PARAM_STR);
        $stmt->execute();
        
        $sql1 = "UPDATE conversation SET time='$time' WHERE c_id='$c_id'";
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("c_id", $c_id,PDO::PARAM_INT);
        $stmt1->bindParam("time", $time);
        $stmt1->execute();
        
        $sql2 = "SELECT if(user_one = :uid,user_two,user_one) AS uid FROM conversation WHERE c_id = :c_id";
        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam("c_id", $c_id,PDO::PARAM_INT);
        $stmt2->bindParam("uid", $uid, PDO::PARAM_INT);
        $stmt2->execute();
        $cUsers = $stmt2->fetchAll(PDO::FETCH_OBJ);
        $o_uid=$cUsers[0]->uid; /* Converstions Original User */
        if($o_uid!=$uid)
        {
            $sql3 = "SELECT read_status FROM conversation_reply WHERE c_id_fk=:c_id and user_id_fk=:uid ORDER BY cr_id DESC LIMIT 1,1";
            $stmt3 = $db->prepare($sql3);
            $stmt3->bindParam("c_id", $c_id,PDO::PARAM_INT);
            $stmt3->bindParam("uid", $uid, PDO::PARAM_INT);
            $stmt3->execute();
            $cReply = $stmt3->fetchAll(PDO::FETCH_OBJ);
            if($cReply[0]->read_status==0 || $cReply[0]->read_status=='' )
            {
                $sql4 = "UPDATE users SET conversation_count=conversation_count+1 WHERE uid=:o_uid";
                $stmt4 = $db->prepare($sql4);
                $stmt4->bindParam("o_uid", $o_uid,PDO::PARAM_INT);
                $stmt4->execute();
            }
            
            $sql5 = "SELECT R.cr_id,R.time,R.reply,R.lat,R.lang,R.uploads,U.uid,U.username,U.email,U.name,U.profile_pic FROM users U, conversation_reply R WHERE R.user_id_fk=U.uid and R.c_id_fk=:c_id ORDER BY R.cr_id DESC LIMIT 1";
            $stmt5 = $db->prepare($sql5);
            $stmt5->bindParam("c_id", $c_id,PDO::PARAM_INT);
            $stmt5->execute();
            $conversationReply = $stmt5->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            
            if($conversationReply){
                
                $conversationReply[0]->reply=htmlCode($conversationReply[0]->reply);
                /* TimeAgo */
                $n_time=$conversationReply[0]->time;
                $conversationReply[0]->timeAgo=date("c", $n_time);
                
                /*Upload Image */
                $uploadPaths=array();
                
                if($conversationReply[0]->uploads)
                {
                    $s = explode(",", $conversationReply[0]->uploads);
                    $conversationReply[0]->uploadCount=count($s);
                    
                    /* Upload Paths */
                    foreach($s as $a)
                    {
                        array_push($uploadPaths,internalGetImagePath($a));
                    }
                    
                    $conversationReply[0]->uploadPaths=$uploadPaths;
                    
                }
                else
                {
                    $conversationReply[0]->uploadCount='';
                    $conversationReply[0]->uploadPaths='';
                }
                
                /*Username Check*/
                if(empty($conversationReply[0]->name))
                {
                    $conversationReply[0]->name=$conversationReply[0]->username;
                }
                /*ProfilePic Check*/
                $profile_pic=profilePic($conversationReply[0]->profile_pic);
                $conversationReply[0]->profile_pic=$profile_pic;
            }
            
            echo '{"conversationReply": ' . json_encode($conversationReply) . '}';
            
            if(SMTP_CONNECTION > 0 && ($cReply[0]->read_status==0 || $cReply[0]->read_status=='' ))
            {
                
                $mainUserData=internalUserDetails($uid);
                $mailName=$mainUserData[0]->name;
                $sentUsername=$mainUserData[0]->username;
                
                $conversationUserDetails=internalUserDetails($o_uid);
                $to=$conversationUserDetails[0]->email;
                $emailName=$conversationUserDetails[0]->name;
                $messageUid=$conversationUserDetails[0]->uid;
                $emailNotifications=$conversationUserDetails[0]->emailNotifications;
                $applicationName=SITE_NAME;
                
                if($uid!=$messageUid && $emailNotifications > 0)
                {
                    $messageLink=BASE_URL."messages/".$sentUsername;
                    $subject =$mailName.' messaged you on '.$applicationName;
                    $body="Hello ".$emailName.",<br/> <br/> ".$mailName." messaged you on ".$applicationName.".<br/><br/> <a href='".$messageLink."'>Reply</a><br/><br/>Support
                    <br/>".$applicationName.'<br/>'.BASE_URL.'<br/><br/>
                    You are receiving this because you are subscribed to notifications on our website.
                    <a href="'.BASE_URL.'settings.php">Edit your email alerts</a>';
                    
                    sendMail($to,$subject,$body);
                    
                }
                
            }
            
        }
    }
}
catch(PDOException $e) {
    echo '{"error":{"text":'. $e->getMessage() .'}}';
}