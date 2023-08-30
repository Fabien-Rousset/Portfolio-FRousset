<?php

require_once "./../vendor/autoload.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $receiving_email_address = 'fabien.rousset@icloud.com';
  if (empty($_POST['subject'])) {
    echo "Le sujet doit être rempli.";
    return;
  }
  if (empty($_POST['name'])) {
    echo "Le nom doit être rempli.";
    return;
  }
  if (empty($_POST['email'])) {
    echo "L'email doit être rempli.";
    return;
  }
  if (empty($_POST['message'])) {
    echo "Le message doit être rempli.";
    return;
  }

  // Créer le transport SMTP
  $transport = (new Swift_SmtpTransport('smtp.ionos.fr', 465, 'ssl'))
    ->setUsername('contact@fabien-rousset.fr')
    ->setPassword('B6ik@XWgPeahvY?');

  // Créer le mailer en utilisant le transport
  $mailer = new Swift_Mailer($transport);

  // Créer le message
  $message = (new Swift_Message($_POST['subject']))
    ->setFrom(['contact@fabien-rousset.fr' => 'BOT Contact'])
    ->setTo(['fabien.rousset@icloud.com' => 'Fabien Rousset'])
    ->setReplyTo([$_POST['email'] => $_POST['name']])
    ->setBody($_POST['message']);

  // Envoyer le message
  if ($mailer->send($message)) {
    echo 'OK';
  } else {
    echo 'Une erreur est survenue lors de l\'envoi du message';
  }
}
