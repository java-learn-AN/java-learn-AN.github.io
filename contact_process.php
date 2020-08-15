<?php

include dirname(dirname(__FILE__)).'/mail.php';

error_reporting (E_ALL ^ E_NOTICE);

$post = (!empty($_POST)) ? true : false;

if($post)
{
include 'email_validation.php';

$name = stripslashes($_POST['name']);
$email = trim($_POST['email']);
$subject = stripslashes($_POST['subject']);
$message = stripslashes($_POST['message']);


$error = '';

// Check name

if(!$name)
{
$error .= 'Пожалуйста, укажите Ваше имя.<br />';
}

// Check email

if(!$email)
{
$error .= 'Пожалуйста, укажите Ваш адрес.<br />';
}

if($email && !ValidateEmail($email))
{
$error .= 'Пожалуйста, введите правильный e-mail.<br />';
}

// Check message (length)

if(!$message || strlen($message) < 10)
{
$error .= "Пожалуйста, введите свое сообщение. Оно должно содержать не менее 10 символов.<br />";
}


if(!$error)
{
$mail = mail(CONTACT_FORM, $subject, $message,
     "From: ".$name." <".$email.">\r\n"
    ."Reply-To: ".$email."\r\n"
    ."X-Mailer: PHP/" . phpversion());


if($mail)
{
echo 'OK';
}

}
else
{
echo '<div class="notification_error">'.$error.'</div>';
}

}
?>