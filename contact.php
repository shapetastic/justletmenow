<?php
// Just Let Me Now — contact form handler.
// Receives the POST from contact.html, emails ashacks@gmail.com, then redirects
// back to contact.html with ?sent=1 (success) or ?error=1 (problem).

$TO      = 'ashacks@gmail.com';
$SUBJECT = 'New enquiry from justletmenow.com';

function redirect($qs) {
    header('Location: contact.html?' . $qs);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('');
}

// Honeypot — bots fill this hidden field; humans never see it. Pretend success.
if (!empty($_POST['website'])) {
    redirect('sent=1');
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    redirect('error=validation');
}

// Strip newlines from header-bound fields to prevent header injection.
$safeName  = str_replace(["\r", "\n"], ' ', $name);
$safeEmail = str_replace(["\r", "\n"], ' ', $email);

$body  = "New enquiry from the Just Let Me Now website:\n\n";
$body .= "Name:  $safeName\n";
$body .= "Email: $safeEmail\n\n";
$body .= "Message:\n$message\n";

$headers  = "From: Just Let Me Now <noreply@justletmenow.com>\r\n";
$headers .= "Reply-To: $safeName <$safeEmail>\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (@mail($TO, $SUBJECT, $body, $headers)) {
    redirect('sent=1');
} else {
    redirect('error=send');
}
