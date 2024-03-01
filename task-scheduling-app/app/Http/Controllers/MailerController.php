<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailerController extends Controller
{
    // view email form
    public function email(){
        return view('email');
    }

    // send the email
    public function composeEmail(Request $request){

        //Load Composer's autoloader
        require base_path("vendor/autoload.php");

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            // Email server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';             //  smtp host
            $mail->SMTPAuth = true;
            $mail->Username = 'sinjusherlyraju@gmail.com';   //  sender username
            $mail->Password = 'ysvrzritqoffzddd';       // sender password
            $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
            $mail->Port = 587;                          // port - 587/465

            //Recipients
            $mail->setFrom('sinjusherlyraju@gmail.com', 'sinjusherlyraju@gmail.com');
            $mail->addAddress($request->emailRecipient);
            $mail->addCC($request->emailCc);
            $mail->addBCC($request->emailBcc);

            $mail->addReplyTo('sinjusherlyraju@gmail.com', 'sinjusherlyraju@gmail.com');

            if(isset($_FILES['emailAttachments'])) {
                for ($i=0; $i < count($_FILES['emailAttachments']['tmp_name']); $i++) {
                    $mail->addAttachment($_FILES['emailAttachments']['tmp_name'][$i], $_FILES['emailAttachments']['name'][$i]);
                }
            }
            
            $mail->isHTML(true);                // Set email content format to HTML

            $mail->Subject = $request->emailSubject;
            $mail->Body    = $request->emailBody;

            // $mail->AltBody = plain text version of email body;

            if( !$mail->send() ) {
                return back()->with("failed", "Email not sent.")->withErrors($mail->ErrorInfo);
            }
            
            else {
                return back()->with("success", "Email has been sent.");
            }

        
        }
        catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
