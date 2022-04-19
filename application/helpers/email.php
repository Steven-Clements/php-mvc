<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* ~ ~ ~ ~ ~ ${ Handle External Email Communications } ~ ~ ~ ~ ~ */
function sendVerificationEmail($email, $code) {
  $mail = new PHPMailer(true);

  try {
    $mail->isSMTP();
    $mail->Host = EMAIL_HOST;
    $mail->SMTPAuth = true;
    $mail->Username = EMAIL_USER;
    $mail->Password = EMAIL_PASS;
    $mail->Port = EMAIL_PORT;

    $mail->setFrom('develop@clementine-solutions.com', 'Family Feed');
    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Verify Your Email';
    $mail->Body    = $code;
    $mail->AltBody = $code;

    $mail->send();
    return true;
  } catch (Exception $e) {
    return false;
  }
}