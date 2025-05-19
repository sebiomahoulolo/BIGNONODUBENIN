<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require base_path('vendor/autoload.php');


class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bignondubenin1@gmail.com';
            $mail->Password = 'adsl xchc jjhq sijo';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

         
          $mail->setFrom('bignondubenin1@gmail.com', 'BIGNON DU BENIN');
            $mail->addAddress('bignondubenin1@gmail.com');

            $mail->Subject = $request->subject;
           $mail->Body = "Nom: " . $request->input('name') . "\n" .
              "Email: " . $request->input('email') . "\n" .
              "Téléphone: " . $request->input('phone') . "\n" .
              "Message: " . $request->input('message');

            $mail->send();
            return back()->with('success', 'Message envoyé avec succès !');
        } catch (Exception $e) {
            return back()->with('error', "Erreur : {$mail->ErrorInfo}");
        }
    }


       




}

