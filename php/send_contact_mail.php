<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';



	//Import PHPMailer classes stored in C:\PHPMailer into the global namespace
	//These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	use PHPMailer\PHPMailer\SMTP;

	//Load Composer's autoloader
	require 'c:\PHPMailer\src\Exception.php';
	require 'c:\PHPMailer\src\PHPMailer.php';
	require 'c:\PHPMailer\src\SMTP.php';

/*

	//Import PHPMailer classes into the global namespace
	//These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	//Load Composer's autoloader
	require '/home/fcwmedun/vendor/autoload.php';

	//Load Composer's autoloader
	require '/home/fcwmedun/PHPMailer/src/Exception.php';
	require '/home/fcwmedun/PHPMailer/src/PHPMailer.php';
	require '/home/fcwmedun/PHPMailer/src/SMTP.php';
*/


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->SMTPDebug = 0;                      // Enable verbose debug output
        $mail->isSMTP();                           // Set mailer to use SMTP
        $mail->Host       = 'smtp.example.com';    // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                  // Enable SMTP authentication
        $mail->Username   = 'your_email@example.com';  // SMTP username
        $mail->Password   = 'your_email_password'; // SMTP password
        $mail->SMTPSecure = 'tls';                 // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 587;                   // TCP port to connect to

        //Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('info@boanig.com');      // Add a recipient
        $mail->addCC('info@shegnetkonsult.com.ng'); // Add a carbon copy

        // Content
        $mail->isHTML(true);                       // Set email format to HTML
        $mail->Subject = 'Contact Form Submission from ' . $name;
        $mail->Body    = '<p>Name: ' . $name . '</p><p>Email: ' . $email . '</p><p>Message: ' . $message . '</p>';
        $mail->AltBody = 'Name: ' . $name . '\nEmail: ' . $email . '\n\nMessage:\n' . $message;

        $mail->send();
        echo 'Message sent successfully!';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
} else {
    echo 'Invalid request method.';
}
?>
