<?php

$request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());

    // $data->uid = 475;
    // $data->last_time = '';
    // $data->conversation_uid = '';
    // $data->token = '2b8ce5597e34dadfabd7d239901c3765';

    $uid=$data->uid;
    $last_time=$data->last_time;
    $conversation_uid=$data->conversation_uid;

    
    /* More Records*/
    $morequery="";
    if($last_time)
    {
        $morequery=" and c.time<'".$last_time."' ";
    }
    /* More Button End*/
    
    try {
        $key=md5(SITE_KEY.$data->uid);
        if($key==$data->token)
        {
            $db = getDB();
            $sql = "SELECT DISTINCT u.uid,c.c_id,u.name,u.profile_pic,u.username,u.email,c.time
            FROM conversation c, users u, conversation_reply r
            WHERE CASE
            WHEN c.user_one = :user_one
            THEN c.user_two = u.uid
            WHEN c.user_two = :user_one
            THEN c.user_one= u.uid
            END
            AND (
            c.user_one =:user_one
            OR c.user_two =:user_one
            ) AND u.status=:status AND c.c_id=r.c_id_fk AND u.uid<>:conversation_uid
            $morequery ORDER BY c.time DESC LIMIT 15";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("user_one", $uid,PDO::PARAM_INT);
            $stmt->bindParam("conversation_uid", $conversation_uid);
            $status='1';
            $stmt->bindParam("status", $status);
            $stmt->execute();
            $conversations = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;
            $count=count($conversations);
            for($z=0;$z<$count;$z++)
            {
                /* TimeAgo */
                $n_time=$conversations[$z]->time;
                $conversations[$z]->timeAgo=date("c", $n_time);
                
                /*Username Check*/
                if(empty($conversations[$z]->name))
                {
                    $conversations[$z]->name=$conversations[$z]->username;
                    
                }
                /*ProfilePic Check*/
                $conversations[$z]->profile_pic=profilePic($conversations[$z]->profile_pic);
                $conversations[$z]->unreadMessageCount=internalConversationUnreadMessage($conversations[$z]->c_id,$data->uid);
                $conversations[$z]->lastReply=internalConversationLast($conversations[$z]->c_id);
            }
            
            $db = null;
            echo '{"conversations": ' . json_encode($conversations) . '}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }