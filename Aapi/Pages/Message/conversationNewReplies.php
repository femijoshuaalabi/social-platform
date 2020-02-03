<?php

$request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $uid = $data->uid;
    $last = $data->last;
    $message_user = $data->message_user;


    //$data->token = '282f17a63b10df1472b19890813a75e8';
    //$data->uid = 476;
    //$uid = 476;
    //$message_user = 'femicontact';

    /* Conversation User ID */
    $conversation_uid = internalUsernameDetails($message_user);
    /* Conversation ID */

    if ($conversation_uid != $uid) {
        $otherUserData = internalUserDetails($conversation_uid);
        $otherName = $otherUserData[0]->name;
    }

    try {
        $key = md5(SITE_KEY . $data->uid);
        if ($key == $data->token) {
            $c_id = internalConversationCreate($uid, $message_user);

            $db = getDB();
            $sql = "SELECT R.cr_id, U.conversation_count FROM users U, conversation_reply R WHERE R.user_id_fk=U.uid AND U.status='1' AND R.c_id_fk=:c_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("c_id", $c_id, PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->rowCount();
            $second_count = $count - 10;
            $squery = '';

            if ($second_count && $count > 10) {
                $x_count = $second_count . ',';
            }

            /* More Records */
            $morequery = "";
            if ($last) {
                $morequery = " and R.cr_id<'" . $last . "' ";
                $x_count = '';
            }


            $sql5 = "SELECT R.c_id_fk,R.cr_id,R.time,R.reply,R.read_status,R.lat,R.lang,R.uploads,U.uid,U.username,U.name,U.email,U.profile_pic,U.conversation_count FROM users U, conversation_reply R WHERE R.user_id_fk=U.uid and R.c_id_fk=:c_id $morequery ORDER BY R.cr_id DESC LIMIT 1";
            $stmt5 = $db->prepare($sql5);
            $stmt5->bindParam("c_id", $c_id, PDO::PARAM_INT);
            $stmt5->execute();
            $conversationReplies = $stmt5->fetchAll(PDO::FETCH_OBJ);
            if (count($conversationReplies)) {

                for ($z = 0; $z < count($conversationReplies); $z++) {
                    if ($conversationReplies[$z]->read_status == 1) {
                        /* TimeAgo */
                        $n_time = $conversationReplies[$z]->time;
                        $conversationReplies[$z]->timeAgo = date("c", $n_time);
                        $conversationReplies[$z]->message = ucfirst($conversationReplies[$z]->reply);

                        $conversationReplies[$z]->reply = htmlCode($conversationReplies[$z]->reply);
                        /* Username Check */
                        if (empty($conversationReplies[$z]->name)) {
                            $conversationReplies[$z]->name = $conversationReplies[$z]->username;
                        }

                        /* Upload Image */
                        $uploadPaths = array();

                        if ($conversationReplies[$z]->uploads) {
                            $s = explode(",", $conversationReplies[$z]->uploads);
                            $conversationReplies[$z]->uploadCount = count($s);

                            /* Upload Paths */
                            foreach ($s as $a) {
                                array_push($uploadPaths, internalGetImagePath($a));
                            }

                            $conversationReplies[$z]->uploadPaths = $uploadPaths;
                        } else {
                            $conversationReplies[$z]->uploadCount = '';
                            $conversationReplies[$z]->uploadPaths = '';
                        }
                        /* ProfilePic Check */
                        $profile_pic = profilePic($conversationReplies[$z]->profile_pic);
                        $conversationReplies[$z]->profile_pic = $profile_pic;
                        $conversationReplies[$z]->otherName = $otherName;
                    }
                }

                if($conversationReplies[0]->read_status == '1'){
                    echo '{"conversationReplies": ' . json_encode($conversationReplies) . '}';
                }else {
                    echo '{"conversationReplies": []}';
                }

                $sql1 = "SELECT R.cr_id,R.time,R.reply,R.user_id_fk FROM conversation_reply R WHERE R.c_id_fk=:c_id ORDER BY R.cr_id DESC LIMIT 1";
                $stmt1 = $db->prepare($sql1);
                $stmt1->bindParam("c_id", $c_id, PDO::PARAM_INT);
                $stmt1->execute();
                $conversationData = $stmt1->fetchAll(PDO::FETCH_OBJ);
                $o_uid = $conversationData[0]->user_id_fk;


                if ($o_uid != $uid) {

                    $sql2 = "UPDATE conversation_reply SET read_status='0' WHERE c_id_fk=:c_id";
                    $stmt2 = $db->prepare($sql2);
                    $stmt2->bindParam("c_id", $c_id, PDO::PARAM_INT);
                    $stmt2->execute();
                    $sql3 = "SELECT conversation_count from users WHERE uid=:uid";
                    $stmt3 = $db->prepare($sql3);
                    $stmt3->bindParam("uid", $uid, PDO::PARAM_INT);
                    $stmt3->execute();
                    $conversationCountData = $stmt3->fetchAll(PDO::FETCH_OBJ);
                    $conversation_count = $conversationCountData[0]->conversation_count;

                    if ($conversation_count > 0) {
                        $sql4 = "UPDATE users SET conversation_count=conversation_count-1 WHERE uid=:uid";
                        $stmt4 = $db->prepare($sql4);
                        $stmt4->bindParam("uid", $uid, PDO::PARAM_INT);
                        $stmt4->execute();
                    }
                }
            } else {
                echo '{"conversationReplies": [{"c_id_fk":"' . $c_id . '","otherName":"' . $otherName . '"}]}';
            }
            $db = null;
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }