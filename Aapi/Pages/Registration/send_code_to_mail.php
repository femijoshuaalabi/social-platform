<?php
/*****************************************************************************
                            AJUWAYA CONNECT API
*****************************************************************************/
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


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