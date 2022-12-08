<!-- how to send email using php
Go to \xampp\php and open the php.ini file.
Find [mail function] by pressing ctrl + f.
Search and pass the following values:
SMTP=smtp.gmail.com
smtp_port=587
sendmail_from = YourGmailId@gmail.com
sendmail_path = "\"C:\xampp\sendmail\sendmail.exe\" -t"


Now, go to C:\xampp\sendmail and open the sendmail.ini file.

Find [sendmail] by pressing ctrl + f.
Search and pass the following values
smtp_server=smtp.gmail.com
smtp_port=587 or 25 //use any of them
error_logfile=error.log
debug_logfile=debug.log
auth_username=YourGmailId@gmail.com
for the password first turn on 2-step verification
and use app password
auth_password=Your-Gmail-Password
force_sender=YourGmailId@gmail.com(optional) -->



<?php
$to_email = "information11993@gmail.com";
$subject = "Happy";
$body = "Hey what's up this is the second mail using php";
$headers = "From: information11993@gmail.com";

if (mail($to_email, $subject, $body, $headers)) {
    echo "Email successfully sent to $to_email...";
} else {
    echo "Email sending failed...";
}

?>