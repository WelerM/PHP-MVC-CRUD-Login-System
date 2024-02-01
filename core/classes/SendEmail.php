<?php

namespace core\classes;

use core\classes\Functions;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailfer\Exception;

$root = $_SERVER["DOCUMENT_ROOT"] . '/sistemaagendamento';
require_once  $root . '/config.php';

class SendEmail
{

    public static function send_email($name, $email, $number, $text, $date = null, $hour = null)
    {

        $mail = new PHPMailer(true);
        $mail->CharSet = 'UTF-8';


        if ($date === null || $hour == null) { //Contact email will be sent

            $client_name = $name;
            $client_email = $email;
            $client_number = $number;
            $client_text = $text;

            //Checks for empty fields
            if (
                empty($client_name)
                || empty($client_email)
                || empty($client_number)
                || empty($client_text)
            ) {

                $_SESSION['error'] = true;
                $_SESSION['msg'] = "Campos vazios!";
                Functions::redirect('contact');
                return;
            }

            //Checks for valid email
            if (filter_var(trim($_POST['sche-confirm-email']), FILTER_VALIDATE_EMAIL) === false) {
                $_SESSION['error'] = true;
                $_SESSION['msg'] = "Email inválido!";
                Functions::redirect('contact');
                return;
            }

            //Ready to send
            try {
                //Server settings
                $mail->SMTPDebug = 0; //Enable verbose debug output
                $mail->isSMTP(); //Send using SMTP
                $mail->Host = EMAIL_SMTP; //Set the SMTP server to send through
                $mail->SMTPAuth = true; //Enable SMTP authentication
                $mail->Username = EMAIL_SENDER; //SMTP username
                $mail->Password = EMAIL_PASSWORD; //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
                $mail->Port = EMAIL_PORT; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom(EMAIL_SENDER, APP_DOMAIN);
                $mail->addAddress(EMAIL_RECEIVER); //Add a recipient

                //Content
                $mail->isHTML(true); //Set email format to HTML
                $mail->Subject = EMAIL_MSG_2;

                //Email info
                $html = '<h3>Um cliente solicitou um agendamento com você! </h3>';
                $html .= '<p><b>Informações do cliente:</b></p>';
                $html .= '<p><b>Nome:</b> ' . $client_name . '</p>';
                $html .= '<p><b>Email:</b> ' . $client_email . '</p>';
                $html .= '<p><b>Número:</b> ' . $client_number . '</p>';
                $html .= '<p><b>Mensagem:</b> ' . $client_text . '</p>';

                $html .= '<a href="#" target="_blank">' . APP_DOMAIN . '</a><br>';

                $html .= '<a href="https://api.whatsapp.com/send?phone=' . APP_SUPPORT . '" target="_blank">Suporte</a>';

                $mail->Body = $html;


                $mail->send();

                $_SESSION['error'] = false;
                $_SESSION['msg'] = "Email enviado com sucesso!";

                Functions::redirect('contact_email_sent');
                return;

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            


        } else { //Schedule request email will be sent

            $client_name = $name;
            $client_email = $email;
            $client_number = $number;
            $client_text = $text;
            $client_schedule_date = $date;
            $client_schedule_hour = $hour;

            //Checks for empty fields
            if (
                empty($client_name)
                || empty($client_email)
                || empty($client_number)
                || empty($client_text)
                || empty($client_schedule_date)
                || empty($client_schedule_hour)
            ) {

                $_SESSION['error'] = "Campos vazios!";
                Functions::redirect('schedule');
                return;

            } else {

                try {
                    //Server settings
                    $mail->SMTPDebug = 0; //Enable verbose debug output
                    $mail->isSMTP(); //Send using SMTP
                    $mail->Host = EMAIL_SMTP; //Set the SMTP server to send through
                    $mail->SMTPAuth = true; //Enable SMTP authentication
                    $mail->Username = EMAIL_SENDER; //SMTP username
                    $mail->Password = EMAIL_PASSWORD; //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
                    $mail->Port = EMAIL_PORT; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom(EMAIL_SENDER, APP_DOMAIN);
                    $mail->addAddress(EMAIL_RECEIVER); //Add a recipient

                    //Content
                    $mail->isHTML(true); //Set email format to HTML
                    $mail->Subject = EMAIL_MSG_2;

                    //Email info
                    $html = '<h3>Um cliente solicitou um agendamento com você! </h3>';
                    $html .= '<p><b>Informações do cliente:</b></p>';
                    $html .= '<p><b>Nome:</b> ' . $client_name . '</p>';
                    $html .= '<p><b>Email:</b> ' . $client_email . '</p>';
                    $html .= '<p><b>Número:</b> ' . $client_number . '</p>';
                    $html .= '<p><b>Mensagem:</b> ' . $client_text . '</p>';
                    $html .= '<p><b>Data desejada:</b> ' . $client_schedule_date . '</p>';
                    $html .= '<p><b>Hora desejada:</b> ' . $client_schedule_hour . '</p>';
                    $html .= '<br>';
                    $html .= '<a href="' . APP_BASE_URL . '?a=save_new_schedule&data=' . $client_schedule_date  . '/' . $client_schedule_hour . '" target="_blank">Clique aqui para aceitar</a>';
                    $html .= '<br>';

                    $html .= '<a href="#" target="_blank">' . APP_DOMAIN . '</a><br>';

                    $html .= '<a href="https://api.whatsapp.com/send?phone=' . APP_SUPPORT . '" target="_blank">Suporte</a>';

                    $mail->Body = $html;

                    $mail->send();

                    $_SESSION['error'] = false;
                    $_SESSION['msg'] = "Pedido de agendamento enviado com sucesso!";
                    
                    Functions::redirect('schedule_request_email_sent');
                    return;

                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }
    }
}
