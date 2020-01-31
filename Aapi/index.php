<?php

/*****************************************************************************
                            AJUWAYA CONNECT API
*****************************************************************************/
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../config.php';
require 'AJYFunction/functions.php';
require 'AJYFunction/FunctionBuilder.php';
require 'AJYFunction/InternalFunctions.php';
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

/*****************************************************************************
                            INIT ROUTING
*****************************************************************************/

$app->post('/login', 'login'); /* User login */
$app->post('/signup', 'signup'); /* User Signup  */
$app->post('/usernameEmailCheck', 'usernameEmailCheck'); /* SignUp Check */ 
$app->post('/send_code_to_mail', 'send_code_to_mail'); /* send code to_mail */ 
$app->post('/ValidateEmailWithPin', 'ValidateEmailWithPin'); /* Validate Email With Pin */

$app->post('/conversationLists', 'conversationLists'); /* Message conversation List */
$app->post('/conversationReplies', 'conversationReplies'); /* Message conversation Replies */
$app->post('/ReplyConversation', 'ReplyConversation'); /* Reply Conversation */

$app->run();




/*****************************************************************************
                                 LOGIN BLOCK
*****************************************************************************/

/* Login */
function login() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    //$data->username = 'ajuwaya1';
    //$data->password = 'webhost123';

    try {
        $db = getDB();
        $sql = "SELECT uid,notification_created,username,name,profile_pic,tour FROM users WHERE (username=:username or email=:username) and password=:password ";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("username", $data->username, PDO::PARAM_STR);
        $password = md5($data->password);
        $stmt->bindParam("password", $password, PDO::PARAM_STR);
        $stmt->execute();
        $mainCount = $stmt->rowCount();
        $login = $stmt->fetchAll(PDO::FETCH_OBJ);
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

                if (empty($notification_created)) {
                    /* Last login update */
                    $db->query("UPDATE users SET notification_created='$time' WHERE uid='$uid'") or die(mysqli_error($this->db));
                }
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

        echo '{"login": ' . json_encode($login) . '}';
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

/*****************************************************************************
                                 REGISTRATION BLOCK
*****************************************************************************/

/* ### Username Check ### */
function usernameEmailCheck() {
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
}

/* ### send_code_to_mail ### */
function send_code_to_mail() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $usernameEmail = $data->usernameEmail;
    $type = '1';
    $valid = 0;

    //$usernameEmail = 'femi@okk.com';

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

            if ($count == 0){

                $gen_code = '';
                for ($i = 0; $i<4; $i++) {
                    $gen_code .= mt_rand(0,9);
                }

                 $sql2 = "SELECT id FROM confirm_user WHERE email=:usernameEmail";
                 $stmt2 = $db->prepare($sql2);
                 $stmt2->bindParam("usernameEmail", $usernameEmail, PDO::PARAM_STR);
                 $stmt2->execute();
                 $count2 = $stmt2->rowCount();

                 if($count2 == 0){
                    $sql1 = "INSERT INTO confirm_user(email,pin)VALUES(:email,:pin)";
                    $stmt1 = $db->prepare($sql1);
                    $stmt1->bindParam("email", $usernameEmail, PDO::PARAM_STR);
                    $stmt1->bindParam("pin", $gen_code, PDO::PARAM_STR);
                    $stmt1->execute();
                 }else{
                    $sql3 = "UPDATE confirm_user SET pin=:pin WHERE email=:usernameEmail";
                    $stmt3 = $db->prepare($sql3);
                    $stmt3->bindParam("usernameEmail", $usernameEmail, PDO::PARAM_STR);
                    $stmt3->bindParam("pin", $gen_code, PDO::PARAM_STR);
                    $stmt3->execute();
                 }

                if(SMTP_CONNECTION == 1) {
                    // Load Composer's autoloader
                    require 'PHPMailer/src/Exception.php';
                    require 'PHPMailer/src/PHPMailer.php';
                    require 'PHPMailer/src/SMTP.php';
                    require 'PHPMailer/src/POP3.php';
                    require 'PHPMailer/src/OAuth.php';

                    // Instantiation and passing `true` enables exceptions
                    $mail = new PHPMailer(true);
                    $template_url = BASE_URL . 'Aapi/email_template/confirm_code.php';
                    $body_content = file_get_contents($template_url);

                    $body_content = str_replace('%email%', $usernameEmail, $body_content);
                    $body_content = str_replace('%pin%', $gen_code, $body_content);

                    try {
                        //Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                        //$mail->isSMTP();                                            // Send using SMTP
                        $mail->Host       = 'us2.smpt.mailhostbox.com';                    // Set the SMTP server to send through
                        $mail->SMTPAuth   = false;                                   // Enable SMTP authentication
                        $mail->Username   = 'hello@corpersmeet.com';                     // SMTP username
                        $mail->Password   = 'Password007+';                               // SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; PHPMailer::ENCRYPTION_SMTPS` also accepted
                        $mail->Port       = 587;                                    // TCP port to connect to

                        //Recipients
                        $mail->setFrom('no-reply@corpersmeet.com', 'Corpersmeet Inc.');
                        $mail->addAddress($usernameEmail, $usernameEmail);     // Add a recipient

                        // Attachments
                        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                        // Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = 'Please Confirm your Email to Continue your registration';
                        $mail->Body    = $body_content;
                        $mail->AltBody = strip_tags($body_content);
                        $mail->send();
                        //echo 'Message has been sent';
                        echo '{"usernameEmailCheck": [{"status":"1"}]}';
                    } catch (Exception $e) {
                        //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        echo '{"usernameEmailCheck": [{"status":"'.$mail->ErrorInfo.'"}]}';
                    }
                }else{
                    echo '{"usernameEmailCheck": [{"status":"1"}]}';
                }
            }
            else{
                echo '{"usernameEmailCheck": []}';
            }
        }
        $db = null;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function ValidateEmailWithPin() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $usernameEmail = $data->usernameEmail;
    $type = '1';
    $valid = 0;
    $pin = $data->pin;

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

            if ($count == 0){
                 $sql2 = "SELECT id FROM confirm_user WHERE email=:usernameEmail and pin=:pin";
                 $stmt2 = $db->prepare($sql2);
                 $stmt2->bindParam("usernameEmail", $usernameEmail, PDO::PARAM_STR);
                 $stmt2->bindParam("pin", $pin, PDO::PARAM_STR);
                 $stmt2->execute();
                 $count2 = $stmt2->rowCount();
                 if($count2 > 0){

                    echo '{"usernameEmailCheck": [{"status":"1"}]}';
                 }else{
                    echo '{"usernameEmailCheck": []}';
                 }
            }
            else{
                echo '{"usernameEmailCheck": []}';
            }
        }
        $db = null;
    } catch (PDOException $e) {
        echo '{"error":{"text":' . $e->getMessage() . '}}';
    }
}

function signup() {
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
}


/*****************************************************************************
                                 MESSAGE BLOCK
*****************************************************************************/

/* Converstaions */
function conversationLists() {
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
                $conversations[$z]->lastReply=internalConversationLast($conversations[$z]->c_id);
                
            }
            
            $db = null;
            echo '{"conversations": ' . json_encode($conversations) . '}';
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
    
}

/*Conversation Replies*/
function conversationReplies() {
    $request = \Slim\Slim::getInstance()->request();
    $data = json_decode($request->getBody());
    $uid=$data->uid;
    $last=$data->last;
    $message_user=$data->message_user;
    /* Conversation User ID */
    $conversation_uid=internalUsernameDetails($message_user);
    /* Conversation ID */
    
    if($conversation_uid != $uid)
    {
        $otherUserData=internalUserDetails($conversation_uid);
        $otherName=$otherUserData[0]->name;
    }
    
    try {
        $key=md5(SITE_KEY.$data->uid);
        if($key==$data->token)
        {
            $c_id=internalConversationCreate($uid,$message_user);
            
            $db = getDB();
            $sql = "SELECT R.cr_id, U.conversation_count FROM users U, conversation_reply R WHERE R.user_id_fk=U.uid AND U.status='1' AND R.c_id_fk=:c_id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("c_id", $c_id,PDO::PARAM_INT);
            $stmt->execute();
            $count=$stmt->rowCount();
            $second_count=$count-10;
            $squery='';
            
            if($second_count && $count>10)
            {
                $x_count=$second_count.',';
            }
            
            /* More Records*/
            $morequery="";
            if($last)
            {
                $morequery=" and R.cr_id<'".$last."' ";
                $x_count='';
            }
            
            $sql1 = "SELECT R.cr_id,R.time,R.reply,R.user_id_fk FROM conversation_reply R WHERE R.c_id_fk=:c_id ORDER BY R.cr_id DESC LIMIT 1";
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("c_id", $c_id,PDO::PARAM_INT);
            $stmt1->execute();
            $conversationData = $stmt1->fetchAll(PDO::FETCH_OBJ);
            $o_uid=$conversationData[0]->user_id_fk;
            
            
            if($conversation_uid)
            {
                if($o_uid!=$uid)
                {
                    
                    $sql2 = "UPDATE conversation_reply SET read_status='0' WHERE c_id_fk=:c_id ORDER BY cr_id DESC LIMIT 1";
                    $stmt2 = $db->prepare($sql2);
                    $stmt2->bindParam("c_id", $c_id,PDO::PARAM_INT);
                    $stmt2->execute();
                    $sql3 = "SELECT conversation_count from users WHERE uid=:uid";
                    $stmt3 = $db->prepare($sql3);
                    $stmt3->bindParam("uid", $uid, PDO::PARAM_INT);
                    $stmt3->execute();
                    $conversationCountData = $stmt3->fetchAll(PDO::FETCH_OBJ);
                    $conversation_count=$conversationCountData[0]->conversation_count;
                    
                    if($conversation_count>0)
                    {
                        $sql4 = "UPDATE users SET conversation_count=conversation_count-1 WHERE uid=:uid";
                        $stmt4 = $db->prepare($sql4);
                        $stmt4->bindParam("uid", $uid, PDO::PARAM_INT);
                        $stmt4->execute();
                    }
                }
            }
            
            $sql5 = "SELECT R.c_id_fk,R.cr_id,R.time,R.reply,R.lat,R.lang,R.uploads,U.uid,U.username,U.name,U.profile_pic,U.conversation_count FROM users U, conversation_reply R WHERE R.user_id_fk=U.uid and R.c_id_fk=:c_id $morequery ORDER BY R.cr_id ASC LIMIT $x_count 10";
            $stmt5 = $db->prepare($sql5);
            $stmt5->bindParam("c_id", $c_id,PDO::PARAM_INT);
            $stmt5->execute();
            $conversationReplies = $stmt5->fetchAll(PDO::FETCH_OBJ);
            if(count($conversationReplies))
            {
                
                for($z=0;$z<count($conversationReplies);$z++)
                {
                    /* TimeAgo */
                    $n_time=$conversationReplies[$z]->time;
                    $conversationReplies[$z]->timeAgo=date("c", $n_time);
                    $conversationReplies[$z]->message=ucfirst($conversationReplies[$z]->reply);
                    
                    $conversationReplies[$z]->reply=htmlCode($conversationReplies[$z]->reply);
                    /*Username Check*/
                    if(empty($conversationReplies[$z]->name))
                    {
                        $conversationReplies[$z]->name=$conversationReplies[$z]->username;
                    }
                    
                    /*Upload Image */
                    $uploadPaths=array();
                    
                    if($conversationReplies[$z]->uploads)
                    {
                        $s = explode(",", $conversationReplies[$z]->uploads);
                        $conversationReplies[$z]->uploadCount=count($s);
                        
                        /* Upload Paths */
                        foreach($s as $a)
                        {
                            array_push($uploadPaths,internalGetImagePath($a));
                        }
                        
                        $conversationReplies[$z]->uploadPaths=$uploadPaths;
                        
                    }
                    else
                    {
                        $conversationReplies[$z]->uploadCount='';
                        $conversationReplies[$z]->uploadPaths='';
                    }
                    /*ProfilePic Check*/
                    $profile_pic=profilePic($conversationReplies[$z]->profile_pic);
                    $conversationReplies[$z]->profile_pic=$profile_pic;
                    $conversationReplies[$z]->otherName=$otherName;
                }
                echo '{"conversationReplies": ' . json_encode($conversationReplies) . '}';
            }
            else
            {
                echo '{"conversationReplies": [{"c_id_fk":"'.$c_id.'","otherName":"'.$otherName.'"}]}';
            }
            $db = null;
        }
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function ReplyConversation(){
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
        if($key==$data->token && $uid > 0 && $c_id > 0)
        {
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
    
    
}





