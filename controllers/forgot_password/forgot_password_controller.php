<?php
header('Content-Type: application/json');
require_once __DIR__ ."/../../config.php";
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('Asia/Manila');
$conn = Database::connect();

function sendResetEmail($to, $resetLink) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = "your_email@gmail.com";         // 🔐 your email
        $mail->Password   = 'abcdefghijklmnop';            // 🔐 Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('your_email@gmail.com', 'Sentimo');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset';
        $mail->Body    = "Click to <b>reset your password</b> in Sentimo: <a href='$resetLink'>$resetLink</a><br>This link will expire in 1 hour.<br>If you did not request this, please ignore this email and <b>do not forward the link to anyone</b>.";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Only POST allowed']);
    exit;
}

//Gets user id of entered email
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($user_id);

// Check if email exists in database
if ($stmt->fetch()) {
    $stmt->close();

    // Check if token already sent
    $stmt = $conn->prepare("SELECT token FROM password_resets WHERE user_id = ? AND expires_at > NOW()");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($existing_token);

    //If token already sent and is not expired
    if ($stmt->fetch()) {
        $stmt->close();
        $resetLink = "http://localhost/project-sentiment-analysis/reset_password.php?token=$existing_token";
        //sendResetEmail($email, $resetLink);
        echo json_encode(['status' => 'info', 'message' => 'Reset link already sent. Check your email.']);
        exit;
    }
    //If token expired or not sent yet
    $stmt->close();

    // Generate token
    $token = bin2hex(random_bytes(32));
    $resetLink = "http://localhost/project-sentiment-analysis/reset_password.php?token=$token";
    if (!sendResetEmail($email, $resetLink)) {
        echo json_encode(['status' => 'error', 'message' => 'Email could not be sent.']);
        exit;
    }
    else{
        //Save new token if it expired
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));
        $sql = "INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $user_id, $token, $expires);
        $stmt->execute();
        $stmt->close();
        echo json_encode(['status' => 'success', 'message' => 'A reset link has been sent to your email. The link expires in 1 hour.']);
        exit;
    }
}
// If email not found in database
else{
    $stmt->close();
    echo json_encode(['status' => 'error', 'message' => 'You have no account yet. Please register.']);
    exit;
}


?>