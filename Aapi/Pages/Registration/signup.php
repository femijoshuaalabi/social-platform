<?php

$request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $email = $data->email;
    $username = $data->username;
    $password = $data->password;
    $name = $data->name;

    //$email = 'heloo@ggcs.com';
    //$username = 'admin8';
    //$password = 'password';
    //$name = "Alabi Joshua";


    try {

        $username_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $username);
        $emain_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
        $password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);

        //Things to note but skipped for now
        /**********************************************************************
             $emain_check > 0 && $username_check > 0 && $password_check > 0
        ************************************************************************/

        if (strlen(trim($username)) > 0 && strlen(trim($password)) > 0 && strlen(trim($email)) > 0) {
            $db = getDB();
            $sql = "SELECT uid FROM users WHERE username=:username or email=:email";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("username", $username, PDO::PARAM_STR);
            $stmt->bindParam("email", $email, PDO::PARAM_STR);
            $stmt->execute();
            $mainCount = $stmt->rowCount();
            //$mainCount = 0;
            $created = time();
            if ($mainCount == 0) {
                $status = '1';
                if (SMTP_CONNECTION > 0) {
                    $status = '1';
                }
                /* Inserting user values */
                $email_active_code = md5($email . time());
                $sql1 = "INSERT INTO users(username,password,email,name,last_login,email_activation,status)VALUES(:username,:password,:email,:name,:created,:email_activation,:status)";
                $stmt1 = $db->prepare($sql1);
                $stmt1->bindParam("username", $username, PDO::PARAM_STR);
                $password = md5($password);
                $stmt1->bindParam("password", $password, PDO::PARAM_STR);
                $stmt1->bindParam("email", $email, PDO::PARAM_STR);
                $stmt1->bindParam("name", $name, PDO::PARAM_STR);
                $stmt1->bindParam("created", $created);
                $stmt1->bindParam("status", $status);
                $stmt1->bindParam("email_activation", $email_active_code);
                $stmt1->execute();



                $stmt2 = $db->prepare("SELECT uid,notification_created,username,name,profile_pic,tour FROM users WHERE username=:username");
                $stmt2->bindParam("username", $data->username, PDO::PARAM_STR);
                $stmt2->execute();
                $signup = $stmt2->fetchAll(PDO::FETCH_OBJ);
                $uid = $signup[0]->uid;

                if ($uid > 0) {
                    $sql3 = "INSERT INTO friends(friend_one,friend_two,role,created)VALUES(:uid,:uid,:me,:created)";
                    $stmt3 = $db->prepare($sql3);
                    $stmt3->bindParam("uid", $uid, PDO::PARAM_INT);
                    $time = time();

                    $stmt3->bindParam("created", $time, PDO::PARAM_STR);
                    $me = 'me';
                    $stmt3->bindParam("me", $me, PDO::PARAM_STR);
                    $stmt3->execute();
                }

            $sql4 = "SELECT uid,notification_created,username,name,profile_pic,tour FROM users WHERE (username=:username or email=:username) and password=:password AND status='1' ";
                    $stmt4 = $db->prepare($sql4);
                    $stmt4->bindParam("username", $data->username, PDO::PARAM_STR);
                    $password = md5($data->password);
                    $stmt4->bindParam("password", $password, PDO::PARAM_STR);
                    $stmt4->execute();
                    $mainCount = $stmt4->rowCount();
                    $login = $stmt4->fetchAll(PDO::FETCH_OBJ);
                    if (!empty($login)) {
                        $uid = $login[0]->uid;
                        $key = SITE_KEY . $uid;
                        $login[0]->token = md5($key);
                        $notification_created = $login[0]->notification_created;
                        if ($mainCount == 1) {
                            $photos_query = $db->query("SELECT id FROM user_uploads WHERE uid_fk='$uid' and group_id_fk='0'");
                            $photos_count = $photos_query->rowCount(); /* Photos Count */
                            $updates_query = $db->query("SELECT msg_id FROM messages WHERE uid_fk='$uid' and group_id_fk='0'");
                            $updates_count = $updates_query->rowCount(); /* Updates Count */
                            $time = time();
                            $updates_query = $db->query("UPDATE users SET last_login='$time',photos_count='$photos_count',updates_count='$updates_count' WHERE uid='$uid'");
                        }
                    }
                    $db = null;
                    /* Username Modification */
                    if ($login[0]->name) {
                        $name = htmlCode($login[0]->name);
                    } else {
                        $name = $login[0]->username;
                    }

                    $login[0]->name = $name;
                    /* Profile Pic Modification */
                    if ($login) {
                        $login[0]->profile_pic = profilePic($login[0]->profile_pic);
                        $login[0]->configurations = configurations();
                    }
            $finalStatus = $login;
            $db = null;
            echo '{"signup": '. json_encode($finalStatus).'}';
            } else {
                $finalStatus = '0';
            }
        }else {
            echo '{"signup":{"text":"Unknown error"}}';
        }
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }