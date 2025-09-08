<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Return JSON response
header('Content-Type: application/json');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $age = $_POST['age'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $location = $_POST['location'] ?? '';
    $occupation = $_POST['occupation'] ?? '';
    $religion = $_POST['religion'] ?? '';
    $relationshipStatus = $_POST['relationshipStatus'] ?? '';
    $skills = isset($_POST['skills']) ? implode(', ', $_POST['skills']) : '';
    $about = $_POST['about'] ?? '';
    
    // Validate required fields
    if (empty($firstName) || empty($lastName) || empty($email) || empty($about)) {
        echo json_encode(['success' => false, 'message' => 'Required fields are missing.']);
        exit;
    }
    
    // Create email content
    $subject = "New Personal Information Form Submission from $firstName $lastName";
    
    $message = "
    <html>
    <head>
        <title>Personal Information Form Submission</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .header { background: #2c3e50; color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; }
            .field { margin-bottom: 15px; }
            .field-label { font-weight: bold; color: #2c3e50; }
        </style>
    </head>
    <body>
        <div class='header'>
            <h2>Personal Information Form Submission</h2>
        </div>
        <div class='content'>
            <div class='field'><span class='field-label'>Name:</span> $firstName $lastName</div>
            <div class='field'><span class='field-label'>Age:</span> $age</div>
            <div class='field'><span class='field-label'>Gender:</span> $gender</div>
            <div class='field'><span class='field-label'>Email:</span> $email</div>
            <div class='field'><span class='field-label'>Phone:</span> $phone</div>
            <div class='field'><span class='field-label'>Location:</span> $location</div>
            <div class='field'><span class='field-label'>Occupation:</span> $occupation</div>
            <div class='field'><span class='field-label'>Religion:</span> $religion</div>
            <div class='field'><span class='field-label'>Relationship Status:</span> $relationshipStatus</div>
            <div class='field'><span class='field-label'>Skills:</span> $skills</div>
            <div class='field'><span class='field-label'>About:</span> $about</div>
        </div>
    </body>
    </html>
    ";
    
    try {
        // Create PHPMailer instance
        $mail = new PHPMailer(true);
        
        // Server settings
        $mail->isSMTP();
        /*
        $mail->Host = 'smtp.gmail.com'; // Set your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'imranasalis17@gmail.com'; // SMTP username
        $mail->Password = 'jqxlnnkxzkguxbap'; // SMTP password (use app password for Gmail)
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        */
        $mail->Host = getenv('SMTP_HOST');
$mail->SMTPAuth = getenv('SMTP_AUTH') === 'true';
$mail->Username = getenv('SMTP_USER');
$mail->Password = getenv('SMTP_PASS');
$mail->SMTPSecure = getenv('SMTP_SECURE');
$mail->Port = getenv('SMTP_PORT');
        
        // Recipients
        $mail->setFrom('imranasalis17@gmail.com', 'Form Handler');
        $mail->addAddress('imranasalis17@gmail.com', 'Recipient Name'); // Add a recipient
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = strip_tags($message);
        
        // Send email
        $mail->send();
        
        echo json_encode(['success' => true, 'message' => 'Email sent successfully.']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => "Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
