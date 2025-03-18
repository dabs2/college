<?php
include __DIR__ . "/../components/mailclass/phpmailer/vendor/autoload.php";

use College\Ddcollege\Model\settings;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class emailcontroller
{
    private PHPMailer $email;
    private settings $settings;

    public function __construct()
    {
        $this->email = new PHPMailer(true);
        $this->settings = new settings(true);
    }

    public function emailconfig(Settings $settings)
    {
        $id = $_SESSION["user_id"];
//        $settingsobj = $settings->view_settings("Email Settings",$id);
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $this->email->isSMTP();                                            //Send using SMTP
        $this->email->Host = 'youremailhost';                     //Set the SMTP server to send through
        $this->email->SMTPAuth = true;                                   //Enable SMTP authentication
        $this->email->Username = 'youremail@example.com';                     //SMTP username
        $this->email->Password = 'yourpassword';                               //SMTP password
        $this->email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $this->email->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    }


    public function sendtestemail($sendtoaddress, $employee_name, $subject, $body, $cc = array())
    {
        try {
            //Server settings
            $this->emailconfig($this->settings);
            //Recipients
            $this->email->setFrom('youremail@example.com', 'Portal Message');
            $this->email->addAddress($sendtoaddress, $employee_name);     //Add a recipient
            $this->email->addReplyTo('youremail@example.com', 'Company Portal');
            if (!empty($cc) && count($cc) >= 1) {
                $this->email->addCC('cc@example.com');
            }
//            $this->email->addCC('cc@example.com');
//            $this->email->addBCC('bcc@example.com');

//            //Attachments
//            $this->email->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//            $this->email->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

            //Content
            $this->email->isHTML(true);                                  //Set email format to HTML
            $this->email->Subject = $subject;
            $this->email->Body = $body;
            $this->email->AltBody = 'This is the body in plain text for non-HTML mail clients';

            return $this->email->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            return "Message could not be sent.  Mailer Error: {$this->email->ErrorInfo}";
        }
    }
}